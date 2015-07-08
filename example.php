<?php

require_once("Browser.php");
require_once("Array2MySQL.php");
use AutoRu\Browser\Browser;
use AutoRu\SQL\Array2MySQL;
$b = new Browser("http://my.auto.ru/cars/honda/accord/");
$b->getPages();
$data = $b->parsePages();
//print_r($data);
$saver = new Array2MySQL();
$saver->setArray($data);
$saver->save2DB();
