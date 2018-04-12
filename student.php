<?PHP
//include "connect.php";
class Student{
	private $conn;
	public $ucid;



	public function __construct($db){
		$this->conn = $db;
	}

	function create(){
		$query = "SELECT * FROM studentMajor WHERE UCID=\"" . $this->ucid . "\"";

		$query2 = "INSERT INTO studentMajor (UCID, Major) VALUES(\"$this->ucid\",\"Science1\");
		INSERT into Science1_students (UCID) VALUES (\"$this->ucid\")";


		$stmt = $this->conn->prepare($query);
		$stmt2 = $this->conn->prepare($query2);
		//echo $query;
		if($stmt->execute()){

			$rows = $stmt->fetchAll();
			if(sizeof($rows) > 0){
				//echo json_encode($rows);
				$majors = array();
				foreach($rows as $x){
					array_push($majors, $x['Major']);
				}
				//echo json_encode($majors);
				return true;
			} else {
				echo $query2;
				if($stmt2->execute()){
					//echo $query2;
					return true;
				}
			}

			return true;


		} else {
			
			return false;
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

	
}	
?>