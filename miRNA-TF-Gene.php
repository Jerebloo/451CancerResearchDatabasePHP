

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
</head>
<body onload="init()">
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
    
        <ul id="tabs">
            <li><a href="#about">Search  miRNA - Gene</a></li>
            <li><a href="#tab2">Search miRNA - TF</a></li>
        </ul>

        <div class="tabContent" id="about">
            <h2>Please enter one or more mirna_name</h2>
            <div>
                <form ="" method='post'>
                
            <tr><td><textarea name="user" value="" rows = "15" cols="80"></textarea></td></tr>
                
                
                <input type="submit" name="submit" value="Submit"></form>

            </div>

            <div class="row">
                        <div class="col-lg-4 col-md-6 col-sm-6" id="table"> 
                        </div>
                        <div class="col-lg-8 col-md-6 col-sm-6" id="graph">
                        </div>
                    </div>


<?php
if ( ! empty($_POST['user'])){
    $name = $_POST['user'];

require_once("dBaseAccess.php");

$mirna = mysqli_real_escape_string($mirnabDb, $_POST['user']);
        
       $trimmed = array();
               $str = preg_split('/,/', $mirna);
            $str = preg_split('/[,|\r\n|\r|\n]+/', $mirna);
        //echo json_encode($str);
            for ($i=0;$i<count($str);$i++) {
                    $trimmed[$i] = trim($str[$i]);
            }

        $strNew = implode("','", $trimmed);
        $strNew = str_replace('\r\n',"','" , $strNew);

        echo $strNew;
        
        $query = 
           "SELECT distinct mirna_name as source
           , gene_name as target
           , gene_pubId as type 
                from main_v2, gene_v2
                where main_v2.link_id = gene_v2.link_id
                AND mirna_name in ('".$strNew."')
                LIMIT 30
                ";

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

//echo $jsonForm;

}

?>


                  <script src="newGraph.js"></script>
<script>
var jsonForm = <?php echo $jsonForm; ?>;


var header = ["miRNA","Gene","PubId"];

createTable(jsonForm,"#table",header,"source"); 
createGraph(jsonForm,"#graph");


</script>  

         
 
        </div>

<div class="tabContent" id="tab2">
            <h2>Please enter one or more up_tf</h2>
            <div>
                <form ="" method='post'>
                
            <tr><td><textarea name="user2" value="" rows = "15" cols="80"></textarea></td></tr>
                
                
                <input type="submit" name="submit" value="Submit"></form>
                              
                
            </div>

            <div class="row">
                        <div class="col-lg-4 col-md-6 col-sm-6" id="table"> 
                        </div>
                        <div class="col-lg-8 col-md-6 col-sm-6" id="graph">
                        </div>
                    </div>


<?php
if ( ! empty($_POST['user2'])){
    $name = $_POST['user2'];

require_once("dBaseAccess.php");

$mirna = mysqli_real_escape_string($mirnabDb, $_POST['user2']);

$trimmed = array();
              $str = preg_split('/,/', $mirna);
            $str = preg_split('/[,|\r\n|\r|\n]+/', $mirna);
        //echo json_encode($str);
            for ($i=0;$i<count($str);$i++) {
                    $trimmed[$i] = trim($str[$i]);
            }

        $strNew = implode("','", $trimmed);
        $strNew = str_replace('\r\n',"','" , $strNew);

        echo $strNew;
        
        $query = 
           "SELECT distinct mirna_name as target
           ,up_tf as source
            , up_regul as type
            , up_pubId 
            from main_v2, upstream_tf
                where main_v2.link_id = upstream_tf.link_id
                AND up_tf in ('".$strNew."')
                LIMIT 30
                ";

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
$jsonForm2 = json_encode($data);

}

?>
<script>
var jsonForm2 = <?php echo $jsonForm2; ?>;


var header = ["miRNA","Tf","Regulation","PubId"];

createTable(jsonForm2,"#table",header,"target"); 
createGraph(jsonForm2,"#graph");


</script>
 
        </div>


    </div><!--/.container-fluid -->
     
            
     <!-- /container -->
    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="bootstrap-3.3.5-dist/js/bootstrap.min.js"></script>
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
   
    

   
</bodyonload="init()">
</html>