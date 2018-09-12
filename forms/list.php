<!DOCTYPE>
    <html>
        <head>
            <meta charset="UTF-8">
            <title>Список тестов</title>
        </head>
        <body>
            <table>
                    <tr>
                        <td>Номер теста</td>
                        <td>Путь теста</td>
                        <td>Пройти тест</td>
                    </tr>
                    <?php
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
                        <?php if(isset($_SESSION['user'])): ?>
                        <td>Удалить</td>
                        <?php endif; ?>
                    </tr>
                            <?php endif; 
                        endwhile;
                        closedir($dh);
                    endif; ?>
                </table>


            </body>
    </html>