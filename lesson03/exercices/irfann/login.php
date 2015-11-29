<?php
    session_start();
    session_regenerate_id();
    if($_SESSION['login_user'] && $_SESSION['pwd_user']){
        header('Location: connect.php');
        exit;
    }
?>

    <h1>Login page</h1>

    <form method="post">
        <p>Name:
            <input type="text" name="name"/>
        </p>
        <p>PWD:
            <input type="pwd" name="pwd"/>
        </p>
        <p>
            <input type="submit" value="Valider"/>
        </p>
    </form>

    <?php
        $file = "users.txt";

        function return_bytes($val) {
            $val = trim($val);
            $last = strtolower($val[strlen($val)-1]);
            switch($last) {
                case 'g':
                    $val *= 1024;
                case 'm':
                    $val *= 1024;
                case 'k':
                    $val *= 1024;
            }

            return $val;
        }
        //echo return_bytes(ini_get('post_max_size')). "     ";

        if(isset($_POST['name']) && empty($_POST['name']) == false && empty($_POST['pwd']) == false && isset($_POST['pwd'])) {
            $name = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
            $pwd = filter_var($_POST['pwd'], FILTER_SANITIZE_STRING);
            
            $data = trim($name) . './/.' . hash('haval256,5', trim($pwd)) . "\n";
            
            $sizeLimit = return_bytes(ini_get('post_max_size'));
            //echo filesize($file). "b   ";
            if ($sizeLimit > filesize($file)) {
        
                //var_dump(file($file));
                
                foreach(file($file) as $line) {
                    if($line == $data) {
                        //echo $data . " is in the users.txt in the loop First condition";

                        $_SESSION['login_user']=$_POST['name'];
                        $_SESSION['pwd_user']=$_POST['pwd'];
                        
                        header('Location: connect.php');
                        exit;
                    }
                }
            } else {
                $handle = fopen($file, 'r');
                $valid = false; 
                while (($buffer = fgets($handle)) !== false) {
                    if (strpos($buffer, $data) !== false) {
                        $valid = TRUE;
                        
                        //echo $data . " is in the users.txt in the loop Second condition";

                        $_SESSION['login_user']=$_POST['name'];
                        $_SESSION['pwd_user']=$_POST['pwd'];
                        
                        header('Location: connect.php');
                        exit;
                        
                        break;
                    }      
                }
                fclose($handle);
            }

        }
        else {
           die('no post data to process');
        }
    ?>
