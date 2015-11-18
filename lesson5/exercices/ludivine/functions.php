<?php

	    try{
	    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
	    $conn->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION ); 
	    }   
	    catch (\PDOException $e){
	    echo $e->getMessage();
	    }


	    try {

		$result = $conn->query("SELECT username, password, email FROM users WHERE email='".$_POST["nom"]."".$_POST["mdp"]."".$_POST["email"]."'")->fetchAll();
	    	var_dump($result);
	    }

        try{
        $result = $conn->prepare('INSERT INTO users (username, password, email) VALUES (:username, :password, :email)');
        $result->bindParam(':username', $_POST['nom'], PDO::PARAM_STR);
        $result->bindParam(':password', $_POST['mdp'], PDO::PARAM_STR);
        $result->bindParam(':email', $_POST['email'], PDO::PARAM_STR);
        $result->execute();
        var_dump($result);
        }   
        catch (\PDOException $e){
        echo $e->getMessage();

        }


		try{

		  $conn->query("SELECT username, password, email FROM users WHERE email='".$_POST["nom"]."".$_POST["mdp"]."".$_POST["email"]."'")->fetchAll(); 
		} catch (\PDOException $e){ // 
		  $logger->log($e->getMessage());
		} finally {
		  $results = $conn->query('SELECT username, password, email FROM users')->fetchAll(); // fallback
		}
		echo "Échec lors de la connexion : " . $e->getMessage();
		?>

?>