<?PHP
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");


include_once "connect.php";
include_once "class.php";

$connection = new Database();
$db = $connection->connect();
$aclass = new aClass($db);


$data = $_POST["x"];
//$data = json_decode(file_get_contents("php://input"));
$aclass->name= $data["name"];

//$aclass->name = "CS 241";
echo json_encode($aclass->readOneSimple());
?>