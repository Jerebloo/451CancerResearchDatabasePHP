
// the table rows, typically loaded from data file using d3.csv
    function createTable(passChoice,divChoice,header,declareMirna){

    //console.log(passChoice[1]);
    var headers = Object.keys(passChoice[0]);

// The table generation function
function tabulate(passChoice, columns) {    
    var table = d3.select(divChoice).append("table")
        //.attr("style", "margin-left: 250px")
        .style("border", "3px rgb(160,200,200) solid"), 
        thead = table.append("thead"),
        tbody = table.append("tbody");

    // append the header row
    thead.append("tr")
        .selectAll("th")
        .data(header)
        .enter()
        .append("th")
            .text(function(column) { return column; });

    // create a row for each object in the data
    var rows = tbody.selectAll("tr")
        .data(passChoice)
        .enter()
        .append("tr");

    // create a cell in each row for each column
    var cells = rows.selectAll("td")
        .data(function(row) {
            return columns.map(function(column) {

                //console.log(row[column]);
                //console.log(column);
                var v = '';
                if(column == "up_pubId" || column == "gene_pubId" ||column == "dis_pubId"|| column=="chem_pubId"){
                    url = "http://www.ncbi.nlm.nih.gov/pubmed?term=" + row[column];
                    v = "<a href='" + url + "' target='_blank'>" + row[column] + " </a>"
                }
                

                else if (column==declareMirna)
                {
                 url = 'http://www.mirbase.org/cgi-bin/query.pl?terms='+ row[column] +'&submit=Search';
                    v = "<a href='" + url + "' target='_blank'>" + row[column] + " </a>"
                }

                else if (column=="chem_name")
                {
                    url = 'http://ctdbase.org/detail.go?type=chem&acc='+ row["chem_ctd_id"];
                    v = "<a href='" + url + "' target='_blank'>" + row[column] + " </a>"
                }

                else if(column=="chem_ctd_id")
                {

                }

                else {
                    v = row[column];
                }
                return {column: column, value: v};

            });
        })
        .enter()
        .append("td")
        .attr("style", "font-family: Helvetica") // sets the font style
            .html(function(d) { return d.value; });
    
    return table;
}

    // render the table
    tabulate(passChoice, headers);



}