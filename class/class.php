<?php 
class Poduct 
{
    public $name;
    protected $cost;
    public $category;
    public function __comstruct ($name, $cost) {
        $this->name = $name;
        $this->$cost = $cost;
    }
}

class Car extends Poduct
{
    public $maxSpeed;
    public function getDiscount () {
    }

}

class Tv extends Poduct
{
    public $display;
    public function getDiscount () {
    }
}

class Pen  extends Poduct
{
    public $color;
    public function getDiscount () {
    }
}

class Duck extends Poduct
{
    public $voice;
    public function getDiscount () {
    }
}

$carObj = new Car('BMW','5000000');
$carObj2 = new Car('LADA','90000');
$tvObj = new Tv("Sumsung","100000");
$tvObj2 = new Tv("LG","50000");
$penObj = new Pen("Ristics","50");
$penObj2 = new Pen("Koh-i-nor","200");
$duckObj =new Duck("Run","88888888");
$duckObj2 =new Duck("Danger","9999999");
?>