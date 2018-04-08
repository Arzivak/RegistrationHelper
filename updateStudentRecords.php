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
//echo json_encode($hold);

// $data=array();
// $first=array(
// 	"name" => "CS 113",
// 	"ucid" => "mgt23",
// 	"code" => "1F1",
// 	"major" => "Science1"
// );

// $second=array(
// 	"name" => "MATH 111",
// 	"ucid" => "mgt23",
// 	"code" => "1F1",
// 	"major" => "Science1"
// );

// array_push($data, $first);

// array_push($data, $second);
// echo json_encode($data);

// $holder->major="Science1";
// $holder->ucid="mgt23";
//echo "in get all classes";

foreach($hold as $x){
	$holder->name=$x["name"];
	$holder->code=$x["code"];
	$holder->ucid=$x["ucid"];
	$holder->major=$x["major"];
	//$holder->updateStudentRecord();
	if($holder->updateStudentRecord()){
		echo "Worked";
	} else {
		echo "Failed";
	}
}



?>
