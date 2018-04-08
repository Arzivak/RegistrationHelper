<?PHP
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");


include_once "connect.php";
include_once "major.php";


$connection = new Database();
$db = $connection->connect();

$aMajor = new Major($db);
$data = $_POST["x"];
//$aMajor->name="Science1";
$aMajor->name=$data["major"];


$holder = $aMajor->getClassGroups();
echo json_encode($holder);


?>