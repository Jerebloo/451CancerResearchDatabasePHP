
<!-- set the language for the html page -->
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../favicon.ico">
     <!-- title hidden from user -->
    <title>miRNA-TF-Gene page</title>
    <!-- Bootstrap core CSS -->
    <link href="bootstrap-3.3.5-dist/css/bootstrap.min.css" rel="stylesheet">
 
    <link href="css/mystyles.css" rel="stylesheet">
    <link href="css/font-awesome.min.css" rel="stylesheet">
    <!-- d3 library for graph making -->
    <script src="http://d3js.org/d3.v3.min.js" charset="utf-8"></script>
    <!-- gives style for the graph -->
    <link rel="stylesheet" href="newG.css">
    <!-- style for the legend -->
    <link rel="stylesheet" href="table.css">
    <!-- google table imports -->
    <script src= "http://www.google.com/uds/modules/gviz/gviz-api.js"> </script>
    <script src= "https://www.google.com/jsapi"> </script>
    <script type="text/javascript">
        google.load('visualization', '1', {packages: ['table']});
    </script>
    <!-- shows the user their selected limit for a query -->
      <script type="text/javascript">
        function showValue(newValue)
        {
            document.getElementById("range").innerHTML=newValue;
        }
    </script>
<!--all needed tools are included in the head, these are : D3, google table, bootstrap, css files for the graph, tabs and table -->
</head>


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
                    
                </div>
                <div id="navbar" class="navbar-collapse collapse">
                    <!--  the ul class contains all the tabs for the website -->
                    <ul class="nav navbar-nav">
                        <!-- sets the mirna-TF-gene page as active, glyphicons are small icons to be placed wth the 
                    text in the tab box-->
                        <li><a href="Home.html"><span class="glyphicon glyphicon-home"
                            aria-hidden="true"></span> iMiR </a></li>
                        <li><a href="Search.php"><span class="glyphicon glyphicon-search"
                            aria-hidden="true"></span> Search</a></li>
                       
                        <li><a href="miRNA-disease.php">miRNA-disease</a></li>
                        <li class = "active"><a href="miRNA-TF-Gene.php">miRNA-TF-Gene</a></li>
                        <li><a href="miRNA-Drug.php">miRNA-Drug</a></li>
                       
                    </ul>
                </div><!--/.nav-collapse -->
            </div><!--/.container-fluid -->
        </nav>
        <!-- the nav div builds the bar at the top of the page, each page is declared in the ul class as a li element -->
        <div class="home">
         
            <h1>Explore MiRNA - TF - Gene Relationship</h1>
        </div>

            <div>
                <!-- this will post mirnas, tfs, genes, and a limit -->
                <form ="" method='post'>
                 
               <div class="col-sm-7"> 
               <p class="col-sm-3">Enter miRNAs: </p> 
               <br><br>
               <!-- gets users input mirnas -->
               <textarea name="mirna" value="" rows = "3" cols="50"></textarea>
              
               <br><br>
               <p class="col-sm-3">Enter Genes: </p> 
               <br><br>
               <!-- gets users input genes -->
               <textarea name="gene" value="" rows = "3" cols="50"></textarea>
           
           <br><br>
               <p class="col-sm-3">Enter TF: </p> 
               <br><br>
               <!-- gets users input TFs -->
               <textarea name="tf" value="" rows = "3" cols="50"></textarea>
           
                 <p style="padding: 10px"></p>
                    <!-- creates a radio button that indicates no limit on a query -->
                     <input type="radio" name="limit" id="mlimit" value="0">
                    <label for="mLimit">&nbsp;   Display all Results</label><br>
                    
                   <!-- creates a radio button that indicates a user limit on a query -->
                    <input type="radio" name="limit" id="climit" value="1">
                    <label for="climit">&nbsp;   Set Custom Result Limit</label>
                        <div style="width: 300; height: 50"> 
                         <!-- creates a slide bar from which a limit value will be posted, on change is provided to show the user their selection -->
                        <input type="range" min="10" max="500" step="10" value="30" name="graphlimit" id="slider" onchange="showValue(this.value)">
                        <span id="range">30</span>
                        </div>
                <input type="submit" name="submit" value="Submit">
            </div>
    <div class="col-sm-5">       
   <div>
    <!-- places the showtip with onclick events -->
                 <i><a class="testTipOne embeddedAnchors" href="javascript:void(0);">Show tip</a></i>
                </div>       
                 <!-- the text area that will pop in and out when you click on showtip -->   
   <textarea style="display: none" class="tipOne" disabled="disabled" rows="7" cols="50">Enter miRNAs, Genes,TFs (if more than one) as&#13;[comma separated] or [newline separated]
                                                hsa-mir-127,hsa-mir-126  
                                                NOTCH1,WDR20,CD8A  
                                                NR3B3,klf2a
                                                click 'Submit' 
                                                 </textarea> 
        </div>  
            </form>      
                
            </div>
        <!-- this div builds 3 boxes and places them in a form of method post, what is entered in the 3 boxes will be stored in php -->
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

        <!-- places the graph and table in the row div-->
        
        <!--GRAPH LEGEND-->
        <div class="col-md-2">
            <table border="0">
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
                        <label>TF</label>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div style="background-color: green; height: 20px; width: 20px"></div>
                    </td>
                    <td>
                        <label>Gene</label>
                    </td>
                </tr>
            </table>

            <!-- this is the graph legend it contains colors and attribute names in the label tags -->
            
        </div>
    </div>
    <div  id="graph">
    </div>  
     <!-- this div sizes and places content, in this case the graph and table are going to be attached to the bottom 2 divs -->


<?php
// check if all 3 boxes are set
if ( ! empty($_POST['mirna']) and ! empty($_POST['gene']) and ! empty($_POST['tf']))

{
   //use your own database connection
require_once("dBaseAccess.php");

//grab the info placed in the text box for mirnas and turn it into a form a query can understand
$mirna = mysqli_real_escape_string($mirnabDb, $_POST['mirna']);
 
 //multiple  miRNAs are split on commas or newline and single qoutes are added to make mirnaString form a proper list of 
        //miRNAS for the query to recognize
       $trimmed = array();
               $str = preg_split('/,/', $mirna);
            $str = preg_split('/[,|\r\n|\r|\n]+/', $mirna);
       
            for ($i=0;$i<count($str);$i++) {
                    $trimmed[$i] = trim($str[$i]);
            }


        $mirnaString = implode("','", $trimmed);
        $mirnaString = str_replace('\r\n',"','" , $mirnaString);
     
//grab the info placed in the text box for genes and turn it into a form a query can understand
$gene = mysqli_real_escape_string($mirnabDb, $_POST['gene']);

 //multiple  genes are split on commas or newline and single qoutes are added to make mirnaString form a proper list of 
        //genes for the query to recognize

        $trimmed2 = array();
               $str2 = preg_split('/,/', $gene);
            $str2 = preg_split('/[,|\r\n|\r|\n]+/', $gene);

            for ($h=0;$h<count($str2);$h++) {
                    $trimmed2[$h] = trim($str2[$h]);
            }

        $geneString = implode("','", $trimmed2);
        $geneString = str_replace('\r\n',"','" , $geneString);

//grab the info placed in the text box for tfs and turn it into a form a query can understand
$tf = mysqli_real_escape_string($mirnabDb, $_POST['tf']);

//split and reformat incoming tfs into the form the query will take
        $trimmed3 = array();
               $str3 = preg_split('/,/', $tf);
            $str3 = preg_split('/[,|\r\n|\r|\n]+/', $tf);
      
            for ($j=0;$j<count($str3);$j++) {
                    $trimmed3[$j] = trim($str3[$j]);
            }

        $tfString = implode("','", $trimmed3);
        $tfString = str_replace('\r\n',"','" , $tfString);
        
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
        returns table showing mirna/disease pairs,
        used for the graph as well */  
        $query = 
                "SELECT 
            distinct 
                mirna_name as source, 
                up_tf as target, 
                gene_name , 
                gene_pubId
            from main_v2, upstream_tf,gene_v2
            where main_v2.link_id = upstream_tf.link_id
            and main_v2.link_id = gene_v2.link_id
            and mirna_name in ('".$mirnaString."')
            and up_tf in ('".$tfString."')
            and gene_name in ('".$geneString."')
                limit ".$glimit."
                ";
            
        }
        // if there was no supplied limit or display all was checked then else will happen
else
        {
            //same as above with no limit
        $query = 
                "SELECT 
            distinct 
                mirna_name as source, 
                up_tf as target, 
                gene_name , 
                gene_pubId
            from main_v2, upstream_tf,gene_v2
            where main_v2.link_id = upstream_tf.link_id
            and main_v2.link_id = gene_v2.link_id
            and mirna_name in ('".$mirnaString."')
            and up_tf in ('".$tfString."')
            and gene_name in ('".$geneString."')
                ";
            
      }     

//process as a query
$result = mysqli_query($mirnabDb,$query);

//checks if the result is indeed a query
 if ( ! $result ) {
        echo mysql_error();
        die;
    }

//throws the query result into an array of data
$data = array();
  for ($x = 0; $x < mysqli_num_rows($result); $x++) {
        $data[] = mysqli_fetch_assoc($result);
    }

//translates array of data to a json object type
$jsonForm = json_encode($data);
}

else
{
 echo "Please fill all 3 boxes";
 //error message for not having filled all 3 boxes
}

?>

<br><br>
 <!-- provides the onclick that will prompt the user to enter a filename, after clicking save
 the user will recieve a csv version of the outputted table, getCSV is defined further below-->
<p>Download <a id="csv" href="#" onclick="getCSV();return false;">CSV</a><p>

<script>
// this function takes a json variable and generates a table , this particular one 
// gets mirna to TF to Gene information
   function drawTable(jsonData) {
    
    //declare google table, declare the number of rows
    var dataT = new google.visualization.DataTable();
    var numRows = jsonData.length;
    dataT.addRows(numRows);
    
//declare the number and name of the columns
    dataT.addColumn('string', 'miRNA');
    dataT.addColumn('string', 'TF');
    dataT.addColumn('string', 'Gene');
    dataT.addColumn('string', 'PubID');

    var url = '', //not used at the moment, will be reintigrated for hyperlink functionality
        pubmed = '';//not used at the moment, will be reintigrated for hyperlink functionality

//grabs the data from the jsonData for the specified columns and places it in a table cell
    for (var iter = 0; iter < numRows; iter++) {
        dataT.setCell(iter, 0, jsonData[iter]['source']);
        dataT.setCell(iter, 1, jsonData[iter]['target']);
        dataT.setCell(iter, 2, jsonData[iter]['gene_name']);
        dataT.setCell(iter, 3, jsonData[iter]['gene_pubId']);
    };
    

    var options = {allowHtml: true, alternatingRowStyle: true}; 
  
  //enables paging
    options['page'] = 'enable'; options['pageSize'] = 10; options['pagingSymbols'] = {prev: 'prev', next: 'next'}; //options['pagingButtonsConfiguration'] = 'auto';
    
 //gets the div placement of the table
    var table = new google.visualization.Table(document.getElementById('table'));

    table.draw(dataT, options); 
  }
</script>

<script src="newGraph.js"></script> 

<script>
// grabs php variable and stores it in javascript, this is the data from the query
var jsonForm = <?php echo $jsonForm; ?>; 
// calls the google table function
drawTable(jsonForm); 
//calls the graph function from newGraph
createGraph(jsonForm,"#graph"); 

</script>  

<script>

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
       
        //Sets file headers
        var headers="miRNA,TF,Gene,PubId";
    
        //Writes file headers onto .csv file and goes to new line
        csv += headers + '\r\n';
        //Fills files columns rows by rows 
        for(var i=0; i<jsonForm.length; i++){
            var rows="";
            var pubID = jsonForm[i].gene_pubId;
            var miRNA = jsonForm[i].source.name;
            var TF = jsonForm[i].target.name;
            var gene = jsonForm[i].gene_name;
            rows+='"' + miRNA + '",' + '"' + TF + '",' + '"' + gene + '",' + '"' + pubID + '",';
          
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

    </div><!--/.container-fluid -->
     
            
     <!-- /container -->
    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="bootstrap-3.3.5-dist/js/bootstrap.min.js"></script>
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
   
   
</html>