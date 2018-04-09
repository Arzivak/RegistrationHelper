<?PHP
include "aClass.php";
//include "connect.php";
class Major{
	private $conn;
	public $template_name;
	public $studentTable_name;
	public $name;

	public $classes;

	public function __construct($db){
		$this->conn = $db;
	}

	function create(){
		// $this->template_name = $name . "_template";
		// $this->studentTable_name = $name . "_students";
		//echo "   in create";
		$count = 0;
		$query = "CREATE TABLE " . $this->name . "_template (CLASS VARCHAR(15) NOT NULL, CLASSGROUP VARCHAR(30) NOT NULL, CLASS_ORDER INT(3) NOT NULL);
				  CREATE TABLE " . $this->name . "_students (UCID VARCHAR(15) NOT NULL);
				  INSERT INTO all_majors VALUES (\"" . $this->name . "\")";

		//$query = "INSERT INTO all_majors VALUES (\"Computer Science\")";
		//echo $query;
		$stmt = $this->conn->prepare($query);

		if($stmt->execute()){
			//echo " sent query";
			return true;
		}

		// $stmt2 = $this->conn->prepare($query2);
		// echo " wrote second string";
		// if($stmt2->execute()){
		// 	echo " created second";
		// 	$count++;
		// }

		// if($count == 2){
		// 	return true;
		// } else {
		// 	false;
		// }
	}

	function getClasses(){
		//echo "in get classes major.php";
		$query = "SELECT class FROM " . $this->name . "_template";

		$stmt = $this->conn->prepare($query);

		$stmt->execute();
		// if($stmt->execute()){
		// 	echo "THIS WORKS";
		// }

		$rows = $stmt->fetchAll();
		$classes=array();
		foreach($rows as $x){
    		echo $x;
    		array_push($classes, $x['class']);
    	}
    	echo json_encode($classes);
    	$allClasses=array();
    	foreach($classes as $class){
    		echo $class;
    		
    		$connection = new Database();
    		$db = $connection->connect();
    		$aClass = new aClass($db);
    		$aClass->name=$class;
    		$aClass->major=$this->name;
    		//echo json_encode($aClass->readOne());
    		array_push($allClasses,$aClass->readOne());
    	}
    	//echo json_encode($allClasses);
    	return $allClasses;

	}

	function getClassGroups(){
		$query = "Select Distinct CLASSGROUP from " . $this->name . "_template";

		$stmt = $this->conn->prepare($query);
		
		$stmt->execute();
		// if($stmt->execute()){
		// 	echo " getting class groups";
		// }
		$rows = $stmt->fetchAll();
		$allGroups=array();
		foreach ($rows as $x) {
			array_push($allGroups, $x['CLASSGROUP']);
		}
		//echo json_encode($allGroups);
		return $allGroups;
	}

	function getAllMajors(){
		$query = "Select * from all_majors";
		$stmt = $this->conn->prepare($query);

		$stmt->execute();

		$rows = $stmt->fetchAll();
		$allMajors=array();
		foreach ($rows as $x) {
			array_push($allMajors, $x['majors']);
		}
		//echo json_encode($allMajors);
		return $allMajors;
	}

	
	
}	
?>