<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>PHP</title>
</head>

<body>
    <h1>Register page</h1>

    <form method="post">
        <p>Name:
            <input type="text" name="name" />
        </p>
        <p>PWD:
            <input type="pwd" name="pwd" />
        </p>
        <p>
            <input type="submit" value="Valider" />
        </p>
    </form>

    <?php 

        $file = 'users.txt';
        function return_bytes($val) {
            $val = trim($val);
            $last = strtolower($val[strlen($val)-1]);
            switch($last) {
                // The 'G' modifier is available since PHP 5.1.0
                case 'g':
                    $val *= 1024;
                case 'm':
                    $val *= 1024;
                case 'k':
                    $val *= 1024;
            }

            return $val;
        }
        return_bytes(ini_get('post_max_size'));
        if(isset($_POST['name']) && isset($_POST['pwd'])) {
            $data = $_POST['name'] . './/.' . $_POST['pwd'] . "\n";
            $ret = file_put_contents($file, $data, FILE_APPEND | LOCK_EX);
            if($ret === false) {
                die('There was an error writing this file');
            }
            else {
                echo "$ret bytes written to file";
            }
        }
        else {
           die('no post data to process');
        }
    ?>
</body>

</html>