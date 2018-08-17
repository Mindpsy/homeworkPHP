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

// function for creating а new massive
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

// show our the words

$result2Words = pluckAndReturnMassive($animalsArray);
foreach ($result2Words as $key => $value) {
    echo "$value </br>";
}

echo "<hr> </br> <p>-=Sorting=-</p>";

$massiveFirstWords = [];
$massiveSecondWords = [];

// pluck the new words for sorting  
for ($i=0; $i < count($result2Words); $i++) { 
    $twoWords =$result2Words[$i];
    $twoWordsInMassive = explode(" ", $twoWords);
    $massiveFirstWords[] = $twoWordsInMassive[0];
    $massiveSecondWords[] = $twoWordsInMassive[1];
}

// show second words on screen 
for ($i=0; $i < count($massiveSecondWords); $i++) {
    echo "$massiveSecondWords[$i] </br>";
}

$newAnimalsMassive = [];

// mixing the second words 
shuffle($massiveSecondWords);
echo "<p>-=Shuffle massive=-</p> <hr> </br>";

// show second words on screen 
for ($i=0; $i < count($massiveSecondWords); $i++) {
    echo "$massiveSecondWords[$i] </br>";
}

// function check origin names animals
function checkOriginalNames ($newName, $comparingMassive) {
    for ($i=0; $i < count($comparingMassive); $i++) { 
        if ($comparingMassive[$i] == $newName) {
            return false;
        }
        return true;

    }
}

// glue first words and shuffled second words
function glueAndCreateNewNames ($firstWords, $secondWords, $compareEtalon) {
    $tempMassiveNewAnimals = [];
    echo "</br><hr>start glueAndCreateNewNames() </br>";
    for ($i=0; $i < count($firstWords); $i++) {
        $newTwoWords = "$firstWords[$i] $secondWords[$i]";
        if (checkOriginalNames($newTwoWords, $compareEtalon)) {
            echo "if </br>";
            $tempMassiveNewAnimals[] = $newTwoWords;
            echo "$newTwoWords </br>";
        } else {
            echo "else </br>";
            shuffle($massiveSecondWords);
            $i--;
        }
    }
    echo "and glueAndCreateNewNames()";
    return $tempMassiveNewAnimals;
}

$newAnimalsMassive = glueAndCreateNewNames ($massiveFirstWords, $massiveSecondWords, array_merge($result2Words, $newAnimalsMassive));

echo "<hr></br>-=New Animals=- </br>";
// show new animals on screen 
for ($i=0; $i < count($newAnimalsMassive); $i++) {
    echo "$newAnimalsMassive[$i]</br>";
}

$lengthTest = count($newAnimalsMassive);
echo "</br> $lengthTest";


?>