<div>
    <div>
        Всего задач:
    </div>
    <div>
        <?=$model->makerSqlQuery($sqlCountTasks, ["$idUser", "$idUser"])[0]['sum']; ?>
    </div>
</div> 