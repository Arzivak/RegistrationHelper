<?php

class Prerequisite{
	private $conn;
	public $name; //Name of the class that has the prereq "class"
	public $class;
	public $logic;
	public $group;


	public function __construct($db){
		$this->conn = $db;
	}

	function create($name1, $class1, $logic1, $group1){
		//echo "in create!";
		$this->name = $name1;
		$this->class = $class1;
		$this->logic = $logic1;
		$this->group = $group1;
		$queryPre = "INSERT INTO prereqs SET class=:name, prereq=:prereq, logic=:logic, relation=:group";

		$sendPre = $this->conn->prepare($queryPre);

		// $sendPre->bindParam(':name', $this->name);
		// $sendPre->bindParam(':prereq', $prereq);
		// $sendPre->bindParam(':logic', $logic);
		// $sendPre->bindParam(':group', $group);

		
		//echo " In for each loop";
		$sendPre->bindParam(":name", $this->name);
		$sendPre->bindParam(":prereq", $this->class);
		$sendPre->bindParam(":logic", $this->logic);
		$sendPre->bindParam(":group", $this->group);
		//echo $queryPre;
		$sendPre->execute();
	}

	// function read(){
	// 	$queryP="SELECT *
	// 			FROM prereqs
	// 			WHERE class=" . $this->name .;
	// 	$stmt = $this->conn->prepare($queryP);

	// 	$stmt->execute();
		
	// 	$num = $stmt->rowCount();

	// 	if($num >0){
	// 		$prereqs_arr=array();
 //    		$prereqs_arr["prereqs"]=array();
 //    		while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
 //        // extract row
 //        // this will make $row['name'] to
 //        // just $name only
	//         	extract($row);
	 
	//         	$product_item=array(
	// 	            "prereq" => $prereq,
	// 	            "logic" => $logic,
	// 	            "relation" => $relation
	//         	);
 
 //        		array_push($products_arr["prereqs"], $product_item);
 //    		}
 //    		echo json_encode($products_arr);
	// 	} else {
	// 		echo json_encode(array("message" => "No prereqs found."));
	// 	}

	// }

	function update(){
		$query = "UPDATE prereqs SET logic=:logic, relation=:group WHERE class=\"" . $this->name . "\" AND prereq=\"" . $this->class . "\"";

		$stmt = $this->conn->prepare($query);

		$stmt->bindParam(":logic", $this->logic);
		$stmt->bindParam(":group", $this->group);

		echo "bound parameters";
		if($stmt->execute()){
			return true;
		} else {
			return false;
		}
	}

	function delete(){
		//$query = "DELETE FROM prereqs WHERE class=\"" . $this->name . "\" AND prereq=\"" . $this->class . "\"";

		$query = "DELETE FROM prereqs WHERE class=:class AND prereq=:prereq";

		$stmt = $this->conn->prepare($query);
		$stmt->bindParam(":class", $this->name);
		$stmt->bindParam(":prereq", $this->class);

		echo $query;
		if($stmt->execute()){
			return true;
		} else {
			return false;
		}

	}


	
}