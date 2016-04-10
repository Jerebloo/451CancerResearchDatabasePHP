<?PHP

$servername = "localhost";
$username = "root";
$password = "magician";
$database = "mirnabkp";
//store your personal database information

// Create connection
$mirnabDb = new mysqli($servername, $username, $password, $database);
// Check connection
if ($mirnabDb->connect_error) {
    die("Connection failed: " . $mirnabDb->connect_error);
} 

?>
