﻿<?PHP

require_once("dBaseAccess.php");

$query = 
"select distinct 
    mirna_name AS source, 
    dis_name AS target, 
    dis_reguln AS type
from main_v2 , disease 
where mirna_name = 'hsa-mir-21' 
limit 30";

$result = mysqli_query($mirnabDb,$query);

 if ( ! $result ) {
        echo mysql_error();
        die;
    }

//$data = array();

  for ($x = 0; $x < mysqli_num_rows($result); $x++) {
        $data[] = mysqli_fetch_assoc($result);
    }
$jsonForm = json_encode($data);


?>

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
                        <li class="active"><a href="Analysis.php">Analysis</a></li>
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
            <li><a href="#about">SearchBox</a></li>
            <li><a href="#advantages">Advantages of tabs</a></li>
            <li><a href="#usage">Using tabs</a></li>
        </ul>

        <div class="tabContent" id="about">
            <h2>About JavaScript tabs</h2>
            <div>
                <form =""><textarea cols="30" rows="6"></textarea>
                <br><br>
                <input type="submit" value="Submit"></form>
            </div>
            <div id="graph2">
 <script src="newGraph.js"></script>
<script>
var jsonForm = <?php echo $jsonForm; ?>;

createGraph(jsonForm,"#graph2");

</script>
             </div>
        </div>

        <div class="tabContent" id="advantages">
            <h2>Advantages of tabs</h2>
            <div>
                <textarea cols="30" rows="6"></textarea>
                <br><br>
                <input type="submit" value="Submit">
            </div>
        </div>

        <div class="tabContent" id="usage">
            <h2>Using tabs</h2>
            <div>
                <textarea cols="30" rows="6"></textarea>
                <br><br>
                <input type="submit" value="Submit">
            </div>
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