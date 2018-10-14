<?php 

class Model {
    public $pdo;
    public $coreConfig;
    public $sqlCreateTable = "CREATE TABLE IF NOT EXISTS `students` (
        `id` int NOT NULL AUTO_INCREMENT,
        `name` varchar(50) NULL,
        `estimation`float NOT NULL,
        `budget` tinyint(4) NOT NULL DEFAULT '0',
        PRIMARY KEY (`id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8;";
    public $sqlShowBases = "SHOW DATABASES;";
    public $sqlShowTables = "SHOW TABLES";
    public $sqlGetFieldTable = "SELECT * FROM ?";
    public $sqlDescribeFields = "DESCRIBE ?";
    public $sqlShowField = "SHOW FIELDS FROM ?";
    public $sqlChangeType = "ALTER TABLE ? MODIFY ? ?";
    public $sqlDelField = "ALTER TABLE ? DROP COLUMN ?";
    public $sqlChangeNameField = "ALTER TABLE ? CHANGE ? ? ?";

    public function connectDataBase ($tmpConfig) {
        $this->coreConfig = $tmpConfig;
        $tmpPdo = new PDO("mysql:host={$tmpConfig->host};dbname={$tmpConfig->dbname};charset=utf8", $tmpConfig->login, $tmpConfig->password);
        $this->pdo = $tmpPdo;
        return $tmpPdo;
    }

    public function makerSql ($pdo, $sql, $prePar = [""]) {
        dumper("sql query ");
        dumper($sql);
        $sth = $pdo->prepare($sql);
        $resex = $sth->execute($prePar);
        dumper("resexecute ");
        dumper($resex);
        $res = $sth->fetchAll(PDO::FETCH_ASSOC);
        return $res;
    }

    public function createTable () {
        $res = $this->makerSql($this->pdo, $this->sqlCreateTable);
        return $res;
    }

    public function showBases () {
        $res = $this->makerSql($this->pdo, $this->sqlShowBases);
        return $res;
    }

    public function showTables () {
        $res = $this->makerSql($this->pdo, $this->sqlShowTables);
        return $res;
    }

// увы этот метод не работает. отсюда https://habr.com/post/148446/ узнал почему, 
// по этому написал ниже второй вариант 
    public function getFieldsTable ($table) {
        $res = $this->makerSql($this->pdo, $this->sqlGetFieldTable, ["$table"]);
        return $res;
    }

    public function getFieldsTable2 ($table) {
        $tmpSql = "select * from {$table}";
        $res = $this->makerSql($this->pdo, $tmpSql);
        return $res;
    }

    public function describeFeilds ($table) {
        $tmpSql = "describe {$table}";
        $res = $this->makerSql($this->pdo, $tmpSql);
        return $res;
    }

    public function  changeType ($table, $field, $newType) {
        $tmpSql = "alter table {$table} modify {$field} {$newType}";
        $res = $this->makerSql($this->pdo, $tmpSql);
        return $res;
    }

    public function generateTypeField ($newType, $mount) {
        if(stristr($oldType, "int")) {
            $genType = "type ({$mount})";
        }
        return $genType;
    }

    public function deleteField ($table, $column) {
        $tmpSql = "ALTER TABLE {$table} DROP COLUMN {$column}";
        $res = $this->makerSql($this->pdo, $tmpSql);
        return $res;

    }

    public function changeNameField ($table, $oldNameF, $newNameF, $typeF) {
        $tmpSql = "ALTER TABLE {$table} CHANGE {$oldNameF} {$newNameF} {$typeF}";
        $res = $this->makerSql($this->pdo, $tmpSql);
        return $res;
    }
}
?>