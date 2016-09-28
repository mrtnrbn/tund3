<?php 
	
	$database = "if16_romil";
	// functions.php
	
	function signup($email, $password) {
		
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
		
		$stmt = $mysqli->prepare("INSERT INTO user_sample (email, password) VALUE (?, ?)");
		echo $mysqli->error;

		$stmt->bind_param("ss", $email, $password);

		if ( $stmt->execute() ) {
			echo "õnnestus";
		} else {
			echo "ERROR ".$stmt->error;
		}
		
	}
	
	function login ($email, $password)	{
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
		
		$stmt = $mysqli->prepare("
			SELECT id, email, password, created
			FROM user_sample
			WHERE email=?
		");
		echo $mysqli->error;
		
		//asendan kysimargi
		$stmt->bind_param("s", $email);
		// rea kohta tulba vaartus
		$stmt->bind_result($id, $emailFromDB, $passwordFromDB, $created);
		
		$stmt->execute();
		//ainult selecti puhul
	if($stmt->fetch())	{
			//oli olemas, rida kaes
			$hash = hash("sha512", $password);
			
			if($hash == $passwordFromDB) {
				echo "kasutaja $id logis sisse";
			} else {echo "parool vale";
			
			}
			
		}	else	{
				//ei olnud yhtegi rida
				echo "Sellise emailiga ".$email." kasutajat ei ole olemas";		
			} 
	}
	
	
	
	
	
	
	
	
	/*function sum($x, $y) {
		
		return $x + $y;
		
	}
	
	echo sum(12312312,12312355553);
	echo "<br>";
	
	
	function hello($firstname, $lastname) {
		return 
		"Tere tulemast "
		.$firstname
		." "
		.$lastname
		."!";
	}
	
	echo hello("romil", "robtsenkov");
	*/

?>