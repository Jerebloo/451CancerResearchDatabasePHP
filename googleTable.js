

      function drawTable(jsonData) {
        console.log("\nwat\n" + typeof jsonData);
        var data = new google.visualization.DataTable();
        data.addColumn('string', 'Chemical');
        // data.addColumn('string', 'miRNA');
        // data.addColumn('string', 'Response');
        // data.addColumn('string', 'Condition');
        // data.addColumn('string', 'Tech');
        // data.addColumn('string', 'PubId');
        var numRows = jsonData.length; 
                var numCols = 6;

        data.addRows(numRows);
         capitalChemicalNameMain = [jsonData[0]['chem_name']] 
         data.setCell(0, 0, capitalChemicalNameMain );
      
        var table = new google.visualization.Table(document.getElementById('table'));

        table.draw(data, {showRowNumber: true, width: '100%', height: '100%'});
      }
