<?PHP
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

//echo "in prereqTest";
include_once "connect.php";
include_once "prerequisite.php";


$connection = new Database();
$db = $connection->connect();

$pre = new Prerequisite($db);

//$data = json_decode(file_get_contents("php://input"));


$n = $_POST["name"];
$p = $_POST["prereq"];
$l = $_POST["logic"];
$g = $_POST["group"];

// $n = "MATH 101";
// $p = "CS 114";
// $l = "AND";
// $g = "1";

//echo "got through creating vars";
if($pre->create($n, $p, $l, $g)){
	echo json_encode(array(
		'success' => true,
		'return' => array(
			'name' => $n,
			'prereq' => $p,
			'logic' => $l,
			'group' => $g
			)
		);
	);
} else {
	echo json_encode(array('success' => false));
}
?>