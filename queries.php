<?php
	require_once('dBaseAccess.php');
	$results = array();
	// check if mirna is sent using POST method
	if (ISSET($_POST['mirna'])) {
		# code...
		$mirna = mysqli_real_escape_string($mirnabDb, $_POST['mirna']);
		
		$query = 
			"SELECT chem_name , mirna_name, response, cond, tech 
			from chemical, main_v2 
			where main_v2.chem_id=chemical.chem_id 
			and chem_name in ('".$mirna."')  LIMIT 10";

		$result = mysqli_query($mirnabDb, $query);

		for ($x = 0; $x < mysqli_num_rows($result); $x++) {
        $data[] = mysqli_fetch_assoc($result);
    }
	  	echo json_encode($data);
	}
?>