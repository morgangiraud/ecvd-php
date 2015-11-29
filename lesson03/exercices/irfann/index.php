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

        $file = 'users.txt';

        if(isset($_POST['name']) && empty($_POST['name']) == false && empty($_POST['pwd']) == false && isset($_POST['pwd'])) {
            $name = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
            $pwd = filter_var($_POST['pwd'], FILTER_SANITIZE_STRING);
            
            $data = trim($name) . './/.' . hash('haval256,5', trim($pwd)) . "\n";
            
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