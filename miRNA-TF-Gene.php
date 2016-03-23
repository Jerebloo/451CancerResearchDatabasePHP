

<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../favicon.ico">
    <title>Analysis page</title>
    <!-- Bootstrap core CSS -->
    <link href="bootstrap-3.3.5-dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="tabsStyle.css" rel="stylesheet">
   <link rel="stylesheet" href="newG.css">
     <script src="http://d3js.org/d3.v3.min.js" charset="utf-8"></script>
    <script src="tabScript.js"></script>
    <script src="table.js"></script>
    <link rel="stylesheet" href="table.css">
     <link rel="stylesheet" href="googleTableCss.css">
    <script src= "http://www.google.com/uds/modules/gviz/gviz-api.js"> </script>
    <script src= "https://www.google.com/jsapi"> </script>
    <script type="text/javascript">
        google.load('visualization', '1', {packages: ['table']});
    </script>
</head>
    <div class="container">
        <!-- Static navbar -->
        <nav class="navbar navbar-default">
            <div class="container-fluid">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="#">Cancer Research Database</a>
                </div>
                <div id="navbar" class="navbar-collapse collapse">
                    <ul class="nav navbar-nav">
                        <li><a href="Home.html">Home</a></li>
                        <li><a href="Search.php">Search</a></li>
                        <li><a href="Analysis.php">Analysis</a></li>
                         <li><a href="miRNA-disease.php">miRNA-disease</a></li>
                         <li class="active"><a href="miRNA-TF-Gene.php">miRNA-TF-Gene</a></li>
                         <li><a>miRNA-Drug</a></li>
                        <li><a>miRNA methylation</a></li>
                        
                    </ul>
                </div><!--/.nav-collapse -->
        </nav>
        <!-- Main component for a primary marketing message or call to action -->
        <div class="home">
         
            <p>This page will alow you to search the database.</p>
        </div>


            <div>

                <form ="" method='post'>
                
               <p>Enter miRNAs: <p> 
               <tr><td><textarea name="mirna" value="" rows = "3" cols="80"></textarea></td></tr>
               <p>Enter Genes: <p> 
               <tr><td><textarea name="gene" value="" rows = "3" cols="80"></textarea></td></tr>
               <p>Enter TF: <p> 
               <tr><td><textarea name="tf" value="" rows = "3" cols="80"></textarea></td></tr>
                
                <input type="submit" name="submit" value="Submit"></form>      
                
            </div>


            <div class="row">
      <div class="col-sm-3"></div>
      <div class="col-sm-6"> </div>
      <!--  style="display: none" -->
      <div class="col-sm-3"></div>
    </div>
    <div id="table"></div>
    <span id="pageCnt"></span>
    <div class="col-lg-8 col-md-6 col-sm-6" id="graph">
                        </div>  

<?php

if ( ! empty($_POST['mirna']) and ! empty($_POST['gene']) and ! empty($_POST['tf'])){
   

require_once("dBaseAccess.php");

$mirna = mysqli_real_escape_string($mirnabDb, $_POST['mirna']);
        
       $trimmed = array();
               $str = preg_split('/,/', $mirna);
            $str = preg_split('/[,|\r\n|\r|\n]+/', $mirna);
        //echo json_encode($str);
            for ($i=0;$i<count($str);$i++) {
                    $trimmed[$i] = trim($str[$i]);
            }

        $mirnaString = implode("','", $trimmed);
        $mirnaString = str_replace('\r\n',"','" , $mirnaString);

$gene = mysqli_real_escape_string($mirnabDb, $_POST['gene']);

        $trimmed2 = array();
               $str2 = preg_split('/,/', $gene);
            $str2 = preg_split('/[,|\r\n|\r|\n]+/', $gene);
        //echo json_encode($str);
            for ($h=0;$h<count($str2);$h++) {
                    $trimmed2[$h] = trim($str2[$h]);
            }

        $geneString = implode("','", $trimmed2);
        $geneString = str_replace('\r\n',"','" , $geneString);

$tf = mysqli_real_escape_string($mirnabDb, $_POST['tf']);

        $trimmed3 = array();
               $str3 = preg_split('/,/', $tf);
            $str3 = preg_split('/[,|\r\n|\r|\n]+/', $tf);
        //echo json_encode($str);
            for ($j=0;$j<count($str3);$j++) {
                    $trimmed3[$j] = trim($str3[$j]);
            }

        $tfString = implode("','", $trimmed3);
        $tfString = str_replace('\r\n',"','" , $tfString);
        
        $query = 
          "SELECT 
            distinct 
                mirna_name as source, 
                up_tf as target, 
                gene_name as type, 
                gene_pubId
            from main_v2, upstream_tf,gene_v2
            where main_v2.link_id = upstream_tf.link_id
            and main_v2.link_id = gene_v2.link_id
            and mirna_name in ('".$mirnaString."')
            and up_tf in ('".$tfString."')
            and gene_name in ('".$geneString."')
            limit 30";         

$result = mysqli_query($mirnabDb,$query);

//echo $result;

 if ( ! $result ) {
        echo mysql_error();
        die;
    }

$data = array();

  for ($x = 0; $x < mysqli_num_rows($result); $x++) {
        $data[] = mysqli_fetch_assoc($result);
    }

$jsonForm = json_encode($data);

}// end if check for all 3 inputs

else if ( ! empty($_POST['mirna']) and ! empty($_POST['gene']) and empty($_POST['tf'])){
   

require_once("dBaseAccess.php");

$mirna = mysqli_real_escape_string($mirnabDb, $_POST['mirna']);
        
       $trimmed = array();
               $str = preg_split('/,/', $mirna);
            $str = preg_split('/[,|\r\n|\r|\n]+/', $mirna);
        //echo json_encode($str);
            for ($i=0;$i<count($str);$i++) {
                    $trimmed[$i] = trim($str[$i]);
            }

        $mirnaString = implode("','", $trimmed);
        $mirnaString = str_replace('\r\n',"','" , $mirnaString);

$gene = mysqli_real_escape_string($mirnabDb, $_POST['gene']);

        $trimmed2 = array();
               $str2 = preg_split('/,/', $gene);
            $str2 = preg_split('/[,|\r\n|\r|\n]+/', $gene);
        //echo json_encode($str);
            for ($h=0;$h<count($str2);$h++) {
                    $trimmed2[$h] = trim($str2[$h]);
            }

        $geneString = implode("','", $trimmed2);
        $geneString = str_replace('\r\n',"','" , $geneString);
        
        $query = 
          "SELECT 
            distinct 
                mirna_name as source, 
                up_tf as target, 
                gene_name as type, 
                gene_pubId
            from main_v2, upstream_tf,gene_v2
            where main_v2.link_id = upstream_tf.link_id
            and main_v2.link_id = gene_v2.link_id
            and mirna_name in ('".$mirnaString."')
            and gene_name in ('".$geneString."')
            limit 30";         

$result = mysqli_query($mirnabDb,$query);

//echo $result;

 if ( ! $result ) {
        echo mysql_error();
        die;
    }

$data = array();

  for ($x = 0; $x < mysqli_num_rows($result); $x++) {
        $data[] = mysqli_fetch_assoc($result);
    }

$jsonForm = json_encode($data);

}

else if ( ! empty($_POST['mirna']) and empty($_POST['gene']) and !empty($_POST['tf'])){
   

require_once("dBaseAccess.php");

$mirna = mysqli_real_escape_string($mirnabDb, $_POST['mirna']);
        
       $trimmed = array();
               $str = preg_split('/,/', $mirna);
            $str = preg_split('/[,|\r\n|\r|\n]+/', $mirna);
        //echo json_encode($str);
            for ($i=0;$i<count($str);$i++) {
                    $trimmed[$i] = trim($str[$i]);
            }

        $mirnaString = implode("','", $trimmed);
        $mirnaString = str_replace('\r\n',"','" , $mirnaString);

$tf = mysqli_real_escape_string($mirnabDb, $_POST['tf']);

        $trimmed3 = array();
               $str3 = preg_split('/,/', $tf);
            $str3 = preg_split('/[,|\r\n|\r|\n]+/', $tf);
        //echo json_encode($str);
            for ($j=0;$j<count($str3);$j++) {
                    $trimmed3[$j] = trim($str3[$j]);
            }

        $tfString = implode("','", $trimmed3);
        $tfString = str_replace('\r\n',"','" , $tfString);
        
        $query = 
          "SELECT 
            distinct 
                mirna_name as source, 
                up_tf as target, 
                gene_name as type, 
                gene_pubId
            from main_v2, upstream_tf,gene_v2
            where main_v2.link_id = upstream_tf.link_id
            and main_v2.link_id = gene_v2.link_id
            and mirna_name in ('".$mirnaString."')
            and up_tf in ('".$tfString."')
            limit 30";         

$result = mysqli_query($mirnabDb,$query);

//echo $result;

 if ( ! $result ) {
        echo mysql_error();
        die;
    }

$data = array();

  for ($x = 0; $x < mysqli_num_rows($result); $x++) {
        $data[] = mysqli_fetch_assoc($result);
    }

$jsonForm = json_encode($data);

}

else if (  empty($_POST['mirna']) and ! empty($_POST['gene']) and ! empty($_POST['tf'])){
   

require_once("dBaseAccess.php");

$gene = mysqli_real_escape_string($mirnabDb, $_POST['gene']);

        $trimmed2 = array();
               $str2 = preg_split('/,/', $gene);
            $str2 = preg_split('/[,|\r\n|\r|\n]+/', $gene);
        //echo json_encode($str);
            for ($h=0;$h<count($str2);$h++) {
                    $trimmed2[$h] = trim($str2[$h]);
            }

        $geneString = implode("','", $trimmed2);
        $geneString = str_replace('\r\n',"','" , $geneString);

$tf = mysqli_real_escape_string($mirnabDb, $_POST['tf']);

        $trimmed3 = array();
               $str3 = preg_split('/,/', $tf);
            $str3 = preg_split('/[,|\r\n|\r|\n]+/', $tf);
        //echo json_encode($str);
            for ($j=0;$j<count($str3);$j++) {
                    $trimmed3[$j] = trim($str3[$j]);
            }

        $tfString = implode("','", $trimmed3);
        $tfString = str_replace('\r\n',"','" , $tfString);
        
        $query = 
          "SELECT 
            distinct 
                mirna_name as source, 
                up_tf as target, 
                gene_name as type, 
                gene_pubId
            from main_v2, upstream_tf,gene_v2
            where main_v2.link_id = upstream_tf.link_id
            and main_v2.link_id = gene_v2.link_id
            and up_tf in ('".$tfString."')
            and gene_name in ('".$geneString."')
            limit 30";         

$result = mysqli_query($mirnabDb,$query);

//echo $result;

 if ( ! $result ) {
        echo mysql_error();
        die;
    }

$data = array();

  for ($x = 0; $x < mysqli_num_rows($result); $x++) {
        $data[] = mysqli_fetch_assoc($result);
    }

$jsonForm = json_encode($data);

}

else if ( ! empty($_POST['mirna']) and empty($_POST['gene']) and empty($_POST['tf'])){
   

require_once("dBaseAccess.php");

$mirna = mysqli_real_escape_string($mirnabDb, $_POST['mirna']);
        
       $trimmed = array();
               $str = preg_split('/,/', $mirna);
            $str = preg_split('/[,|\r\n|\r|\n]+/', $mirna);
        //echo json_encode($str);
            for ($i=0;$i<count($str);$i++) {
                    $trimmed[$i] = trim($str[$i]);
            }

        $mirnaString = implode("','", $trimmed);
        $mirnaString = str_replace('\r\n',"','" , $mirnaString);
        
        $query = 
          "SELECT 
            distinct 
                mirna_name as source, 
                up_tf as target, 
                gene_name as type, 
                gene_pubId
            from main_v2, upstream_tf,gene_v2
            where main_v2.link_id = upstream_tf.link_id
            and main_v2.link_id = gene_v2.link_id
            and mirna_name in ('".$mirnaString."')
            limit 50";         

$result = mysqli_query($mirnabDb,$query);

//echo $result;

 if ( ! $result ) {
        echo mysql_error();
        die;
    }

$data = array();

  for ($x = 0; $x < mysqli_num_rows($result); $x++) {
        $data[] = mysqli_fetch_assoc($result);
    }

$jsonForm = json_encode($data);

}

else if (  empty($_POST['mirna']) and ! empty($_POST['gene']) and empty($_POST['tf'])){
   

require_once("dBaseAccess.php");

$gene = mysqli_real_escape_string($mirnabDb, $_POST['gene']);

        $trimmed2 = array();
               $str2 = preg_split('/,/', $gene);
            $str2 = preg_split('/[,|\r\n|\r|\n]+/', $gene);
        //echo json_encode($str);
            for ($h=0;$h<count($str2);$h++) {
                    $trimmed2[$h] = trim($str2[$h]);
            }

        $geneString = implode("','", $trimmed2);
        $geneString = str_replace('\r\n',"','" , $geneString);

        
        $query = 
          "SELECT 
            distinct 
                mirna_name as source, 
                up_tf as target, 
                gene_name as type, 
                gene_pubId
            from main_v2, upstream_tf,gene_v2
            where main_v2.link_id = upstream_tf.link_id
            and main_v2.link_id = gene_v2.link_id
            and gene_name in ('".$geneString."')
            limit 50";         

$result = mysqli_query($mirnabDb,$query);

//echo $result;

 if ( ! $result ) {
        echo mysql_error();
        die;
    }

$data = array();

  for ($x = 0; $x < mysqli_num_rows($result); $x++) {
        $data[] = mysqli_fetch_assoc($result);
    }

$jsonForm = json_encode($data);

}

else if (  empty($_POST['mirna']) and empty($_POST['gene']) and !empty($_POST['tf'])){
   

require_once("dBaseAccess.php");

        $tf = mysqli_real_escape_string($mirnabDb, $_POST['tf']);

        $trimmed3 = array();
               $str3 = preg_split('/,/', $tf);
            $str3 = preg_split('/[,|\r\n|\r|\n]+/', $tf);
        //echo json_encode($str);
            for ($j=0;$j<count($str3);$j++) {
                    $trimmed3[$j] = trim($str3[$j]);
            }

        $tfString = implode("','", $trimmed3);
        $tfString = str_replace('\r\n',"','" , $tfString);
        
        $query = 
          "SELECT 
            distinct 
                mirna_name as source, 
                up_tf as target, 
                gene_name as type, 
                gene_pubId
            from main_v2, upstream_tf,gene_v2
            where main_v2.link_id = upstream_tf.link_id
            and main_v2.link_id = gene_v2.link_id
            and up_tf in ('".$tfString."')
            limit 50";

echo $query;         

$result = mysqli_query($mirnabDb,$query);

//echo $result;

 if ( ! $result ) {
        echo mysql_error();
        die;
    }

$data = array();

  for ($x = 0; $x < mysqli_num_rows($result); $x++) {
        $data[] = mysqli_fetch_assoc($result);
    }

$jsonForm = json_encode($data);

}
  
else if (  empty($_POST['mirna']) and  empty($_POST['gene']) and empty($_POST['tf'])){
   

require_once("dBaseAccess.php");
        
        $query = 
          "SELECT 
            distinct 
                mirna_name as source, 
                up_tf as target, 
                gene_name as type, 
                gene_pubId
            from main_v2, upstream_tf,gene_v2
            where main_v2.link_id = upstream_tf.link_id
            and main_v2.link_id = gene_v2.link_id
            limit 50";         

$result = mysqli_query($mirnabDb,$query);

//echo $result;

 if ( ! $result ) {
        echo mysql_error();
        die;
    }

$data = array();

  for ($x = 0; $x < mysqli_num_rows($result); $x++) {
        $data[] = mysqli_fetch_assoc($result);
    }

$jsonForm = json_encode($data);

}

?>

<script>
   function drawTable(jsonData) {
    
    var dataT = new google.visualization.DataTable();
    var numRows = jsonData.length;
    dataT.addRows(numRows);
    console.log(numRows, " rows added");

    dataT.addColumn('string', 'miRNA');
    dataT.addColumn('string', 'TF');
    dataT.addColumn('string', 'Gene');
    dataT.addColumn('string', 'PubId');

    var url = '',
        pubmed = '';

    for (var iter = 0; iter < numRows; iter++) {
        dataT.setCell(iter, 0, jsonData[iter]['source']);
        dataT.setCell(iter, 1, jsonData[iter]['target']);
        dataT.setCell(iter, 2, jsonData[iter]['type']);
        dataT.setCell(iter, 3, jsonData[iter]['gene_pubId']);
    };

    var options = {allowHtml: true, alternatingRowStyle: true}; 
    //options['cssClassNames'] = cssNamesOne;
    options['page'] = 'enable'; options['pageSize'] = 10; options['pagingSymbols'] = {prev: 'prev', next: 'next'}; //options['pagingButtonsConfiguration'] = 'auto';
    
    var table = new google.visualization.Table(document.getElementById('table'));
    table.draw(dataT, options); // , {showRowNumber: true, width: '100%', height: '100%'});
  }
</script>


<script src="newGraph.js"></script>

<script>
var jsonForm = <?php echo $jsonForm; ?>;

drawTable(jsonForm);

createGraph(jsonForm,"#graph");


</script>  

    </div><!--/.container-fluid -->
     
            
     <!-- /container -->
    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="bootstrap-3.3.5-dist/js/bootstrap.min.js"></script>
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
   

</html>