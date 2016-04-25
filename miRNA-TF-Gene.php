

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
 
    <link rel="stylesheet" href="newG.css">
    <link href="css/mystyles.css" rel="stylesheet">
    <link href="css/font-awesome.min.css" rel="stylesheet">
    <script src="http://d3js.org/d3.v3.min.js" charset="utf-8"></script>
  
    <link rel="stylesheet" href="table.css">

    <script src= "http://www.google.com/uds/modules/gviz/gviz-api.js"> </script>
    <script src= "https://www.google.com/jsapi"> </script>
    <script type="text/javascript">
        google.load('visualization', '1', {packages: ['table']});
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
                    <a class="navbar-brand" href="Home.html">iMir</a>
                </div>
                <div id="navbar" class="navbar-collapse collapse">
                    <ul class="nav navbar-nav">
                        <li><a href="Home.html"><span class="glyphicon glyphicon-home"
                            aria-hidden="true"></span> iMir </a></li>
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
         
            <p>This page will alow you to search the database.</p>
        </div>

            <div>

                <form ="" method='post'>
                 
               <div class="col-sm-7"> 
               <p class="col-sm-3">Enter miRNAs: </p> 
               <br><br>
               <textarea name="mirna" value="" rows = "3" cols="50"></textarea>
              
               <br><br>
               <p class="col-sm-3">Enter Genes: </p> 
               <br><br>
               <textarea name="gene" value="" rows = "3" cols="50"></textarea>
           
           <br><br>
               <p class="col-sm-3">Enter TF: </p> 
               <br><br>
               <textarea name="tf" value="" rows = "3" cols="50"></textarea>
           
                
                <input type="submit" name="submit" value="Submit">
            </div>
    <div class="col-sm-5">       
   <div>
                 <i><a class="testTipOne embeddedAnchors" href="javascript:void(0);">Show tip</a></i>
                </div>          
   <textarea style="display: none" class="tipOne" disabled="disabled" rows="15" cols="50">Enter miRNAs, Genes,TFs (if more than one) as&#13;[comma separated] or [newline separated]
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
    <div  id="graph">
    </div>  
     <!-- this div sizes and places content, in this case the graph and table are going to be attached to the bottom 2 divs -->

<p>Download <a id="csv" href="#" onclick="getCSV();return false;">CSV</a><p>

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
                gene_name , 
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
        dataT.setCell(iter, 2, jsonData[iter]['gene_name']);
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


<script src="newGraph.js"></script> <!--uses the multiSourceTargetGraph as a reference for building a graph-->

<script>
var jsonForm = <?php echo $jsonForm; ?>; // grabs php variable and stores it in javascript, this is the data from the query

drawTable(jsonForm); // calls the google table function

createGraph(jsonForm,"#graph"); //calls the graph function from the multiSourceTargetGraph


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
        //filename = document.getElementById("modalinput").value;
        console.log("Clicked on CSV link");
        //var data = typeof jsonForm != 'object' ? JSON.parse(jsonForm) : jsonForm;
        //console.log("data " + data);
        
        //var uri = "data:text/csv;charset=utf-8,";
        //Bactraccking/Testing
        console.log(jsonForm);
        console.log("****END JSONFORM*****");
        console.log("EXAMPLE");
        console.log("pubID: "+jsonForm[0].gene_pubId);
        console.log("source: "+jsonForm[0].source.name);
        console.log("target: "+jsonForm[0].target.name);
        console.log("type: "+jsonForm[0].gene_name);
        //setTimeout(download(), 10000);
        
        /*jsonForm.forEach(function(infoArray, index){
            console.log("Array---> " + infoArray);
            for (var i = 0; i < jsonForm.length; i++) {
                                
                //2nd loop will extract each column and convert it in string comma-seprated
                for (var index in jsonForm[i]) {
                    console.log(jsonForm[i][index]);
                }
             }

            var dataString = Array.prototype.join.call(infoArray, ",");
            console.log("dataString---->> "+dataString);
            csv += index < jsonForm.length ? dataString+ "\n" : dataString;
            console.log("index: "+index);
        });
        var encodedUri = encodeURI(uri);
        var link = document.createElement("a");
        link.setAttribute("href", encodedUri);
        link.setAttribute("download", "my_data.csv");
        
        link.click(); // This will download the data file named "my_data.csv".*/
        
    }
    
    //Downloads file after user has chosen to enter a file
    //If User decides not to enter file name and continues, file has default name
    //File won't be downladed if user dismisses modal
    function download(){
        var csv = "";
        var filename = document.getElementById("modalinput").value;
        console.log("FILENAME ---->> "+filename);
        //Sets file headers
        var headers="miRNA,TF,Gene,PubId";
        console.log("Row --->> "+headers);
        /*headers=headers.slice(0, -9);
        console.log("Row after slice -->> "+headers);*/
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

    </div><!--/.container-fluid -->
     
            
     <!-- /container -->
    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="bootstrap-3.3.5-dist/js/bootstrap.min.js"></script>
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
   
   
</html>