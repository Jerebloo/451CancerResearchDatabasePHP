
<?php

// this code is accessed from the ajax request on the search page
// this page has access to the data declared in the ajax on the search page (it can grab the data 'mirna' through post)
// the query will return columns which are : chemicals, miRNAs, regulations(response), conditions, tech, the pubmed ID, the chemical id
// the tables are linked on the chem_id from main_v2 and chemical
// results are given for a specific chemical chosen from the dropdown menu
// the json type object acheived at the end of the php is sent back to the search page

	require_once('dBaseAccess.php');
	$results = array();
	// check if mirna is sent using POST method
	if (ISSET($_POST['mirna'])) {
		# code...
		$mirna = mysqli_real_escape_string($mirnabDb, $_POST['mirna']);
		
		$query = 
			"SELECT chem_name , mirna_name, response, cond, tech, chem_pubId, chem_ctd_id
			from chemical, main_v2 
			where main_v2.chem_id=chemical.chem_id 
			and chem_name in ('".$mirna."')  LIMIT 30";

		$result = mysqli_query($mirnabDb, $query);

		for ($x = 0; $x < mysqli_num_rows($result); $x++) {
        $data[] = mysqli_fetch_assoc($result);
    }
	  	echo json_encode($data);
	}

?>

