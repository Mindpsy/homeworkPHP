<?php 
// authorise 
session_start();

if (isset($_POST['nameUser']) && isset($_POST['pass'])) {
    if ($dh = opendir("authorise")) {
        while (($file = readdir($dh)) !== false) {
            if ($file != "." && $file != "..") {
                if($file == "login.json") {
                    $obj = file_get_contents("authorise/$file");
                    $objauthorise = json_decode($obj);
                    break;
                }
            }
        }
        if(isset($objauthorise)) {
            if($_POST['nameUser'] == $objauthorise->login && $_POST['pass'] == $objauthorise->pass) {
                $_SESSION['adminStatus'] = true;
                $_SESSION['name'] = $_POST['nameUser'];


            } else {
                echo "Wrong login or password";
            }
        } else {
            echo "error decoding json";
        }
    } else {
        echo "Miss out files authorise";
    }

}

// continue athorise by guest 
if(isset($_POST['enterGuest'])) {
    $nameGuest = $_POST['nameGuest'];
    if (empty($_SESSION['name']) || !$_SESSION['guestStaus']) {
        $_SESSION['name'] = $nameGuest;
        $_SESSION['guestStaus'] = 1;
    }
    
}

// if does not authorised 
if(empty($_SESSION['adminStatus']) && empty($_SESSION['guestStaus'])) {
    header("HTTP/1.0 404 Not Found");
    die;
}

// when log out 
if(isset($_POST['logOut'])) {
    session_destroy();
}

// html with some php 
?>
<!DOCTYPE>
    <html>
        <head>
            <meta charset="UTF-8">
            <title>Список тестов</title>
            <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
    
        </head>
        <body>
        <?php if(!empty($_SESSION['adminStatus']) || !empty($_SESSION['guestStaus'])):?>
        <h3>Здравствуйте <?=$_SESSION['name'] ?></h3>
        <form method="post" class="form-group">
            <input type="submit" name="logOut" value="Выйти" class="form-control">
        </form>
        <?php endif; ?>
            <table class="table">
                <tr>
                    <td>Номер теста</td>
                    <td>Путь теста</td>
                    <td>Пройти тест</td>
                    <td>Удалить тест</td>
                </tr>
                <?php
                // scanning files from catalog 
                if ($dh = opendir("tests")):
                    while (($file = readdir($dh)) !== false):
                        if ($file != "." && $file != ".."):
                            static $numT = 0;
                            $numT++;
                ?>
                <tr>
                    <td><?=$numT ;?></td>
                    <td><?=$file ;?></td>
                    <td><a href="/test.php?numberTest=<?=$file; ?>">Пройти тест</a></td>
                    <?php if($_SESSION['adminStatus']): 
                        $stringDel = "deleteTest.php?pathDel=tests/$file"; ?>
                    <td><a href="<?=$stringDel; ?>">Удалить</a></td>
                    <?php endif; ?>
                </tr>
                        <?php endif; 
                    endwhile;
                    closedir($dh);
                endif; ?>
            </table>
            <?php if($_SESSION['adminStatus']): ?>
            <form action="admin.php" class="form-group" method="post">
                <input type="submit" value="Добавить новый тест" class="form-control" />
            </form>
            <?php endif; ?>
                
        </body>
    </html>