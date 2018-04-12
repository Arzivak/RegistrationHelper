<?PHP
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

//echo "in prereqTest";
include_once "connect.php";
include_once "student.php";


$connection = new Database();
$db = $connection->connect();

$stu = new Student($db);


$stu->ucid=$_POST["x"];


//echo "got through creating vars";
if($stu->create()){
	echo json_encode(array('success' => true));
} else {
	echo json_encode(array('success' => false));
}
?>