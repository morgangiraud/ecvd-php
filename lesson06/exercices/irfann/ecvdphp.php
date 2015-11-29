<?php
	namespace ecvdphp{
		function redirect($dest){
		  header('Location: ' . $dest, true, 301);
		  exit();  
		}

		function checkFile(){
			
		}
	}
?>