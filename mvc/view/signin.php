<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css">
    <title>Document</title>
</head>
<body>
    <h1><a href="/">Войдите</a> или <a href="/?controller=form&action=reg&registration=true">зарегистрируйтесь</a> в приложении ToDo</h1>
    <h2><?=$titleH2; ?><h2>
        <div class="">
            <form role="form">
                <div class="form-group">
                    <input name="controller" type="hidden" value="base" />
                    <input name="action" type="hidden" value="<?=$FormAction;?>"/>
                    <label for="exampleInputLogin">Логин</label>
                    <input type="text" name="<?=$LoginName;?>" class="form-control" id="exampleInputLogin" placeholder="<?=$LoginOlaceholder;?>">
                </div>
                <div class="form-group">
                    <label for="exampleInputPassword1">Пароль</label>
                    <input type="password" name="<?=$PassName;?>" class="form-control" id="exampleInputPassword1" placeholder="<?=$Passwordplaceholder;?>">
                </div>
                <button type="submit" name="<?=$NameButtonSubmit;?>" class="btn btn-default"><?=$TextButtonSubmit;?></button>
            </form>
        </div>
    </body>
</html>