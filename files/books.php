<?php 
function getApiBook ($queryUser) 
    {   
        if($queryUser) {
            $encodeQuery = urlencode($queryUser);
            $apiData = file_get_contents("https://www.googleapis.com/books/v1/volumes?q=$encodeQuery");
            return json_decode($apiData);
        }   
    }

function chekJsonData ()
    {
        $last_error = json_last_error();
        switch ($last_error) {
            case 'JSON_ERROR_NONE':
                var_dump("Ошибок нет");
                break;
            case 'JSON_ERROR_DEPTH':
                var_dump("Достигнута максимальная глубина стека");
                break;
            case 'JSON_ERROR_STATE_MISMATCH':
                var_dump("Неверный или некорректный JSON");
                break;
            case 'JSON_ERROR_CTRL_CHAR':
                var_dump("Ошибка управляющего символа, возможно неверная кодировка");
                break;
            case 'JSON_ERROR_SYNTAX':
                var_dump("Синтаксическая ошибка");
                break;
            case 'JSON_ERROR_UTF8':
                var_dump("Некорректные символы UTF-8, возможно неверная кодировка");
                break;
            case 'JSON_ERROR_RECURSION':
                var_dump("Одна или несколько зацикленных ссылок в кодируемом значении");
                break;
            case 'JSON_ERROR_INF_OR_NAN':
                var_dump("Одно или несколько значений NAN или INF в кодируемом значении");
                break;
            case 'JSON_ERROR_UNSUPPORTED_TYPE':
                var_dump("Передано значение с неподдерживаемым типом");
                break;
            case 'JSON_ERROR_INVALID_PROPERTY_NAME':
                var_dump("Имя свойства не может быть закодировано");
                break;
            case 'JSON_ERROR_UTF16':
                var_dump("Некорректный символ UTF-16, возможно некорректно закодирован");
                break;
                
            default:
                var_dump("json_last_error не знает что за ошибка");
                break;
        }
        var_dump(json_last_error_msg());
    }

function writeInCsv ($destinationWrite, $massiveData) 
    {
        $handleWrite = fopen($destinationWrite, "wb");
        if($massiveData) {
            if($handleWrite) {
                foreach($massiveData as $name=>$value){
                    $row = [$value->id, $value->volumeInfo->title, implode($value->volumeInfo->    authors)];
                    fputcsv($handleWrite, $row);
                }
            }
        }
        fclose($handleWrite);
    }

$searchString = implode(array_slice($argv, 1));
$apiObj = getApiBook($searchString);

$urlFile = "./books.csv";

if ($apiObj) {
    $bookitems = $apiObj->items;
    writeInCsv($urlFile, $bookitems);
    var_dump("Готово");
    var_dump(chekJsonData());
} else {
    var_dump("Введите запрос!");
}

?>