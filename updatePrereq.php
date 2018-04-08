<?PHP
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");


include_once "connect.php";
include_once "prerequisite.php";

$connection = new Database();
$db = $connection->connect();
$pre = new Prerequisite($db);

//$data = json_decode(file_get_contents("php://input"));
$data = $_POST["x"];
$pre->name = $data["name"];
$pre->class = $data["class"];
$pre->logic = $data["logic"];
$pre->group = $data["group"];

// $pre->name = "CS 491";
// $pre->class = "CS 490";
// $pre->logic = "OR";
// $pre->group = "1";

if($pre->update()){
	echo "SUCCESS";
} else {
	echo "FAILED";
}
?>
