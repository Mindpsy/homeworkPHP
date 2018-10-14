<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css">
</head>
<body>
    <table class="table table-condensed">
    <?php $count = 0; ?>
    <tr>
        <td>Название</td>
        <td></td>
    </tr>
    <?php foreach($resTables as $key => $tables): ?>
        <tr>
            <td><?=$tables['Tables_in_todoaplpication'];?></td>
            <td>
                <form action="/controller/controller.php" method="get">
                    <input name="controller" value="base" type="hidden"/>
                    <input name="action" value="getFields" type="hidden"/>
                    <input name="theTableOpen" value="<?=$tables['Tables_in_todoaplpication'];?>" type="hidden"/>
                    <button type="submit" class="btn">Открыть</button>
                </form>
            </td>
        </tr>
    <?php endforeach; ?>
    </table>
    
</body>
</html>
