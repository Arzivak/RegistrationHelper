<?php
class aClass{
	private $conn;
	private $table_name; //add prereq table here

	public $major;
	public $class_group;
	public $order;
	public $logic;
	public $name;	
	public $description;
	public $prereqs;
	public $ucid;

	public function __construct($db){
		$this->conn = $db;
	}

	function create(){
		//echo "in create class";
		$query = "UPDATE all_classes_distinct SET description=:description WHERE class=:name";

		$send = $this->conn->prepare($query);

		$this->name=htmlspecialchars(strip_tags($this->name));
		$this->description=htmlspecialchars(strip_tags($this->description));

		$send->bindParam(":name", $this->name);
		$send->bindParam(":description", $this->description);


		if($send->execute()){
			return true;
		} else {
			return false;
		}

		/////THIS IS A TEST WITH THE PREREQ CLASS
		// foreach($prereqs as $x){
		// 	$connection = new Database();
		// 	$db = $connection->connect();
		// 	$prereq = new Prerequisite($db);
		// 	$prereq->create($this->name, $x[0],$x[1],$x[2]);
		// }
		////END TEST WITH PREREQ CLASS	
	}

	function getClassList(){
		$query = "Select class from all_classes_distinct";

		$stmt = $this->conn->prepare($query);
		$stmt->execute();

		$rows = $stmt->fetchAll();
		$classes=array();
		foreach($rows as $x){
    		//echo $x;
    		array_push($classes, $x['class']);
    	}
    	return $classes;
	}

	function addClassToMajor(){
		$query = "ALTER TABLE " . $this->major . "_students ADD `" . $this->name . "` VARCHAR(10) NOT NULL;
			INSERT INTO " . $this->major . "_template SET CLASS=:name, CLASSGROUP=:group, CLASS_ORDER=:order";


		$stmt = $this->conn->prepare($query);
		//echo " prepared";
		$stmt->bindParam(":name", $this->name);
		$stmt->bindParam(":group", $this->class_group);
		$stmt->bindParam(":order", $this->order);
		//echo " bound";
		if($stmt->execute()){
			//echo "created";
			return true;
		} else {
			//echo "failed";
			return false;
		}

	}

	function removeClassFromMajor(){
		$query = "DELETE FROM " . $this->major . "_template WHERE CLASS=\"" . $this->name . "\";
		ALTER TABLE " . $this->major . "_students DROP COLUMN `" . $this->name . "`";
		echo $query;
		$stmt = $this->conn->prepare($query);
		
		if($stmt->execute()){
			//echo " CREATED";
			return true;
		} else {
			//echo " FAILED";
			return false;
		}
	}


	function readOne(){

		$oneClass=array();
		// $queryD="SELECT *
		// 		 FROM all_classes_distinct
		// 		 WHERE class=\"" . $this->name ."\"";

		$queryN = "SELECT * FROM all_classes_distinct INNER JOIN " . $this->major ."_template on all_classes_distinct.class = " . $this->major ."_template.CLASS WHERE all_classes_distinct.class = \"" . $this->name ."\"";


		//echo $queryN;
		//print_r($queryN);			 

		$stmt= $this->conn->prepare($queryN);
		$stmt->execute();
		// if($stmt->execute()){
		// 	echo "SUCCESS";
		// } else {
		// 	echo "FALSE";
		// }

		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		//print_r($row['description']);
		//echo var_dump($row);
		$oneClass["class"]=$this->name;
		$oneClass["description"]=$row['description'];
		$oneClass["order"]=$row['CLASS_ORDER'];
		$oneClass["group"]=$row['CLASSGROUP'];

		$oneClass["prereqs"]=$this->getPrereqs();
		//echo json_encode($oneClass);
		return $oneClass;
	}

	function readOneSimple(){
		$query1 = "SELECT * from all_classes_distinct where class=\"" . $this->name . "\"";
		$stmt = $this->conn->prepare($query1);

		$stmt->execute();
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		//print_r($row['description']);
		//echo var_dump($row);
		$oneClass=array();
		$oneClass["class"]=$this->name;
		$oneClass["description"]=$row['description'];
		$oneClass["prereqs"]=$this->getPrereqs();
		return $oneClass;
	}


		
	// }
	function getPrereqs(){
		
		$queryP="SELECT *
				FROM prereqs
				WHERE class=\"" . $this->name . "\"";


			
		$stmt = $this->conn->prepare($queryP);
		// if($stmt->execute()){
		// 	echo "success";
		// } else {
		// 	echo "failed";
		// }
		$stmt->execute();
		$rows = $stmt->fetchAll();
	
    	$prereqs_arr=array();

    	foreach($rows as $x){
    		$onePrereq=array(
    		// "prereq" => $rows[0]['prereq'],
    		// "logic" => $rows[0]['logic'],
    		// "group" => $rows[0]['relation']
    		"prereq" => $x['prereq'],
    		"logic" => $x['logic'],
    		"group" => $x['relation']

    		);
    		array_push($prereqs_arr, $onePrereq);
    	}
    	//echo json_encode($prereqs_arr);
    	return $prereqs_arr;


    	// $onePrereq=array(
    	// 	"prereq" => $rows[0]['prereq'],
    	// 	"logic" => $rows[0]['logic'],
    	// 	"group" => $rows[0]['relation']
    	// );

    	//echo json_encode($onePrereq);

  //   		return json_encode($products_arr);
		// } else {
		// 	return json_encode(array("message" => "No prereqs found."));
		// }
	}

	function getAllClassesMajor(){
		$query = "SELECT class FROM " . $this->major . "_template";

		$stmt = $this->conn->prepare($query);

		$stmt->execute();
		// if($stmt->execute()){
		// 	echo "THIS WORKS";
		// }

		$rows = $stmt->fetchAll();
		$classes=array();
		foreach($rows as $x){
    		//echo $x;
    		array_push($classes, $x['class']);
    	}
    	//echo json_encode($classes);
    	$allClasses=array();
    	//$this->name=$classes[3];
    	//echo json_encode($this->readOne());
    	foreach($classes as $class){
    		//echo $class;
    		
 
    		$this->name=$class;
    		//echo $this->name;
    		//echo json_encode($this->readOne());
    		
    		array_push($allClasses,$this->readOne());
    	}
    	//echo json_encode($allClasses);
    	return json_encode($allClasses);
	}




///INDERPAL SECTION
	function getAllClassesStudent(){
		$query = "SELECT class FROM " . $this->major . "_template";

		$stmt = $this->conn->prepare($query);

		$stmt->execute();
		// if($stmt->execute()){
		// 	echo "THIS WORKS";
		// }

		$rows = $stmt->fetchAll();
		$classes=array();
		foreach($rows as $x){
    		//echo $x;
    		array_push($classes, $x['class']);
    	}
    	//echo json_encode($classes);
    	$allClasses=array();
    	//$this->name=$classes[3];
    	//echo json_encode($this->readOne());
    	foreach($classes as $class){
    		//echo $class;
    		
 
    		$this->name=$class;
    		//echo $this->name;
    		//echo json_encode($this->readOne());
    		
    		array_push($allClasses,$this->readOneStudent());
    	}
    	//echo json_encode($allClasses);
    	return json_encode($allClasses);
	}
	
	 function readOneStudent(){

		$oneClass=array();
		// $queryD="SELECT *
		// 		 FROM all_classes_distinct
		// 		 WHERE class=\"" . $this->name ."\"";

		$queryN = "SELECT * FROM all_classes_distinct INNER JOIN " . $this->major ."_template on all_classes_distinct.class = " . $this->major ."_template.CLASS WHERE all_classes_distinct.class = \"" . $this->name ."\"";
		//echo $queryN;
		$queryS="SELECT * FROM " . $this->major . "_students WHERE UCID=\"". $this->ucid ."\""; //1
		//echo $queryS;
		//echo $queryN;
		//print_r($queryN);			 

		$stmt= $this->conn->prepare($queryN);
		$stmt2= $this->conn->prepare($queryS); //1
		$stmt->execute();
		$stmt2->execute(); //1
		

		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		$row2 = $stmt2->fetch(PDO::FETCH_ASSOC);
		//echo $row2;
		$oneClass["class"]=$this->name;
		$oneClass["code"]=$row2[$this->name];
		$oneClass["description"]=$row['description'];
		$oneClass["order"]=$row['CLASS_ORDER'];
		$oneClass["group"]=$row['CLASSGROUP'];

		$oneClass["prereqs"]=$this->getPrereqsStudent();
		//echo json_encode($oneClass);
		return $oneClass;
	}

	function getPrereqsStudent(){
		
		$queryP="SELECT *
				FROM prereqs
				WHERE class=\"" . $this->name . "\"";

		$queryS="SELECT * FROM " . $this->major . "_students WHERE UCID=\"". $this->ucid ."\"";
			
		$stmt = $this->conn->prepare($queryP);
		$stmt2 = $this->conn->prepare($queryS);
		// if($stmt->execute()){
		// 	echo "success";
		// } else {
		// 	echo "failed";
		// }
		$stmt->execute();
		$stmt2->execute();
		$rows = $stmt->fetchAll();
		//$row = $stmt2->fetchAll();
		$row = $stmt2->fetch(PDO::FETCH_ASSOC);
    	$prereqs_arr=array();
    	//$hold="'" .$this->name."'";
    	//echo $hold;
    	foreach($rows as $x){

    		
    		
    		// $row = $stmt2->fetch(PDO::FETCH_ASSOC);
    		// $code = $row[$this->name];
    		$hold = $x['prereq'];
 

    		$onePrereq=array(
    		"prereq" => $x['prereq'],
    		"logic" => $x['logic'],
    		"group" => $x['relation'],
    		"code" => $row[$hold]
    		);
    		array_push($prereqs_arr, $onePrereq);
    	}
    	//echo json_encode($prereqs_arr);
    	return $prereqs_arr;

	}


	function updateStudentRecord(){
		$query = "UPDATE " . $this->major . "_students SET `" . $this->name . "`=\"" . $this->code . "\" WHERE UCID=\"" . $this->ucid . "\"";
		//$query = "UPDATE " . $this->major . "_students SET `" . $this->name . "`=" . $this->code . " WHERE UCID=\"" . $this->ucid . "\"";

		//echo $query;
		$stmt = $this->conn->prepare($query);

		if($stmt->execute()){
			return true;
		} else {
			return false;
		}
	}


	function revertStudentRecord(){
		$query = "UPDATE " . $this->major . "_students SET `" . $this->name . "`=NULL WHERE UCID=\"" . $this->ucid . "\"";


		//echo $query;
		$stmt = $this->conn->prepare($query);

		if($stmt->execute()){
			return true;
		} else {
			return false;
		}
	}

	function getCode(){
		$queryS="SELECT * FROM " . $this->major . "_students WHERE UCID=\"". $this->ucid ."\"";

		$stmt2 = $this->conn->prepare($queryS);
		echo $queryS;
		if($stmt2->execute()){
			echo "Success";
		} else {
			echo "Failed";
		}
		$row2 = $stmt2->fetch(PDO::FETCH_ASSOC);
		//$row = $stmt2->fetchAll();
		echo $row2;
	}

}
?>
