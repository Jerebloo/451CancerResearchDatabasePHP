

function createGraph(jsonData,tabDiv)
{
//pass in json data object and the div where you want to place the graph
 
  jsonData.sort(function(a,b){if(a.source>b.source){return 1;}
  else if(a.source<b.source){return-1;}
  else{
    if(a.target>b.target){return 1;}

    if(a.target<b.target) {
      return-1;
    }

    else{
      return 0;
    }
  }
});

// sort the jsonData so that sources and targets are grouped by likeness, may not be needed anymore because the new data im making is also sorted

    var nodes={};
    jsonData.forEach(function(link){
        link.source = nodes[link.source] ||
      (nodes[link.source]={name:link.source,group:0});
        
        link.target = nodes[link.target] ||
      (nodes[link.target]={name:link.target,group:1});

        link.type = nodes[link.type] ||
      (nodes[link.type]={name:link.type,group:2});});

  // stores and groups nodes into the nodes object. Each node will have a name and a group number which is used to determine its color
  // in addition the jsonData is modified , each source target and type will now point to an object with node information 
  //this includes its name and position

var linkData={};
var t=0;
for(var g=0;g<jsonData.length;g++){

  linkData[t] = {source: jsonData[g].source,target: jsonData[g].target};
  t++;
  linkData[t] = {source: jsonData[g].target,target: jsonData[g].type};
  t++;
};

//Build the link data, in this case miRNAS target TFs and TFs target genes, this makes an object that is twice the size of the jsonData
//this is done because the .links function of d3  expects an object  with data in this format {source: "hsa...", target:"Tf"}

var newLinkData = d3.values(linkData);

// .links will expect an object of objects with no incremented key, d3.values reformats linkData to have this property

newLinkData.sort(function(a,b){if(a.source.name>b.source.name){return 1;}
  else if(a.source.name<b.source.name){return-1;}
  else{
    if(a.target.name>b.target.name){return 1;}

    if(a.target.name<b.name) {
      return-1;
    }

    else{
      return 0;
    }
  }
});

//sorts the links so they are grouped together by similar name, this is neccessary for the linkum loop to work because
//it checks for similarities by looking at the previous object 

for(var i=0;i<newLinkData.length;i++) {
  if(i!=0&&newLinkData[i].source.name==newLinkData[i-1].source.name&&newLinkData[i].target.name==newLinkData[i-1].target.name) {
    newLinkData[i].linknum=newLinkData[i-1].linknum+1;
  }
  else
  {
    newLinkData[i].linknum=1;
  }
}

//applies a linkum to all the objects in newLinkData, can be accessed with newLinkData.linknum, this number counts how many times
//a  source target pair occurs, the linkum is increased for each pair. This number factors into how curved the arc of a new line
//will be 

//console.log(nodes);  // because inspecting objects is my life 

    var arrows=[];

    for(var i=0;i<newLinkData.length;i++){arrows[i]=newLinkData[i].source.name;};

//stores some filler data in arrows , since there are no responses or regulations to check for. The marker d3 element 
//as it is built right now still expects some kind of data and will return some property of that same data
// in this case as long as the arrows and return object match , arrows will be returned and will point to all targets

    var up_regulated=[];
    var down_regulated=[];
    var unspecified=[];
    for(var i=0; i<arrows.length; i++){
      if(arrows[i]=="Up-regulated")
        up_regulated[i]=arrows[i];
        
      
      else if(arrows[i]=="Down-regulated")
        down_regulated[i]=arrows[i];
        
      
      else
        unspecified[i]=arrows[i];
      
      
    }
    //remnant of the regulation seperation , may not be needed

          

    var w=1300,h=1200;

//graph window size

    var w = document.getElementById("graph").offsetWidth;

//grabs the div of the location of the graph in miRNA-TF-Gene.php

    var force=d3.layout.force()
    .nodes(d3.values(nodes))
    .links(newLinkData)
    .size([w,h])
    .linkDistance(300)
    .charge(-1100)
    .on("tick",tick)
    .start();

  // declares a force object, in d3 force graphs have certain methods that can be used like charge
  // nodes and links between nodes are appended , you can think of this as invisible lines being made between the links source and target
  // the size of the window is grabbed
  //link distance is declared , here it is 300, this determines how far linked nodes will be from eachother
  //the charge determines how repelled the nodes are from eachother. The more negative the more repelled they become
  //start  begins the graph display

    var color = d3.scale.category10();
//grabs a set of colors for node use

    var svg=d3.select(tabDiv)
    .append("svg:svg")
    .attr("width",w)
    .attr("height",h); 

  //appends the svg(the d3 term meaning container) to the declared div in the method parameter. 
  //gives this container size attributes as well

     svg.append("svg:defs").selectAll("marker")
    .data(arrows)
    .enter().append("svg:marker")
    .attr("id",String).attr("viewBox","0 -5 10 10")
    .attr("refX",13)
    .attr("refY",0)
    .attr("markerWidth",14)
    .attr("markerHeight",14)
    .attr("orient","auto")
    .append("svg:path")
    .attr("d","M0,-5L10,0L0,5");

    //builds a marker, in this case the marker is simply a path that is drawn in the shape of an arrow
    //data is appended so that markers can be applied to different incoming data
    //the viewBox attribute gives the overall size window for the marker, the marker is automatically sized to fit in it
    //refX determines the markers position on the line (the marker gets its initial position from the target end of the line)
    //width and height change the size of the marker
    //a path is appended, this is where the marker is drawn, coordinates are provided so a path is drawn from M0 to -5L10 and so on

    var path=svg.append("svg:g").selectAll("path")
    .data(force.links())
    .enter().append("svg:path")
    .attr("class",function(d){
      return"link "+d.source.name;})
    .attr("marker-end",function(d){
      console.log("url(#"+d.source.name+")");
      return"url(#"+d.source.name+")";});

    //places grey lines where the links are and places arrows, in this case the returned data isnt important as they're all grey lines
    //and arrows

    var circle=svg.append("svg:g").selectAll("circle")
    .data(force.nodes())
    .enter().append("svg:circle")
    .attr("r",8)
    .style("fill", function(d) {
      return color(d.group);
    })
    .call(force.drag);

    //places circles of 3 different colors based on node groups where the node positions are 
    // the r attribute is the radius , this determines the node size
    //the style fill gives a node its color , in this case nodes are assigned a color based on their group number
    //force drag allows nodes to be clicked and pulled

    var text=svg.append("svg:g").selectAll("g")
    .data(force.nodes())
    .enter().append("svg:g");
    text.append("svg:text")
    .attr("x",8)
    .attr("y",".31em")
    .attr("class","shadow")
    .text(function(d){return d.name;});

    //makes a text container and attaches it to the node container
    //fills the text container with the name of the nodes
    //this makes it so that the name of the node hovers near the node

    text.append("svg:text")
    .attr("x",8).attr("y",".31em")
    .text(function(d){return d.name;});

    function tick() {
        path.attr("d",function(d)
        {
          //console.log(d);
          var dx=d.target.x-d.source.x,dy=d.target.y-d.source.y,
          dr=1000/d.linknum;
          return"M"+d.source.x+","+d.source.y+"A"+dr+","+dr+" 0 0,1 "+d.target.x+","+d.target.y;
        });

      circle.attr("transform",function(d){return"translate("+d.x+","+d.y+")";});

      text.attr("transform",function(d){return"translate("+d.x+","+d.y+")";});
    }

//tick is applied to the force object, and it governs the following properties
// determines the coordinates of the nodes, grabs the linkum property of the newLinkData and is modified by 1000 to create dynamic arcs
// the node and line placement are returned 
//the circle and text attributes move the nodes and text from their original coordinate(this is done because of "translate"). 
// when the graph is built nodes will be dynamically moved based on their links(child relations), depending on the d.x, d.y
//the (coordinate of the node) the linked nodes will move the exact amount of space that the parent node moves 
  }
