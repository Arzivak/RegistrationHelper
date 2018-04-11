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


$data = $_POST["x"];
$holder->ucid=$data["ucid"];
$holder->major= $data["major"];
// $holder->major="Science1";
// $holder->ucid="mgt23";
//echo "in get all classes";
echo $holder->getAllClassesStudent();
?>
