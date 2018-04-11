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
//$data = $_POST["x"];
$pre->name = $_POST["name"];
$pre->class = $_POST["class"];
$pre->logic = $_POST["logic"];
$pre->group = $_POST["group"];

// $pre->name = "CS 491";
// $pre->class = "CS 490";
// $pre->logic = "OR";
// $pre->group = "1";

if($pre->update()){
	echo json_encode(array(
		'success' => true,
		'return' => array(
			'name' => $pre->name,
			'class' => $pre->class,
			'logic' => $pre->logic,
			'group' => $pre->group
			)
		)
	);
} else {
	echo json_encode(array('success' => false));
}
?>
