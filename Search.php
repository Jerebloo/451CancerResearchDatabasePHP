﻿<?php
    require_once('dBaseAccess.php');
    //fetch table rows from mysql db
    $sql = "select distinct chem_name from chemical";
 //this query grabs the chemical names from the database, this data  dropnames  is used to build the dropdown later on   

    $result = mysqli_query($mirnabDb, $sql) or die("Error in Selecting " . mysqli_error($mirnabDb));

    //create an array
    $reparray = array();
    for ($x = 0; $x < mysqli_num_rows($result); $x++) {
        $reparray[] = mysqli_fetch_assoc($result);
    }
    $dropnames = json_encode($reparray);
   
 
?>

<script>
    //grabs the php variable holding the chemicals and stores it in javascript variable chemNames
    var chemNames = <?php echo $dropnames; ?>;
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

    <script src="http://d3js.org/d3.v3.min.js" charset="utf-8"></script>
    <script src= "http://www.google.com/uds/modules/gviz/gviz-api.js"> </script>
    <script src= "https://www.google.com/jsapi"> </script>
    <script type="text/javascript">
        google.load('visualization', '1', {packages: ['table']});
    </script>
   
</head>

<!-- the head tag contains the needed script imports for this page-->
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
               
            </div>     
            <!-- the nav tag contains the bar of tabs at the top of the page and within each tab is a li tag defined name of the tab -->
            <div id="navbar" class="navbar-collapse collapse">
                <ul class="nav navbar-nav">
                    <li><a href="Home.html"><span class="glyphicon glyphicon-home"
                         aria-hidden="true"></span> iMiR</a></li>
                    <li class="active"><a href="Search.php"><span class="glyphicon glyphicon-search"
                         aria-hidden="true"></span> Search</a></li>
                    <li><a href="miRNA-disease.php">miRNA-disease</a></li>
                    <li><a href="miRNA-TF-Gene.php">miRNA-TF-Gene</a></li>
                    <li><a href="miRNA-Drug.php">miRNA-Drug</a></li>
               
                </ul>
            </div><!--/.nav-collapse -->
        </div><!--/.container-fluid -->
    </nav>
    <div class="container">
        <div class="page-header">
            <h1>Explore MiRNA - Chemical Relationship</h1><small>This page will alow you to search a specific chemical by selecting 
                any chemical from the options in the dropdown menu</small>
        </div>        
        <div>
            <select id="selector"> </select>
        </div>

         <!-- the row div holds the table-->
    
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
    
   

    <script>
         //this script builds a selector that will attach to the selector div
        //it appends a new chemical that can be selected for each chemical in chemNames
        window.onload = function () 
        {
            var JSON = chemNames, 
            select = document.getElementById("selector");
            var option = document.createElement("option");
            option.value = "Select chemical";
            option.textContent = "Select chemical";
            select.appendChild(option);


            for (var i = 0 ;  i < chemNames.length; i++)
            {   
              
                name = JSON[i].chem_name;
                var option = document.createElement("option");
                option.value = name;
                option.textContent = name;
                select.appendChild(option);
            };
        };

    
    </script>

<!-- jetpack may not be needed-->

 <script src="http://code.jquery.com/jquery-1.11.3.js"></script>
 <script src="https://rawgit.com/gka/d3-jetpack/master/d3-jetpack.js"></script>
 
  <script>
  //jsonData is passed into the google table function and its length, and cell data are used
  //to determine the output table
    function drawTable(jsonData) {
        
  //this script builds the table for this page, rows are added based on the length of the jsonData and columns are added with 
// specific names , then the jsonData is iterated through and the cells of the table are created , options make it possible to have paging 
//enabled , the buttons are labled prev and next , the table is attached to a div id = table  in the getElementById

        var dataT = new google.visualization.DataTable();
        var numRows = jsonData.length;
        dataT.addRows(numRows);
    
    
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

        options['page'] = 'enable'; options['pageSize'] = 10; options['pagingSymbols'] = {prev: 'prev', next: 'next'}; //options['pagingButtonsConfiguration'] = 'auto';
        //paging size set to 10, 10 rows will be displayed at one time

        var table = new google.visualization.Table(document.getElementById('tableGoogle'));
        table.draw(dataT, options); // , {showRowNumber: true, width: '100%', height: '100%'});
    }
  

    
        $("#selector").change(function() {
            // gets the chemical selected using dropdown
            var mirnaSelected = $(this).val(); //stores the chemical in the var
            var phpJson = [];
        
            $.ajax({
                url: 'queries.php', // sends data to queries.php
                type: 'POST', //sends the data in this format
                data: {'mirna': mirnaSelected, 'flag': 100}, // when you want to get the data you will need to get the post of 'mirna'
                //dataType: "json",
                success: function(data) {
                // if data is not empty
                if(data){
                        $("#table").empty();
                        var header = ["Chemical","miRNA","Response","Condition","Tech","PubId"]; //probably not needed anymore
                        console.log(data);
                        
                        drawTable(JSON.parse(data));// makes the google table
                        
                    }
                    else {
                        //the data is empty
                        alert("No results for the selected miRNA. Select a different miRNA.");
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    // if there is a failure on the queries page or in the ajax
                    console.log(jqXHR.responseText);
                    console.log(errorThrown);
        
                }
            }); // end of ajax request
        }); // end of select change
  </script>


  <script src="bootstrap-3.3.5-dist/js/bootstrap.min.js"></script>
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
  
</body>
</html>