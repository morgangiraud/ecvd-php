<?php
session_start();
session_regenerate_id();

if(isset($_SESSION['id'])){
  $_SESSION['accessCount']++;
  echo "My session id is " . $_SESSION['id'] . ", you've accessed this page " . $_SESSION['accessCount'] . " times. <br>";
  // You can also access your cookies from the PHP server
  echo "My cookies: "; 
  var_dump($_COOKIE);
  echo "<br>";
  if($_SESSION['accessCount'] === 3){
    session_destroy();
    // Be carefull until this script ends, $_SESSION is still populated with data
    echo "Your session has been destroyed. <br>";
  }
} else {
  $_SESSION['id'] = rand();
  $_SESSION['accessCount'] = 0;
}

echo "hello world";