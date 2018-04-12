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
$holder = new aClass($db);

//$data = json_decode(file_get_contents("php://input"));
//$holder->major= $data["name"];

$hold = $_POST["x"];


// $data=array();
// $first=array(
// 	"name" => "CS 100",
// 	"ucid" => "mgt23",
// 	"major" => "Science1"
// );
// array_push($data, $first);


foreach($hold as $x){
	$holder->name=$x["name"];
	$holder->ucid=$x["ucid"];
	$holder->major=$x["major"];
	//$holder->updateStudentRecord();
	if($holder->revertStudentRecord()){
		echo "Worked";
	} else {
		echo "Failed";
	}
}



?>
