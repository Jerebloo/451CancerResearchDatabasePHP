
// the table rows, typically loaded from data file using d3.csv
    function createTable(passChoice,divChoice){

    // Set the dimensions of the canvas / graph

// Parse the date / time

// Set the ranges


// Get the data

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
        .data(columns)
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
                return {column: column, value: row[column]};
            });
        })
        .enter()
        .append("td")
        .attr("style", "font-family: Helvetica") // sets the font style
            .html(function(d) { return d.value; });
    
    return table;
}

    // render the table
    tabulate(passChoice, ["source", "target", "type"]);

}