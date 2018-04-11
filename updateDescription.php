<?php 
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once "connect.php";
include_once "class.php";

$database = new Database();
$db = $database->connect();

$aclass = new aClass($db);

//$data = json_decode(file_get_contents("php://input"));
//$data = $_POST["x"];
$aclass->name = $_POST["name"];
$aclass->description = $_POST["description"];


// $aclass->name = "USYS 790E";
// $aclass->description = "NOT Roadmap to Computing";
// $aclass->prereqs=array(
// 					array("CS 100","AND", 1),
// 					array("CS 113","AND", 1),
// 					array("CS 114","AND", 1)
// 				);

if($aclass->create()){
	echo json_encode(
		array(
			'success' => true,
			'return' => array(
				'name' => $aclass->name,
				'description' => $aclass->description
				)
		);
		
	);
} else {
	echo json_encode(
		array('success' => false)
	);
}


?>