

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
    <link href="css/mystyles.css" rel="stylesheet">
    <link href="css/font-awesome.min.css" rel="stylesheet">
    <script src="http://d3js.org/d3.v3.min.js" charset="utf-8"></script>
    <script src="tabScript.js"></script>
    <script src="table.js"></script>
    <link rel="stylesheet" href="table.css">
</head>
<body onload="init()">
    <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="Home.html">LOGO</a>
            </div>
            <div id="navbar" class="navbar-collapse collapse">
                <ul class="nav navbar-nav">
                    <li><a href="Home.html"><span class="glyphicon glyphicon-home"
                         aria-hidden="true"></span> Home</a></li>
                    <li><a href="Search.php"><span class="glyphicon glyphicon-search"
                         aria-hidden="true"></span> Search</a></li>
                    <li class="active"><a href="Analysis.php"><span class="glyphicon glyphicon-cog"
                         aria-hidden="true"></span> Analysis</a></li>
                    <li><a href="miRNA-disease.php">miRNA-disease</a></li>
                    <li><a href="miRNA-TF-Gene.php">miRNA-TF-Gene</a></li>
                    <li><a>miRNA-Drug</a></li>
                    <li><a>miRNA methylation</a></li>
                </ul>
            </div><!--/.nav-collapse -->
        </div><!--/.container-fluid -->
    </nav>
        <!-- Main component for a primary marketing message or call to action -->
        
        <div class="container">
             <p>This page will alow you to search the database.</p>
             
             <ul class="nav nav-tabs">
                <li role="presentation" class="active"><a href="#">SearchBox</a></li>
             </ul>
             <div class="tab-content">
                 <div role="tabpanel" class="tab-pane fade in active">
                    <form method='post'>
                        <input type = "text" name="user" placeholder ="Please enter a query">
                        <input type="submit" name="submit" value="Submit">
                    </form>                    
                </div>                 
             </div>
             <!--<ul id="tabs">
                <li><a href="#about">SearchBox</a></li>
             </ul>

            <div class="tabContent" id="about">
                <h2>Please enter a query</h2>
                <div>
                    <form ="" method='post'>
                    
                    <input type = "text" name="user" value ="">
                    
                    
                    <input type="submit" name="submit" value="Submit"></form>
                                
                    
            </div>-->

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

echo $name;

$result = mysqli_query($mirnabDb,$_POST['user']);

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

         
 
        </div>
    </div><!--/.container-fluid -->
     

                    <script src="newGraph.js"></script>
<script>
var jsonForm = <?php echo $jsonForm; ?>;


createTable(jsonForm,"#table"); 
createGraph(jsonForm,"#graph");


</script>
            
     <!-- /container -->
    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="bootstrap-3.3.5-dist/js/bootstrap.min.js"></script>
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
   
    

   
</bodyonload="init()">
</html>