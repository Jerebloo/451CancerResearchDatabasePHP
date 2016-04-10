

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
    <link rel="stylesheet" href="mSTG.css">
    <link href="css/mystyles.css" rel="stylesheet">
    <link href="css/font-awesome.min.css" rel="stylesheet">
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
<!--all needed tools are included in the head, these are : D3, google table, bootstrap, css files for the graph, tabs and table -->
</head>

<body onload="init()"> 
    <div class="container">
        <!-- Static navbar -->
        <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
            <div class="container">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="Home.html">iMir</a>
                </div>
                <div id="navbar" class="navbar-collapse collapse">
                    <ul class="nav navbar-nav">
                        <li><a href="Home.html"><span class="glyphicon glyphicon-home"
                            aria-hidden="true"></span> Home</a></li>
                        <li><a href="Search.php"><span class="glyphicon glyphicon-search"
                            aria-hidden="true"></span> Search</a></li>
                        <li><a href="Analysis.php"><span class="glyphicon glyphicon-cog"
                            aria-hidden="true"></span> Analysis</a></li>
                        <li><a href="miRNA-disease.php">miRNA-disease</a></li>
                        <li class = "active"><a href="miRNA-TF-Gene.php">miRNA-TF-Gene</a></li>
                        <li><a href="miRNA-Drug.php">miRNA-Drug</a></li>
                        <li><a href="miRNA-Methylation.php">miRNA methylation</a></li>
                    </ul>
                </div><!--/.nav-collapse -->
            </div><!--/.container-fluid -->
        </nav>
        <!-- the nav div builds the bar at the top of the page, each page is declared in the ul class as a li element -->
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
        <!-- this div builds 3 boxes and places them in a form of method post, what is entered in the 3 boxes will be stored in php -->

            <div class="row">
      <div class="col-sm-3"></div>
      <div class="col-sm-6"> </div>
      <!--  style="display: none" -->
      <div class="col-sm-3"></div>
    </div>
    <div id="table"></div>
    <span id="pageCnt"></span>
    <div  id="graph">
    </div>  
     <!-- this div sizes and places content, in this case the graph and table are going to be attached to the bottom 2 divs -->

<?php

if ( ! empty($_POST['mirna']) and ! empty($_POST['gene']) and ! empty($_POST['tf']))
// check if all 3 boxes are set
{
   
require_once("dBaseAccess.php");
//use your own database connection

$mirna = mysqli_real_escape_string($mirnabDb, $_POST['mirna']);
 //grab the info placed in the text box for mirnas and turn it into a form a query can understand

       $trimmed = array();
               $str = preg_split('/,/', $mirna);
            $str = preg_split('/[,|\r\n|\r|\n]+/', $mirna);
        //echo json_encode($str);
            for ($i=0;$i<count($str);$i++) {
                    $trimmed[$i] = trim($str[$i]);
            }


        $mirnaString = implode("','", $trimmed);
        $mirnaString = str_replace('\r\n',"','" , $mirnaString);
      //multiple  miRNAs are split on commas or newline and single qoutes are added to make mirnaString form a proper list of 
        //miRNAS for the query to recognize

$gene = mysqli_real_escape_string($mirnabDb, $_POST['gene']);
//grab the info placed in the text box for genes and turn it into a form a query can understand

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
//grab the info placed in the text box for tfs and turn it into a form a query can understand

        $trimmed3 = array();
               $str3 = preg_split('/,/', $tf);
            $str3 = preg_split('/[,|\r\n|\r|\n]+/', $tf);
        //echo json_encode($str);
            for ($j=0;$j<count($str3);$j++) {
                    $trimmed3[$j] = trim($str3[$j]);
            }



        $tfString = implode("','", $trimmed3);
        $tfString = str_replace('\r\n',"','" , $tfString);
        
        //split and reformat incoming tfs into the form the query will take

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
            limit 100"; 
            //declares the query that links mirnas to tfs and mirnas to genes         

$result = mysqli_query($mirnabDb,$query);

//echo $result;

 if ( ! $result ) {
        echo mysql_error();
        die;
    }
//checks if the result is indeed a query
$data = array();

  for ($x = 0; $x < mysqli_num_rows($result); $x++) {
        $data[] = mysqli_fetch_assoc($result);
    }
//throws the query result into an array of data

$jsonForm = json_encode($data);

//translates array of data to a json object type

}// end if check for all 3 inputs

else
{
 echo "Please fill all 3 boxes";
 //error message for not having filled all 3 boxes
}

?>

<script>
   function drawTable(jsonData) {
    
    var dataT = new google.visualization.DataTable();
    var numRows = jsonData.length;
    dataT.addRows(numRows);
    console.log(numRows, " rows added");
    
    //declare google table, declare the number of rows

    dataT.addColumn('string', 'miRNA');
    dataT.addColumn('string', 'TF');
    dataT.addColumn('string', 'Gene');
    dataT.addColumn('string', 'PubID');

    //declare the numer and name of the columns

    var url = '', //not used at the moment, will be reintigrated for hyperlink functionality
        pubmed = '';//not used at the moment, will be reintigrated for hyperlink functionality

    for (var iter = 0; iter < numRows; iter++) {
        dataT.setCell(iter, 0, jsonData[iter]['source']);
        dataT.setCell(iter, 1, jsonData[iter]['target']);
        dataT.setCell(iter, 2, jsonData[iter]['type']);
        dataT.setCell(iter, 3, jsonData[iter]['gene_pubId']);
    };
    //grabs the data from the jsonData for the specified columns and places it in a table cell

    var options = {allowHtml: true, alternatingRowStyle: true}; 
    //unsure what this does
    options['page'] = 'enable'; options['pageSize'] = 10; options['pagingSymbols'] = {prev: 'prev', next: 'next'}; //options['pagingButtonsConfiguration'] = 'auto';
    //enables paging

    var table = new google.visualization.Table(document.getElementById('table'));
    //gets the div placement of the table

    table.draw(dataT, options); // unsure what this does
  }
</script>


<script src="multiSourceTargetGraph.js"></script> <!--uses the multiSourceTargetGraph as a reference for building a graph-->

<script>
var jsonForm = <?php echo $jsonForm; ?>; // grabs php variable and stores it in javascript, this is the data from the query

drawTable(jsonForm); // calls the google table function

createGraph(jsonForm,"#graph"); //calls the graph function from the multiSourceTargetGraph


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