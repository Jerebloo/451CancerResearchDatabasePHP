<?php 

	require_once('dBaseAccess.php');
	//fetch table rows from mysql db
	$sql = "SELECT chem_name , mirna_name, response, cond, tech, chem_pubId, chem_ctd_id
			from chemical, main_v2 
			where main_v2.chem_id=chemical.chem_id 
			and chem_name in ('".$mirna."')  LIMIT 30";
	$result = mysqli_query($mirnabDb, $sql) or die("Error in Selecting " . mysqli_error($mirnabDb));

	//create an array
	$reparray = array();
	for ($x = 0; $x < mysqli_num_rows($result); $x++) {
		$reparray[] = mysqli_fetch_assoc($result);
	}
	$piechart = json_encode($reparray);
	echo $piechart;

// Instead you can query your database and parse into JSON etc etc

?>