<?php
$animalsArray = array("Africa" => ["Potamochoerus porcus", "Cephalophinae", "Hexaprotodon liberiensis"], 
    "Southern America" => ["Microsciurus flaviventer", "Inia geoffrensis", "Cebus albifrons"], 
    "Australia" => ["Thylacinus cynocephalus", "Trichosurus vulpecula", "Zaglossus bruijni"],
    "Eurasia" => ["Rangifer tarandus", "Vulpes", "Vulpes lagopus"], 
    "North America" => ["Bubo scandiacus", "Cricetinae", "Ursus arctos horribilis"]);

// i am wrote function for testing count of words
function isMoreThanTwo ($value) {
    $words = explode(" ", $value);
    if(count($words) == 2) {
        return true;
    } else {
        return false;
    }
}

function pluckAndReturnMassive ($massive) {
    $newArray = [];
    foreach ($massive as $key => $value) {
        for ($i=0; $i < count($value); $i++) { 
            if(isMoreThanTwo($value[$i])) {
                $newArray[] = $value[$i];
            }
        }
    }
    return $newArray;
}

$result = pluckAndReturnMassive($animalsArray);
foreach ($result as $key => $value) {
    echo "$value </br>";
}

?>