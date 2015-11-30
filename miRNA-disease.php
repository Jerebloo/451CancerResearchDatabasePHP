

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
                    <a class="navbar-brand" href="#">Project name</a>
                </div>
                <div id="navbar" class="navbar-collapse collapse">
                    <ul class="nav navbar-nav">
                        <li><a href="Home.html">Home</a></li>
                        <li><a href="Search.php">Search</a></li>
                        <li><a href="Analysis.php">Analysis</a></li>
                         <li class="active"><a href="miRNA-disease.php">miRNA-disease</a></li>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Dropdown <span class="caret"></span></a>
                            <ul class="dropdown-menu">
                                <li><a href="#">Action</a></li>
                                <li><a href="#">Another action</a></li>
                                <li><a href="#">Something else here</a></li>
                                <li role="separator" class="divider"></li>
                                <li class="dropdown-header">Nav header</li>
                                <li><a href="#">Separated link</a></li>
                                <li><a href="#">One more separated link</a></li>
                            </ul>
                        </li>
                    </ul>
                </div><!--/.nav-collapse -->
        </nav>
        <!-- Main component for a primary marketing message or call to action -->
        <div class="home">
         
            <p>This page will alow you to search the database.</p>
        </div>
    
        <ul id="tabs">
            <li><a href="#about">Tab1</a></li>
            <li><a href="#tab2">Tab2</a></li>
        </ul>

        <div class="tabContent" id="about">
            <h2>Please enter a query</h2>
            <div>
                <form ="" method='post'>
                
                <input type = "text" name="user" value ="">
                
                
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
        //echo json_encode($str);
            for ($i=0;$i<count($str);$i++) {
                    $trimmed[$i] = trim($str[$i]);
            }

        $strNew = implode("','", $trimmed);

        echo $strNew;
        
        $query = 
           "SELECT mirna_name AS source
           , dis_name AS target
           , dis_reguln AS type
           , dis_pubId 
                from main_v2, disease 
                where main_v2.link_id = disease.link_id
                AND mirna_name in ('hsa-mir-127')
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


createTable(jsonForm,"#table"); 
createGraph(jsonForm,"#graph");


</script>  

         
 
        </div>

<div class="tabContent" id="tab2">
            <h2>Please enter a query</h2>
            <div>
                <form ="" method='post'>
                
                <input type = "text" name="user2" value ="">
                
                
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
        //echo json_encode($str);
            for ($i=0;$i<count($str);$i++) {
                    $trimmed[$i] = trim($str[$i]);
            }

        $strNew = implode("','", $trimmed);

        //echo $strNew;
        
        $query = 
           "SELECT mirna_name AS source
           , dis_name AS target
           , dis_reguln AS type
           , dis_pubId 
                from main_v2, disease 
                where main_v2.link_id = disease.link_id
                AND dis_name in ('".$strNew."')
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


createTable(jsonForm2,"#table"); 
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