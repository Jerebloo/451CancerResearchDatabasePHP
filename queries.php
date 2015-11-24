<?php
	require_once('dBaseAccess.php');
	$results = array();
	// check if mirna is sent using POST method
	if (ISSET($_POST['mirna'])) {
		# code...
		$mirna = mysqli_real_escape_string($mirnabDb, $_POST['mirna']);
		
		$query = 
			"SELECT DISTINCT 
			    mirna_name AS source, 
			    dis_name AS target, 
			    dis_reguln AS type
			FROM main_v2, disease 
			WHERE main_v2.link_id = disease.link_id AND mirna_name = '".$mirna."' LIMIT 30";

		$result = mysqli_query($mirnabDb, $query);

		for ($x = 0; $x < mysqli_num_rows($result); $x++) {
        $data[] = mysqli_fetch_assoc($result);
    }
	  	echo json_encode($data);
	}
?>