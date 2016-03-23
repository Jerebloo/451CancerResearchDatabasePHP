<?php
    require_once('dBaseAccess.php');
    //fetch table rows from mysql db
    $sql = "select chem_name from chemical limit 10";
    $result = mysqli_query($mirnabDb, $sql) or die("Error in Selecting " . mysqli_error($mirnabDb));

    //create an array
    $reparray = array();
    for ($x = 0; $x < mysqli_num_rows($result); $x++) {
        $reparray[] = mysqli_fetch_assoc($result);
    }
    $dropnames = json_encode($reparray);
    //close the db connection
   // mysqli_close($connection);
    
?>

<script>
    var pech = <?php echo $dropnames; ?>;
</script>
<html lang="en">
<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../favicon.ico">
    <title>Basic Search</title>
    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/bootstrap-theme.min.css" rel="stylesheet">
    <link href="css/mystyles.css" rel="stylesheet">
    <!-- Custom styles for this template -->
    <link rel="stylesheet" href="googleTableCss.css">
    <script src="http://d3js.org/d3.v3.min.js" charset="utf-8"></script>
    <script src= "http://www.google.com/uds/modules/gviz/gviz-api.js"> </script>
    <script src= "https://www.google.com/jsapi"> </script>
    <script type="text/javascript">
        google.load('visualization', '1', {packages: ['table']});
    </script>
   
</head>
<body>
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
                    <li class="active"><a href="Search.php"><span class="glyphicon glyphicon-search"
                         aria-hidden="true"></span> Search</a></li>
                    <li><a href="Analysis.php"><span class="glyphicon glyphicon-cog"
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
        <p>This page will allow you to search the database.</p>
        <select id="selector"> </select>
    
        <div class="row">
            <div class="col-sm-3"></div>
            <div class="col-sm-6"> </div>
            <!--  style="display: none" -->
            <div class="col-sm-3"></div>
        </div>
        <div class="row">
            <p style="padding:20px;"></p>
            <center>
                <div id="tableGoogle" ></div>
                <span id="pageCnt"></span>
            </center>
        </div>
    </div>
    
    
        
    <!-- /container -->
    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->

    <script>
        //console.log(pech[0]);
        window.onload = function () 
        {
            var JSON = pech, 
            select = document.getElementById("selector");
            var option = document.createElement("option");
            option.value = "Select chemical";
            option.textContent = "Select chemical";
            select.appendChild(option);


            for (var i = 0 ;  i < pech.length; i++)
            {   
                //at = JSON[i];
                //console.log(at);
                name = JSON[i].chem_name;
                var option = document.createElement("option");
                option.value = name;
                option.textContent = name;
                select.appendChild(option);
            };
        };
    </script>

 <script src="http://code.jquery.com/jquery-1.11.3.js"></script>
 <script src="https://rawgit.com/gka/d3-jetpack/master/d3-jetpack.js"></script>


 
  <script>
    function drawTable(jsonData) {
        
        var dataT = new google.visualization.DataTable();
        var numRows = jsonData.length;
        dataT.addRows(numRows);
        console.log(numRows, " rows added");
    
        dataT.addColumn('string', 'Chemical');
        dataT.addColumn('string', 'miRNA');
        dataT.addColumn('string', 'Response');
        dataT.addColumn('string', 'Condition');
        dataT.addColumn('string', 'Tech');
        dataT.addColumn('string', 'PubId');
    
        var url = '',
            pubmed = '';
    
        for (var iter = 0; iter < numRows; iter++) {
            dataT.setCell(iter, 0, jsonData[iter]['chem_name']);
            dataT.setCell(iter, 1, jsonData[iter]['mirna_name']);
            dataT.setCell(iter, 2, jsonData[iter]['response']);
            dataT.setCell(iter, 3, jsonData[iter]['cond']);
            dataT.setCell(iter, 4, jsonData[iter]['tech']);
            url = 'http://www.ncbi.nlm.nih.gov/pubmed?term=' + jsonData[iter]['chem_pubId'];
            pubmed = '<a href="' + url + '" target="_blank">' + jsonData[iter]['chem_pubId'] + '</a>';
            dataT.setCell(iter, 5, jsonData[iter]['chem_pubId']); //pubmed);
        };
    
        var options = {allowHtml: true, alternatingRowStyle: true}; 
        //options['cssClassNames'] = cssNamesOne;
        options['page'] = 'enable'; options['pageSize'] = 30; options['pagingSymbols'] = {prev: 'prev', next: 'next'}; //options['pagingButtonsConfiguration'] = 'auto';
        
        var table = new google.visualization.Table(document.getElementById('tableGoogle'));
        table.draw(dataT, options); // , {showRowNumber: true, width: '100%', height: '100%'});
    }
    
        $("#selector").change(function() {
            // gets the miRNA selected using dropdown
            var mirnaSelected = $(this).val();
            var phpJson = [];
        
            $.ajax({
                url: 'queries.php',
                type: 'POST',
                data: {'mirna': mirnaSelected, 'flag': 100},
                //dataType: "json",
                success: function(data) {
                // if data is not empty
                if(data){
                        $("#table").empty();
                        var header = ["Chemical","miRNA","Response","Condition","Tech","PubId"];
                        drawTable(JSON.parse(data));
                        //$("#table").show();
                    }
                    else {
                        alert("No results for the selected miRNA. Select a different miRNA.");
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.log(jqXHR.responseText);
                    console.log(errorThrown);
                }
            }); // end of ajax request
        }); // end of select change
  </script>



    
  <script src="js/bootstrap.min.js"></script>
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
  
</body>
</html>