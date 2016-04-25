
<!-- set the language for the html page -->
<html lang="en">
<!-- head tag contains css and imported scripts -->
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../favicon.ico">
    <!-- title hidden from user -->
    <title>miRNA-disease page</title>
    <!-- Bootstrap core CSS -->
    <link href="bootstrap-3.3.5-dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="newG.css">
    <link href="css/mystyles.css" rel="stylesheet">
    <link href="css/font-awesome.min.css" rel="stylesheet">
    <!-- d3 library for graph making -->
    <script src="http://d3js.org/d3.v3.min.js" charset="utf-8"></script>
    <!-- script for maintaing selected tab -->
    <script src="tabScript.js"></script>
   <!-- style for legend tables -->
    <link rel="stylesheet" href="table.css">
    <!-- scripts for the google visualization table -->
    <script src= "http://www.google.com/uds/modules/gviz/gviz-api.js"> </script>
    <script src= "https://www.google.com/jsapi"> </script>
    <script type="text/javascript">
        google.load('visualization', '1', {packages: ['table']});
    </script>
    <!-- shows the user their selected limit for a query -->
      <script type="text/javascript">
      // show value for tab 1
        function showValue(newValue)
        {
            document.getElementById("range").innerHTML=newValue;
        }
        // show value for tab 2
        function showValue2(newValue)
        {
            document.getElementById("range2").innerHTML=newValue;
        }
    </script>
    
</head>

<!-- when the body loads the init() function from tabscript is run, tab1s selection is maintained -->
<body onload="init()">
    <div class="container">
        <!-- Static navbar -->
         <!-- sets the nav class, this utilizes bootstrap and will be filled with buttons to toggle -->
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
                <div id="navbar" class="navbar-collapse collapse">
                     <!--  the ul class contains all the tabs for the website -->
                    <ul class="nav navbar-nav">
                        <!-- sets the mirna disease page as active, glyphicons are small icons to be placed wth the 
                    text in the tab box-->
                        <li><a href="Home.html"><span class="glyphicon glyphicon-home"
                            aria-hidden="true"></span> iMir</a></li>

                        <li><a href="Search.php"><span class="glyphicon glyphicon-search"
                            aria-hidden="true"></span> Search</a></li>
                       
                        <li class="active"><a href="miRNA-disease.php">miRNA-disease</a></li>
                        <li><a href="miRNA-TF-Gene.php">miRNA-TF-Gene</a></li>
                        <li><a href="miRNA-Drug.php">miRNA-Drug</a></li>
                        
                    </ul>
                </div><!--/.nav-collapse -->
            </div><!--/.container-fluid -->
        </nav>
        <!-- -->
        <!-- Main component for a message-->
        <div class="page-header">
            <h1>Search Database</h1><small>This page will alow you to search the database in two ways. First by entering
                one or more miRNAs in the first tab and getting a result and secondly by entering one or 
                more Diseases in the second tab and getting an output.
            </small>
        </div>
        
        <!-- nav tabs gives the div for both tab elements 
        tab 1 is initially set to active-->
        <ul class="nav nav-tabs">
            <li role="presentation" class="active" id="tabheader1">
                <a href="#tab1" aria-controls="tab1"
                     role="tab" data-toggle="tab">Search miRNA - Disease</a>
            </li>
            <li role="presentation" id="tabheader2">
                <a href="#tab2" aria-controls="tab2"
                     role="tab" data-toggle="tab">Search Disease - miRNA</a>
            </li>
        </ul>
        
        <!-- tab content gives the submission box, limit radio buttons and slider, showtip, submit button -->
        <div class="tab-content">
            <div role="tabpanel" class="tab-pane fade in active" id="tab1">
                <!-- this form will post mirna and limit information -->
                <form id="inputform1" method='post'>
                <!-- places the showtip with onclick events -->
                <div style=" margin-left: 550px;">
                 <i><a class="testTipOne embeddedAnchors" href="javascript:void(0);">Show tip</a></i>
                </div>  
                  <!-- the text area where mirnas will be entered -->
                  <td> <textarea name="user" value="" rows = "15" cols="50 "></textarea></td>
                    <!-- the text area that will pop in and out when you click on showtip -->
                    <td> <textarea style="display: none" class="tipOne" disabled="disabled" rows="15" cols="45">Enter miRNAs (if more than one) as&#13;[comma separated] or [newline separated]
                        hsa-mir-21, hsa-mir-205,hsa-mir-222 &#10;&#10;OR&#10;&#10;hsa-mir-21&#13;hsa-mir-205&#10;hsa-mir-222&#10; click 'Submit'
                                                 </textarea> </td>
                     <p style="padding: 10px"></p>

                    <label for="mLimit">Display all Results</label>
                    <!-- creates a radio button that indicates no limit on a query -->
                    <input type="radio" name="limit" id="mlimit" value="0"><br>
                    <label for="climit">Set Custom Result Limit</label>
                    <!-- creates a radio button that indicates a user limit on a query -->
                    <input type="radio" name="limit" id="climit" value="1">
                        <div style="width: 300; height: 50">
                            <!-- creates a slide bar from which a limit value will be posted, on change is provided to show the user their selection -->
                        <input type="range" min="10" max="500" step="10" value="30" name="graphlimit" id="slider" onchange="showValue(this.value)">
                        <!-- default limit -->
                        <span id="range">30</span>
                    </div>
                    <input type="submit" name="submit" value="Submit">                               
                </form>
            </div>
            <!-- 2nd tab -->
            <div role="tabpanel" class="tab-pane fade" id="tab2">
               <!-- form will post disease and limit info -->
                <form id="inputform2" method='post' name="form2">
                  <!-- places the showtip click -->
                   <div style=" margin-left: 550px;">
                 <i><a class="testTipOne embeddedAnchors" href="javascript:void(0);">Show tip</a></i>
                </div>  
                <!-- user enter diseases here -->
                  <td>  <textarea name="user2" value="" rows = "15" cols="50"></textarea></td>
                    <!-- tipbox gives sample diseases -->
                    <td>   <textarea style="display: none" class="tipOne" disabled="disabled" rows="15" cols="45">Enter diseases (if more than one) as&#13;[comma separated] or [newline separated]
        lung cancer, breast cancer,pancreatic cancer &#10;&#10;OR&#10;&#10;lung cancer&#13;breast cancer&#10;pancreatic cancer &#10;click 'Submit'
                                                 </textarea> </td>
                       <p style="padding: 10px"></p>

                    <label for="mlimitdis">Display all Results</label>
                    <input type="radio" name="limit" id="mlimitdis" value="0"><br>
                    <!-- creates a radio button that indicates no limit on a query -->
                    <label for="climitdis">Set Custom Result Limit</label>
                    <!-- creates a radio button that indicates a user limit on a query -->
                    <input type="radio" name="limit" id="climitdis" value="1">
                         <div style="width: 300; height: 50">
                            <!-- creates a slide bar from which a limit value will be posted, on change is provided to show the user their selection -->
                        <input type="range" min="10" max="500" step="10" value="30" name="graphlimitdis" id="slider" onchange="showValue2(this.value)">
                        <!-- default limit -->
                        <span id="range2">30</span>
                    </div>
                    <input type="submit" name="submit" value="Submit">                       
                </form>
            </div>
        </div>
        <p style="padding:20px;"></p>
     
 <div id="filenamemodal" class="modal fade" tabindex="-1" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header" style="background-color: grey; height: 50px">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" style="color: white; font-weight: bold">File Name</h4>
                    </div>
                    <div class="modal-body" style="height: 150px">
                        <form>
                            <div class="form-group">
                                <h5>Enter Filename</h5>
                                <input type="text" class="form-control" id="modalinput">
                            </div>
                            <button type="button" class="btn btn-primary" onclick="download();return false;" data-dismiss="modal">Save</button>
                            <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                        </form>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->

<!-- import jquery for the showtip functionality -->
<script src="http://code.jquery.com/jquery-1.11.3.js"></script>

<script>
// shows and hides the showtip textbox
$(".testTipOne").click(function(){
        $(".tipOne").toggle( function() {
        $(".testTipOne").text( 
            $(this).is(':visible')? "Hide tip":  "Show tip");
        });
    });
</script>

<!-- formats the google table, legend, and graph -->
           <div class="row">
      <div class="col-sm-3"></div>
      <div class="col-sm-6"> </div>
      <!--  style="display: none" -->
      <div class="col-sm-3"></div>
    </div>
    <div id="table"></div>
    <span id="pageCnt"></span>
    <div class="row">
        <div class="col-md-10">
        </div>
        
        <!--GRAPH LEGEND-->
        <div class="col-md-2">
            <table border="0">
                <tr>
                    <td>
                        <div style="background-color: green; height: 20px; width: 20px"></div>
                    </td>
                    <td>
                        <label>Up-regulated</label>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div style="background-color: red; height: 20px; width: 20px"></div>
                    </td>
                    <td>
                        <label>Down-regulated</label>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div style="background-color: blue; height: 20px; width: 20px"></div>
                    </td>
                    <td>
                        <label>miRNA</label>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div style="background-color: orange; height: 20px; width: 20px"></div>
                    </td>
                    <td>
                        <label>Diseases</label>
                    </td>
                </tr>
            </table>

            <!-- this is the graph legend it contains colors and attribute names in the label tags -->
            
        </div>
    </div>
     <div id="graph" >
                        </div>
 
 <!-- provides the onclick that will prompt the user to enter a filename, after clicking save
 the user will recieve a csv version of the outputted table, getCSV is defined further below-->
 <p>Download <a id="csv" href="#" onclick="getCSV();return false;">CSV</a><p>

<?php
// grab the user post which is the set of mirnas
if ( ! empty($_POST['user'])){
  
// accesses the database
require_once("dBaseAccess.php");
// takes the mirnas and makes them mysql friendly
    $mirna = mysqli_real_escape_string($mirnabDb, $_POST['user']);
    // from $trimmed to $strNew, the set of mirnas is formulated into a way a query can parse      
        $trimmed = array();
            $str = preg_split('/,/', $mirna);
            $str = preg_split('/[,|\r\n|\r|\n]+/', $mirna);
   
            for ($i=0;$i<count($str);$i++) {
                    $trimmed[$i] = trim($str[$i]);
            }
        $strNew = implode("','", $trimmed);
        $strNew = str_replace('\r\n',"','" , $strNew);

// checks for a limit selected from the user, if there wasnt one, we default to the show all query
    if (!empty($_POST['limit']))
        {$limit=$_POST['limit'];}
    else 
        {$limit=0;}
   
  // if a limit was given by the user then we will run a limited query
if($limit > 0)
    // grabs the limit given by the user from graphlimit
        {$glimit = $_POST['graphlimit'];

 /*search based on inputed mirna
        returns table showing all data in order of count significance
        */   

        $query = 
           "SELECT mirna_name AS source
           , dis_name AS target
           , dis_reguln AS type
           , dis_pubId
           , c.tally
                from main_v2, disease, (SELECT count(*) as tally
                    , mirna_name as m_nam
                    , dis_name as d_nam
                        from main_v2, disease
                        where main_v2.link_id = disease.link_id
                        AND mirna_name in ('".$strNew."')
                        group by mirna_name, dis_name) c
                where main_v2.link_id = disease.link_id
                and (mirna_name=c.m_nam and dis_name=c.d_nam)
                AND mirna_name in ('".$strNew."')
                order by c.tally desc
                limit ".$glimit."
                ";

        // gives a result with only unique mirna disease pairs , the number of repeated pairs is counted 
        // and used to determine the width of the line

        $graphQuery =
            "SELECT c.mirna_name AS source
           , c.dis_name AS target
           , c.dis_reguln AS type
           ,c.tally/(select max(t.tally) from 
                    (SELECT count(*) as tally
                    , mirna_name
                    , dis_name
                    , dis_reguln
                        from main_v2, disease
                        where main_v2.link_id = disease.link_id
                        AND mirna_name in ('".$strNew."')
                        group by mirna_name, dis_name) as t ) as numb
                from (
                    SELECT count(*) as tally
                    , mirna_name
                    , dis_name
                    , dis_reguln
                    from main_v2, disease
                    where main_v2.link_id = disease.link_id
                    AND mirna_name in ('".$strNew."')
                    group by mirna_name, dis_name) as c
                group by c.mirna_name, c.dis_name
                order by numb desc
                limit ".$glimit."
        ";}

        // if there was no supplied limit or display all was checked then else will happen
else
        {
            // identical to the above but with no limits
        $query = 
           "SELECT mirna_name AS source
           , dis_name AS target
           , dis_reguln AS type
           , dis_pubId
           , c.tally
                from main_v2, disease, (SELECT count(*) as tally
                    , mirna_name as m_nam
                    , dis_name as d_nam
                        from main_v2, disease
                        where main_v2.link_id = disease.link_id
                        AND mirna_name in ('".$strNew."')
                        group by mirna_name, dis_name) c
                where main_v2.link_id = disease.link_id
                and (mirna_name=c.m_nam and dis_name=c.d_nam)
                AND mirna_name in ('".$strNew."')
                order by c.tally desc
                ";

        $graphQuery =
            "SELECT c.mirna_name AS source
           , c.dis_name AS target
           , c.dis_reguln AS type
           ,c.tally/(select max(t.tally) from 
                    (SELECT count(*) as tally
                    , mirna_name
                    , dis_name
                    , dis_reguln
                        from main_v2, disease
                        where main_v2.link_id = disease.link_id
                        AND mirna_name in ('".$strNew."')
                        group by mirna_name, dis_name) as t ) as numb
                from (
                    SELECT count(*) as tally
                    , mirna_name
                    , dis_name
                    , dis_reguln
                    from main_v2, disease
                    where main_v2.link_id = disease.link_id
                    AND mirna_name in ('".$strNew."')
                    group by mirna_name, dis_name) as c
                group by c.mirna_name, c.dis_name
                order by numb desc
        ";}     
 
 // register a query as a query object, this runs the query
 // this is done for both the table and graph query               
$result = mysqli_query($mirnabDb,$query);
$resultGraph= mysqli_query($mirnabDb,$graphQuery);

// checks that neither query result is empty
 if ( ! $result || ! $resultGraph) {
        echo mysql_error();
        die;
    }

//grab the query data as a set of objects, in this format 
// the query result can be viewed and utilized
$data = array();
  for ($x = 0; $x < mysqli_num_rows($result); $x++) {
        $data[] = mysqli_fetch_assoc($result);
    }
$dataGraph = array();
  for ($x = 0; $x < mysqli_num_rows($resultGraph); $x++) {
        $dataGraph[] = mysqli_fetch_assoc($resultGraph);
    }
//convert the type of the object to a json so that it can be converted into javascript variables    
$jsonForm = json_encode($data);
$jsonGraph=json_encode($dataGraph);
}

//2  results are taken in for the table and graph queries made above, they are looped through and 
//split into an array, then they are cast into json type objects 
?>

<!-- grabs the graph file so that the createGraph function can be utilized -->
<script src="newGraph.js"></script>

<script>

// this function takes a json variable and generates a table , this particular one 
// gets mirna to disease information
   function drawTable(jsonData) {

//this script builds the table for this page, rows are added based on the length of the jsonData and columns are added with 
// specific names , then the jsonData is iterated through and the cells of the table are created , options make it possible to have paging 
//enabled , the buttons are labled prev and next , the table is attached to a div id = table  in the getElementById

    var dataT = new google.visualization.DataTable();
    var numRows = jsonData.length;
    dataT.addRows(numRows);
    

    dataT.addColumn('string', 'miRNA');
    dataT.addColumn('string', 'Disease');
    dataT.addColumn('string', 'Regulation');
    dataT.addColumn('string', 'PubId');

    var url = '',
        pubmed = '';

    for (var iter = 0; iter < numRows; iter++) {
        dataT.setCell(iter, 0, jsonData[iter]['source']);
        dataT.setCell(iter, 1, jsonData[iter]['target']);
        dataT.setCell(iter, 2, jsonData[iter]['type']);
        dataT.setCell(iter, 3, jsonData[iter]['dis_pubId']);
    };

    var options = {allowHtml: true, alternatingRowStyle: true}; 
 
    options['page'] = 'enable'; options['pageSize'] = 10; options['pagingSymbols'] = {prev: 'prev', next: 'next'}; //options['pagingButtonsConfiguration'] = 'auto';
    
    var table = new google.visualization.Table(document.getElementById('table'));
    table.draw(dataT, options); // , {showRowNumber: true, width: '100%', height: '100%'});
  }

</script>

<script>
    //Checks If first tab is active and sets its to active if it's not
    var activeclass = "active";
    var inactiveclass = "in active";
    var tab=document.getElementById("tabheader1");
    var tabpane=document.getElementById("tab1");
      
    //add class attribute to element  
    function addclass(element, classname){
       
        var newclassname;
        var tabpaneactiveclass = "tab-pane fade in active";
        var tab2=document.getElementById("tabheader2");
        var tabpane2=document.getElementById("tab2");
        if(!element.className){
            element.className=classname;
            removeclass("active", tab2);
            removeclass(tabpaneactiveclass, tabpane2);
        }else if(element.className=="active" || element.className==tabpaneactiveclass){
            return;
        }else{
            newclassname=element.className;
            newclassname+=" ";
            newclassname+=classname;
            element.className=newclassname;
        }
    }
    //remove class attribute from element
    function removeclass(classname, element) {
       
        var cn = element.className;
        if(cn=="active"){
            cn=" ";
        }else{
            cn=" ";
            cn="tab-pane fade";
        }

        element.className = cn;
    }
    addclass(tab, activeclass);
    addclass(tabpane, inactiveclass);
    
    
    //empty json checking was added to avoid issues in improper js declarations
    var jsonForm = <?php if(!empty($jsonForm)) {echo $jsonForm;} else {echo json_encode("empty");}?>;
    var jsonGraph= <?php if(!empty($jsonGraph)) {echo $jsonGraph;} else {echo json_encode("empty");}?>;

if(jsonForm!="empty" && jsonGraph!="empty")
{    //Draws table and graph with data from php script
    drawTable(jsonForm);
    createGraph(jsonGraph,"#graph");
}


function getCSV(){
        var modalbtn = document.createElement("button");
        modalbtn.setAttribute("class", "btn btn-primary");
        modalbtn.setAttribute("data-toggle", "modal");
        modalbtn.setAttribute("data-target", "#filenamemodal");
        modalbtn.style = "visibility:hidden";
        document.body.appendChild(modalbtn);
        modalbtn.click();
        document.body.removeChild(modalbtn);
    }
    
    //Downloads file after user has chosen to enter a file
    //If User decides not to enter file name and continues, file has default name
    //File won't be downladed if user dismisses modal
    function download(){
        var csv = "";
        var filename = document.getElementById("modalinput").value;
        console.log("FILENAME ---->> "+filename);
        //Sets file headers
        var headers="miRNA,Disease,Regulation,PubId";
        console.log("Row --->> "+headers);

        //Writes file headers onto .csv file and goes to new line
        csv += headers + '\r\n';
        //Fills files columns rows by rows 
        for(var i=0; i<jsonForm.length; i++){
            var rows="";
            var pubID = jsonForm[i].dis_pubId;
            var miRNA = jsonForm[i].source;
            var disease = jsonForm[i].target;
            var regulation = jsonForm[i].type;
            rows+='"' + miRNA + '",' + '"' + disease + '",' + '"' + regulation + '",' + '"' + pubID + '",';
            console.log("rows --->> " + rows);
            rows=rows.slice(0, rows.length-1);
            console.log("rows after slice() --->> " + rows);
            csv += rows + '\r\n';
        }
        if (csv == '') {        
            alert("Invalid data");
            return;
        } 
        //CSV file format  
        var uri = 'data:text/csv;charset=utf-8,' + escape(csv);
        //Creates invisible link that triggers download
        var link = document.createElement("a");    
        link.href = uri;
        link.style = "visibility:hidden";
        if(filename=="")
        link.download = "Xfile.csv";
        else{
            filename=filename.replace(/ /g,"_");
            console.log("filename after replace() --->> " + filename);
            console.log("file name "+filename+".csv");
            link.download = filename+".csv";
        }
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
    }

</script>  

 
        </div>
<!-- set the div that holds the table and graph , set the paging element -->
            <div class="row">
      <div class="col-sm-3"></div>
      <div class="col-sm-6"> </div>
      <!--  style="display: none" -->
      <div class="col-sm-3"></div>
    </div>
    <div id="table"></div>
    <span id="pageCnt"></span>
    <div id="graph">
                        </div>    

<?php
// checks for the 2nd tab's user input, here it's diseases
if ( ! empty($_POST['user2'])){
//connect to the database
require_once("dBaseAccess.php");
// takes the diseases entered and puts them into mysqli form
    $mirna = mysqli_real_escape_string($mirnabDb, $_POST['user2']);  

      /* the users input is taken in and split by commas and newline, then reattached 
        with single qoutes and commas */

        $trimmed = array();
            $str = preg_split('/,/', $mirna);
            $str = preg_split('/[,|\r\n|\r|\n]+/', $mirna);
        //echo json_encode($str);
            for ($i=0;$i<count($str);$i++) {
                    $trimmed[$i] = trim($str[$i]);
            }
        $strNew = implode("','", $trimmed);
        $strNew = str_replace('\r\n',"','" , $strNew);

  // check for a user set limit, if not set then display all will be defaulted to 

    if (!empty($_POST['limit']))
        {$limit=$_POST['limit'];}
    else 
        {$limit=0;}
    echo $limit;

// check that the user set a limit

if($limit > 0)
         // grab the users chosen limit from graphlimitdis
        {$glimit = $_POST['graphlimitdis'];

      /*search based on inputed mirna
        returns table showing mirna disease pairs */  
        $query = 
           "SELECT mirna_name AS source
           , dis_name AS target
           , dis_reguln AS type
           , dis_pubId
           , c.tally
                from main_v2, disease, (SELECT count(*) as tally
                    , mirna_name as m_nam
                    , dis_name as d_nam
                        from main_v2, disease
                        where main_v2.link_id = disease.link_id
                        AND dis_name in ('".$strNew."')
                        group by mirna_name, dis_name) c
                where main_v2.link_id = disease.link_id
                and (mirna_name=c.m_nam and dis_name=c.d_nam)
                AND dis_name in ('".$strNew."')
                order by c.tally desc
                limit ".$glimit."
                ";
         
 /*search based on inputed mirna
        returns graph showing unique mirna/disease pairs, with the number of those pairs divided by the number of the most common mirna/disease pair
        */ 

        $graphQuery =
            "SELECT c.mirna_name AS source
           , c.dis_name AS target
           , c.dis_reguln AS type
           ,c.tally/(select max(t.tally) from 
                    (SELECT count(*) as tally
                    , mirna_name
                    , dis_name
                    , dis_reguln
                        from main_v2, disease
                        where main_v2.link_id = disease.link_id
                        AND dis_name in ('".$strNew."')
                        group by mirna_name, dis_name) as t ) as numb
                from (
                    SELECT count(*) as tally
                    , mirna_name
                    , dis_name
                    , dis_reguln
                    from main_v2, disease
                    where main_v2.link_id = disease.link_id
                    AND dis_name in ('".$strNew."')
                    group by mirna_name, dis_name) as c
                group by c.mirna_name, c.dis_name
                order by numb desc
                limit ".$glimit."
        ";}
else
        {
            // same as above but no limit
        $query = 
           "SELECT mirna_name AS source
           , dis_name AS target
           , dis_reguln AS type
           , dis_pubId
           , c.tally
                from main_v2, disease, (SELECT count(*) as tally
                    , mirna_name as m_nam
                    , dis_name as d_nam
                        from main_v2, disease
                        where main_v2.link_id = disease.link_id
                        AND dis_name in ('".$strNew."')
                        group by mirna_name, dis_name) c
                where main_v2.link_id = disease.link_id
                and (mirna_name=c.m_nam and dis_name=c.d_nam)
                AND dis_name in ('".$strNew."')
                order by c.tally desc
                ";
        
        $graphQuery =
            "SELECT c.mirna_name AS source
           , c.dis_name AS target
           , c.dis_reguln AS type
           ,c.tally/(select max(t.tally) from 
                    (SELECT count(*) as tally
                    , mirna_name
                    , dis_name
                    , dis_reguln
                        from main_v2, disease
                        where main_v2.link_id = disease.link_id
                        AND dis_name in ('".$strNew."')
                        group by mirna_name, dis_name) as t ) as numb
                from (
                    SELECT count(*) as tally
                    , mirna_name
                    , dis_name
                    , dis_reguln
                    from main_v2, disease
                    where main_v2.link_id = disease.link_id
                    AND dis_name in ('".$strNew."')
                    group by mirna_name, dis_name) as c
                group by c.mirna_name, c.dis_name
                order by numb desc
        ";}     

// register a query as a query object, this runs the query
 // this is done for both the table and graph query 

$result = mysqli_query($mirnabDb,$query);
$resultGraph= mysqli_query($mirnabDb,$graphQuery);

// checks that neither query result is empty

 if ( ! $result || ! $resultGraph) {
        echo mysql_error();
        die;
    }

//grab the query data as a set of objects, in this format 
// the query result can be viewed and utilized

$data = array();
  for ($x = 0; $x < mysqli_num_rows($result); $x++) {
        $data[] = mysqli_fetch_assoc($result);
    }
$dataGraph = array();
  for ($x = 0; $x < mysqli_num_rows($resultGraph); $x++) {
        $dataGraph[] = mysqli_fetch_assoc($resultGraph);
    }
//convert the type of the object to a json so that it can be converted into javascript variables 
$jsonForm2 = json_encode($data);
$jsonGraph2=json_encode($dataGraph);
    }

// query results are taken into result and result graph, split into arrays and cast as json objects

?>

<script>
    //Sets 2nd tab to active
    var activeclass = "active";
    var inactiveclass = "in active";
    var tab2=document.getElementById("tabheader2");
    var tabpane2=document.getElementById("tab2"); 
    
    //sets elemnts class
    function addclass(element, classname){
        console.log("In add class 2");
        var newclassname;
        var tabpaneactiveclass = "tab-pane fade in active";
        var tab=document.getElementById("tabheader1");
        var tabpane=document.getElementById("tab1");
        if(!element.className){
            element.className=classname;
            removeclass("active", tab);
            removeclass(tabpaneactiveclass, tabpane);
        
        }else{
            newclassname=element.className;
            newclassname+=" ";
            newclassname+=classname;
            element.className=newclassname;
        }
    }
    //removes active class from tab
    function removeclass(classname, element) {
       
        var cn = element.className;
        if(cn=="active"){
            cn=" ";
        }else{
            cn=" ";
            cn="tab-pane fade";
        }
        
        element.className = cn;
    }
  
    addclass(tab2, activeclass);
    addclass(tabpane2, inactiveclass);
    
    // grabs the table and graph query from php
    var jsonForm2 = <?php echo $jsonForm2; ?>;
    var jsonGraph2= <?php echo $jsonGraph2; ?>;

if(jsonForm2!="empty" && jsonGraph2!="empty")
{    //Draws table and graph with data from php script 
    drawTable(jsonForm2);
    createGraph(jsonGraph2,"#graph");
}
      
      // this script sets the active tab to the 2nd tab even after using the submit button, additionally a table and graph
      // are built after converting php variables to javascript variables 

      function getCSV(){
        var modalbtn = document.createElement("button");
        modalbtn.setAttribute("class", "btn btn-primary");
        modalbtn.setAttribute("data-toggle", "modal");
        modalbtn.setAttribute("data-target", "#filenamemodal");
        modalbtn.style = "visibility:hidden";
        document.body.appendChild(modalbtn);
        modalbtn.click();
        document.body.removeChild(modalbtn); 
    }
    
    //Downloads file after user has chosen to enter a file
    //If User decides not to enter file name and continues, file has default name
    //File won't be downladed if user dismisses modal
    function download(){
        var csv = "";
        var filename = document.getElementById("modalinput").value;
      
        var headers="miRNA,Disease,Regulation,PubId";
        
        //Writes file headers onto .csv file and goes to new line
        csv += headers + '\r\n';
        //Fills files columns rows by rows
        for(var i=0; i<jsonForm2.length; i++){
            var rows="";
            var pubID = jsonForm2[i].dis_pubId;
            var miRNA = jsonForm2[i].source;
            var disease = jsonForm2[i].target;
            var regulation = jsonForm2[i].type;
            rows+='"' + miRNA + '",' + '"' + disease + '",' + '"' + regulation + '",' + '"' + pubID + '",';
      
            rows=rows.slice(0, rows.length-1);
        
            csv += rows + '\r\n';
        }
        if (csv == '') {        
            alert("Invalid data");
            return;
        }  
        //CSV file format 
        var uri = 'data:text/csv;charset=utf-8,' + escape(csv);
        //Creates invisible link that triggers download
        var link = document.createElement("a");    
        link.href = uri;
        link.style = "visibility:hidden";
        if(filename=="")
        link.download = "Xfile.csv";
        else{
            filename=filename.replace(/ /g,"_");
          
            link.download = filename+".csv";
        }
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
    }

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

<!-- bootstrap javascript files loaded at the end of the page for efficiency  -->
   
</bodyonload="init()">
</html>