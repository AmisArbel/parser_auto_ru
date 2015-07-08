<?php

require_once("Browser.php");
require_once("DataParser.php");
require_once("Array2MySQL.php");

use AutoRu\Browser\Browser;
use AutoRu\SQL\Array2MySQL;
use AutoRu\Parse\DataParser;
$b = new Browser("http://my.auto.ru/cars/honda/accord/");
$pages = $b->getPages();
$dataParser = new DataParser();
$data = $dataParser->parsePages($pages);
//print_r($data);
$saver = new Array2MySQL();
$saver->setArray($data);
$saver->save2DB();
