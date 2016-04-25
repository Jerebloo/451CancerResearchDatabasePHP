<?PHP
//store your personal database information
$servername = "localhost";
$username = "root";
$password = "magician";
$database = "mirnabkp";

// Create connection
// note that in miRNA-Drug.php  that another database is accessed, we don't have to do that explicitly here because mysql allows 
// access to all databases in the same localhost server 
$mirnabDb = new mysqli($servername, $username, $password, $database);
// Check connection
if ($mirnabDb->connect_error) {
    die("Connection failed: " . $mirnabDb->connect_error);
} 

?>
