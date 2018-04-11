<?PHP
header("Access-Control-Allow-Origin: *");
//header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once "connect.php";
include_once "class.php";

$database = new Database();
$db = $database->connect();

$aclass = new aClass($db);

//$data = $_POST["x"];
//$data = json_decode(file_get_contents("php://input"));
//$data = file_get_contents("php://input");
//print_r($_POST);
// echo $_POST["name"];
// echo $_POST["major"];
// echo $_POST["class_group"];
// echo $_POST["order"];

// $n = $data["name"];
// $p = $data["prereq"];
// $l = $data["logic"];
// $g = $data["group"];

$aclass->name = $_POST["name"];
$aclass->order = $_POST["order"];
$aclass->class_group = $_POST["class_group"];
$aclass->major = $_POST["major"];

// $aclass->name = $_POST["name"];
// $aclass->order = $_POST["order"];
// $aclass->class_group = $_POST["class_group"];
// $aclass->major = $_POST["major"];

// // $aclass->name = "MATH 121";
// // $aclass->order = "2";
// // $aclass->class_group = "MATH GUR";
// // $aclass->major = "Science1";

if($aclass->addClassToMajor()){
	echo json_encode(
		array(
			'success' => true,
			'return' => array(
				'name' => $aclass->name,
				'order' => $aclass->order,
				'class_group' => $aclass->class_group,
				'major' => $aclass->major
				)
		);
		
	);
} else {
	echo json_encode(
		array('success' => false)
	);
}
?>
