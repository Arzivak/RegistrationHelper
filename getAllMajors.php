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
$holder = new Major($db);

//$data = json_decode(file_get_contents("php://input"));
//$holder->major= $data["name"];
//$holder->major="Science1";
//$holder->ucid="mgt23";
//echo "in get all classes";
echo json_encode($holder->getAllMajors());
?>
