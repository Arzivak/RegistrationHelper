<?PHP
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

echo "in prereqTest";
include_once "connect.php";
include_once "prerequisite.php";


$connection = new Database();
$db = $connection->connect();

$pre = new Prerequisite($db);

$data = json_decode(file_get_contents("php://input"));


$n = $data["name"];
$p = $data["prereq"];
$l = $data["logic"];
$g = $data["group"];

// $n = "MATH 101";
// $p = "CS 114";
// $l = "AND";
// $g = "1";

echo "got through creating vars";
if($pre->create($n, $p, $l, $g)){
	echo " SUCCESS";
} else {
	echo " FAILED";
}
?>