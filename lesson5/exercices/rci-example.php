<?php
require_once 'session.php';
require_once 'functions.php';
require_once 'connect.php';

if(isset($_GET['route'])){
  $page = $_GET['route'];
} else {
  $page = "rci-index.php";
}

include 'header.php';
?>
<body>
<?php
  include $page;
?>  
</body>
</html>