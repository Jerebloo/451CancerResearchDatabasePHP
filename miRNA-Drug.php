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
    <link rel="stylesheet" href="googleTableCss.css">
    <script src= "http://www.google.com/uds/modules/gviz/gviz-api.js"> </script>
    <script src= "https://www.google.com/jsapi"> </script>
    <script type="text/javascript">
        google.load('visualization', '1', {packages: ['table']});
    </script>
    
</head>
<!-- the head tag contains the needed script imports for this page, additionally a min and max box are set, the value in them is 
obtained through the getElementById method -->

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
                        <li ><a href="miRNA-disease.php">miRNA-disease</a></li>
                        <li><a href="miRNA-TF-Gene.php">miRNA-TF-Gene</a></li>
                        <li class ="active"><a href="miRNA-Drug.php">miRNA-Drug</a></li>
                        <li><a href="miRNA-Methylation.php">miRNA methylation</a></li>
                    </ul>
                </div><!--/.nav-collapse -->
            </div><!--/.container-fluid -->
        </nav>
        <!-- -->
        <!-- Main component for a primary marketing message or call to action -->
        <div class="page-header">
            <h1>Search Database</h1><small>This page will alow you to search the database in two ways. First by entering
                one or more miRNA Drugs in the first tab and getting a result and secondly by entering one or 
                more Drug miRNAs in the second tab and getting an output.
            </small>
        </div>
        
        <ul class="nav nav-tabs">
            <li role="presentation" class="active" id="tabheader1">
                <a href="#tab1" aria-controls="tab1"
                     role="tab" data-toggle="tab">Search miRNA - Drug</a>
            </li>
            <li role="presentation" id="tabheader2">
                <a href="#tab2" aria-controls="tab2"
                     role="tab" data-toggle="tab">Search Drug - miRNA</a>
            </li>
        </ul>

        <!-- the ul tag allows us to have mutliple tabs within a particular page here we have 2 tabs denoted with the li tag
        desciptions are also added in the a tag-->
        
        <div class="tab-content">
            <div role="tabpanel" class="tab-pane fade in active" id="tab1">
                <tr> <th><i><a class="testTipOne embeddedAnchors" href="javascript:void(0);">Show tip</a></i> </th>  </tr>
                <form id="inputform1" method='post'>
                 <td>   <textarea name="user" value="" rows = "15" cols="50"></textarea> </td>
                    <input type="submit" name="submit" value="Submit">
                  <td>   <textarea style="display: none" class="tipOne" disabled="disabled" rows="12" cols="45">Enter miRNAs (if more than one) as&#13;[comma separated] or [newline separated]
                                                hsa-mir-21, hsa-mir-205 &#10;&#10;OR&#10;&#10;hsa-mir-21&#13;hsa-mir-205&#10;click 'Submit'
                                                 </textarea> </td>
                </form>
               
            </div>
            <div role="tabpanel" class="tab-pane fade" id="tab2">
                  <tr> <th><i><a class="testTipOne embeddedAnchors" href="javascript:void(0);">Show tip</a></i> </th>  </tr>
                <form id="inputform2" method='post' name="form2">
                  <td>  <textarea name="user2" value="" rows = "15" cols="50"></textarea></td>
                    <input type="submit" name="submit" value="Submit">
                      <td>   <textarea style="display: none" class="tipOne" disabled="disabled" rows="12" cols="45">Enter Drugs (if more than one) as&#13;[comma separated] or [newline separated]
                                                cisplatin, insulin &#10;&#10;OR&#10;&#10;cisplatin&#13;insulin&#10;click 'Submit'
                                                 </textarea> </td>
                </form>
            </div>
        </div>
        <p style="padding:20px;"></p>
      <!-- create min and max text boxes , a slider is also included, this functionality is not a part of this page however  -->

 <script src="http://code.jquery.com/jquery-1.11.3.js"></script>

<script>
$(".testTipOne").click(function(){
        $(".tipOne").toggle( function() {
        $(".testTipOne").text( 
            $(this).is(':visible')? "Hide tip":  "Show tip");
        });
    });
</script>


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

        <!-- places the graph and table in the row div-->
        
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
                        <label>Drug</label>
                    </td>
                </tr>
            </table>

            <!-- this is the graph legend it contains colors and attribute names in the label tags -->
            
        </div>
    </div>
     <div id="graph" >
                        </div>
                        
                        <!--class="col-lg-8 col-md-6 col-sm-6"--> 


<?php
if ( ! empty($_POST['user'])){
    $name = $_POST['user'];
require_once("dBaseAccess.php");
$mirna = mysqli_real_escape_string($mirnabDb, $_POST['user']);
        
       $trimmed = array();
             $str = preg_split('/,/', $mirna);
            $str = preg_split('/[,|\r\n|\r|\n]+/', $mirna);
   
            for ($i=0;$i<count($str);$i++) {
                    $trimmed[$i] = trim($str[$i]);
            }
        $strNew = implode("','", $trimmed);
        $strNew = str_replace('\r\n',"','" , $strNew);
        

        // the users input is taken in and split by commas and newline, then reattached 
        // with single qoutes and commas
        
       $query = 
           "SELECT main_v2.mirna_name as source, drug as target, pmid 
            from colated.pharmaco, mirnabkp.main_v2
            where main_v2.mirna_name = pharmaco.mirna_name
            AND main_v2.mirna_name in ('".$strNew."')";

$graphQuery =
            "SELECT c.mirna_name AS source
           , c.drug AS target
           , c.pmid 
           ,c.tally/(select max(t.tally) from 
                    (SELECT count(*) as tally
                    , main_v2.mirna_name
                    , drug
                    , pmid
                        from colated.pharmaco, main_v2
                        where main_v2.mirna_name = pharmaco.mirna_name
                        AND main_v2.mirna_name in ('".$strNew."')
                        group by mirna_name, drug) as t ) as numb
                from (
                    SELECT count(*) as tally
                    , main_v2.mirna_name
                    , drug
                    , pmid
                    from colated.pharmaco, mirnabkp.main_v2
                    where main_v2.mirna_name = pharmaco.mirna_name
                    AND main_v2.mirna_name in ('".$strNew."')
                    group by main_v2.mirna_name, drug) as c
                group by c.mirna_name, c.drug
                order by numb desc
                ";
                
$result = mysqli_query($mirnabDb,$query);
$resultGraph= mysqli_query($mirnabDb,$graphQuery);

 if ( ! $result || ! $resultGraph) {
        echo mysql_error();
        die;
    }
$data = array();
  for ($x = 0; $x < mysqli_num_rows($result); $x++) {
        $data[] = mysqli_fetch_assoc($result);
    }
$dataGraph = array();
  for ($x = 0; $x < mysqli_num_rows($resultGraph); $x++) {
        $dataGraph[] = mysqli_fetch_assoc($resultGraph);
    }
$jsonForm = json_encode($data);
$jsonGraph=json_encode($dataGraph);
}

//2  results are taken in for the table and graph queries made above, they are looped through and 
//split into an array, then they are cast into json type objects 
?>
                  <script src="tempo.js"></script>

<script>
   function drawTable(jsonData) {
    
    var dataT = new google.visualization.DataTable();
    var numRows = jsonData.length;
    dataT.addRows(numRows);
    console.log(numRows, " rows added");

    dataT.addColumn('string', 'miRNA');
    dataT.addColumn('string', 'Drug');
    dataT.addColumn('string', 'PubId');

    var url = '',
        pubmed = '';

    for (var iter = 0; iter < numRows; iter++) {
        dataT.setCell(iter, 0, jsonData[iter]['source']);
        dataT.setCell(iter, 1, jsonData[iter]['target']);
        dataT.setCell(iter, 2, jsonData[iter]['pmid']);
    };

    var options = {allowHtml: true, alternatingRowStyle: true}; 

    options['page'] = 'enable'; options['pageSize'] = 10; options['pagingSymbols'] = {prev: 'prev', next: 'next'}; //options['pagingButtonsConfiguration'] = 'auto';
    
    var table = new google.visualization.Table(document.getElementById('table'));
    table.draw(dataT, options); // , {showRowNumber: true, width: '100%', height: '100%'});
  }
//this script builds the table for this page, rows are added based on the length of the jsonData and columns are added with 
// specific names , then the jsonData is iterated through and the cells of the table are created , options make it possible to have paging 
//enabled , the buttons are labled prev and next , the table is attached to a div id = table  in the getElementById

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
    
    //Draws table and graph with data from php script
    var jsonForm = <?php echo $jsonForm;?>;
    var jsonGraph= <?php echo $jsonGraph;?>;
    drawTable(jsonForm);
    createGraph(jsonGraph,"#graph");
</script>  

 
        </div>

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

<!-- set the div that holds the table and graph , set the paging element -->

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

        //take the users input from the text box and strip out the spaces, newlines, and commas, 
        //reformat it into a way the query can read (append ', between words)
        
        $query = 
           "SELECT main_v2.mirna_name as source, drug as target, pmid
            from colated.pharmaco, mirnabkp.main_v2
            where main_v2.mirna_name = pharmaco.mirna_name
            AND drug in ('".$strNew."')";

$graphQuery =
            "SELECT c.mirna_name AS source
           , c.drug AS target
           , c.pmid
           ,c.tally/(select max(t.tally) from 
                    (SELECT count(*) as tally
                    , main_v2.mirna_name
                    , drug
                    , pmid
                        from colated.pharmaco, main_v2
                        where main_v2.mirna_name = pharmaco.mirna_name
                        AND drug in ('".$strNew."')
                        group by mirna_name, drug) as t ) as numb
                from (
                    SELECT count(*) as tally
                    , main_v2.mirna_name
                    , drug
                    , pmid
                    from colated.pharmaco, mirnabkp.main_v2
                    where main_v2.mirna_name = pharmaco.mirna_name
                    AND drug in ('".$strNew."')
                    group by main_v2.mirna_name, drug) as c
                group by c.mirna_name, c.drug
                order by numb desc
                ";

                //a query that groups source and target matches and gives the total sum of those divided by
                // the largest sum of the entire result set

$result = mysqli_query($mirnabDb,$query);
$resultGraph= mysqli_query($mirnabDb,$graphQuery);

 if ( ! $result || ! $resultGraph) {
        echo mysql_error();
        die;
    }
$data = array();
  for ($x = 0; $x < mysqli_num_rows($result); $x++) {
        $data[] = mysqli_fetch_assoc($result);
    }
$dataGraph = array();
  for ($x = 0; $x < mysqli_num_rows($resultGraph); $x++) {
        $dataGraph[] = mysqli_fetch_assoc($resultGraph);
    }
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
    
    
    //Draws table and graph with data from php script  
    var jsonForm2 = <?php echo $jsonForm2; ?>;
    var jsonGraph2 = <?php echo $jsonGraph2; ?>;
    drawTable(jsonForm2);
    createGraph(jsonGraph2,"#graph");
      
      // this script sets the active tab to the 2nd tab even after using the submit button, additionally a table and graph
      // are built after converting php variables to javascript variables 

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