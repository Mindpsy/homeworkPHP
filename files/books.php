<?php
$urlFile = "./books.csv";

function getApiBook ($queryUser) 
    {   
        if($queryUser) {
            $encodeQuery = urlencode($queryUser);
            $apiData = file_get_contents("https://www.googleapis.com/books/v1/volumes?q={$encodeQuery}");
            return json_decode($apiData);
        }   
    }

function chekJsonData ()
    {
        $last_error = json_last_error();
        switch ($last_error) {
            case 'JSON_ERROR_NONE':
                echo "\nОшибок нет";
                break;
            case 'JSON_ERROR_DEPTH':
                echo "\nДостигнута максимальная глубина стека";
                break;
            case 'JSON_ERROR_STATE_MISMATCH':
                echo "\nНеверный или некорректный JSON";
                break;
            case 'JSON_ERROR_CTRL_CHAR':
                echo "\nОшибка управляющего символа, возможно неверная кодировка";
                break;
            case 'JSON_ERROR_SYNTAX':
                echo "\nСинтаксическая ошибка";
                break;
            case 'JSON_ERROR_UTF8':
                echo "\nНекорректные символы UTF-8, возможно неверная кодировка";
                break;
            case 'JSON_ERROR_RECURSION':
                echo "\nОдна или несколько зацикленных ссылок в кодируемом значении";
                break;
            case 'JSON_ERROR_INF_OR_NAN':
                echo "\nОдно или несколько значений NAN или INF в кодируемом значении";
                break;
            case 'JSON_ERROR_UNSUPPORTED_TYPE':
                echo "\nПередано значение с неподдерживаемым типом";
                break;
            case 'JSON_ERROR_INVALID_PROPERTY_NAME':
                echo "\nИмя свойства не может быть закодировано";
                break;
            case 'JSON_ERROR_UTF16':
                echo "\nНекорректный символ UTF-16, возможно некорректно закодирован";
                break;
                
            default:
                echo "\njson_last_error не знает что за ошибка";
                break;
        }
        $tmpMsg = json_last_error_msg();
        echo "\n $tmpMsg";
    }

function writeInCsv ($destinationWrite, $massiveData) 
    {
        $handleWrite = fopen($destinationWrite, "wb");
        if($massiveData) {
            if($handleWrite) {
                foreach($massiveData as $name=>$value){
                    if (isset($value->volumeInfo->authors)) {
                        $row = [$value->id, $value->volumeInfo->title, implode( ", ", $value->volumeInfo->authors)];
                        fputcsv($handleWrite, $row);
                    } else {
                        $row = [$value->id, $value->volumeInfo->title, $value->volumeInfo->publisher];
                        fputcsv($handleWrite, $row);
                    }
                    
                }
            }
        }
        fclose($handleWrite);
    }

if (isset($argv[1])) {
    $searchString = implode(array_slice($argv, 1));
    $apiObj = getApiBook($searchString);
    
    if ($apiObj) {
        $bookitems = $apiObj->items;
        writeInCsv($urlFile, $bookitems);
        echo "\n Готово";
        $tmpChek = chekJsonData();
        echo "\n$tmpChek";
    }
} else {
    echo "\n Введите запрос!";
}

?>