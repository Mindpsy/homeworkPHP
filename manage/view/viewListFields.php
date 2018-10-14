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
    <table class="table table-condensed table-hover">
    <tr>
        <?php foreach($resTypeFields as $type): ?>
            <td>
                <form action="../controller/controller.php" method="GET">
                    <select name="newTypeField">
                        <?php $massFields = [];
                        foreach ($resTypeFields as $fff): 
                            $tmpType = $fff['Type']; ?>
                            <?php if (!isset($massFields["$tmpType"])): ?>
                                <option <?php if ($tmpType == $type["Type"]):?>
                                    selected<?php endif; ?> value="<?=$tmpType; ?>">
                                        <?=$tmpType ?>
                                </option>
                                <?php $massFields["$tmpType"] = $tmpType;
                            endif; ?>
                        <?php endforeach; ?>
                    </select>
                    <input name="controller" type="hidden" value="base"/>
                    <input name="action" type="hidden" value="changeType"/>
                    <input name="theTableOpen" type="hidden" value="<?=$_GET['theTableOpen'];?>"/>
                    <input name="oldField" type="hidden" value="<?=$type['Field'];?>"/>
                    </br>
                    <button type="submit" class="btn">Изменить тип поля</button>   
                </form></br>
                <a href="../controller/controller.php?controller=base&action=delField&nameDelTable=<?=$_GET['theTableOpen'];?>&nameDeletedField=<?=$type['Field'];?>">Удалить поле</a>
            </td>
        <?php endforeach; ?>
    </tr>
    <tr>
    <?php foreach ($resTypeFields as $value): ?>
        <td>
            <form action="../controller/controller.php" method="GET">
                <input name="controller" type="hidden" value="base"/>
                <input name="action" type="hidden" value="changeName"/>
                <input name="controller" type="hidden" value="base"/>
                <input name="oldField" type="hidden" value="<?=$value['Field'];?>"/>
                <input name="TypeField" type="hidden" value="<?=$value['Type'];?>"/>
                <input name="theTableOpen" type="hidden" value="<?=$_GET['theTableOpen'];?>"/>
                <input type="text" name="newNameField"/></br>
                <button type="submit" class="btn btn-warning">Изменить имя поля</button>
            </form> </br>
            <?=$value["Field"]; ?>
        </td>
    <?php endforeach;?>
    </tr>
    <?php foreach($resFields as $field): ?>
    <tr>
        <?php foreach($field as $f): ?>
        <td><?=$f;?></td>
        <?php endforeach; ?>
    </tr>
    <?php endforeach; ?>
    </table>
    
</body>
</html>
