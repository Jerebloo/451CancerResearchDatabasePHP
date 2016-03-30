

function createGraph(jsonData,tabDiv)
{

 
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

    var nodes={};
    jsonData.forEach(function(link){
        link.source = nodes[link.source] ||
      (nodes[link.source]={name:link.source,group:0});
        
        link.target = nodes[link.target] ||
      (nodes[link.target]={name:link.target,group:1});

        link.type = nodes[link.type] ||
      (nodes[link.type]={name:link.type,group:2});});

  

var linkData={};
var t=0;
for(var g=0;g<jsonData.length;g++){

  linkData[t] = {source: jsonData[g].source,target: jsonData[g].target};
  t++;
  linkData[t] = {source: jsonData[g].target,target: jsonData[g].type};
  t++;
};



var newLinkData = d3.values(linkData);

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

for(var i=0;i<newLinkData.length;i++) {
  if(i!=0&&newLinkData[i].source.name==newLinkData[i-1].source.name&&newLinkData[i].target.name==newLinkData[i-1].target.name) {
    newLinkData[i].linknum=newLinkData[i-1].linknum+1;
  }
  else
  {
    newLinkData[i].linknum=1;
  }
}

console.log(nodes);
//lets build a separate   json  just for links

    //console.log(Object.keys(nodes));
  


    var arrows=[];

    for(var i=0;i<newLinkData.length;i++){arrows[i]=newLinkData[i].source.name;};
    /************************************************ */
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
      
    
    /************************************************ */
    //var w=1000,h=800;
    var w=1300,h=1200;
    var w = document.getElementById("graph").offsetWidth;

    var force=d3.layout.force()
    .nodes(d3.values(nodes))
    .links(newLinkData)
    .size([w,h])
    .linkDistance(300)
    .charge(-1100)
    .on("tick",tick)
    .start();

    var color = d3.scale.category10();

    var svg=d3.select(tabDiv)
    .append("svg:svg")
    .attr("width",w)
    .attr("height",h);      
  
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
    

    var path=svg.append("svg:g").selectAll("path")
    .data(force.links())
    .enter().append("svg:path")
    .attr("class",function(d){
      return"link "+d.source.name;})
    .attr("marker-end",function(d){
      console.log("url(#"+d.source.name+")");
      return"url(#"+d.source.name+")";});

    var circle=svg.append("svg:g").selectAll("circle")
    .data(force.nodes())
    .enter().append("svg:circle")
    .attr("r",8)
    .style("fill", function(d) {
      return color(d.group);
    })
    .call(force.drag);

    var text=svg.append("svg:g").selectAll("g")
    .data(force.nodes())
    .enter().append("svg:g");
    text.append("svg:text")
    .attr("x",8)
    .attr("y",".31em")
    .attr("class","shadow")
    .text(function(d){return d.name;});

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
  }
