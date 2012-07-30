<?php
/**
 * X-Prime
 *
 *
 * @category   Xprime
 * @author     lclouet
 * @date       07/06/12
 * @copyright  Copyright (c) 2012 X-PRIME (http://www.x-prime.com)
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

error_reporting(E_ALL | E_STRICT);
ini_set('display_errors', 1);


require_once('../config.php');

$name = (isset($_POST['name']) ? addslashes($_POST['name']) : '');
$twitter = (isset($_POST['twitter']) ? addslashes($_POST['twitter']) : '');
$svgToSave = (isset($_POST['svg']) ? addslashes($_POST['svg']) : '');

if(!$svgToSave){
    throw new Exception('No svg paramater given');
}


$dbh = new PDO($dsn, $dbUsername, $dbPassword);
$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$dbh->exec("SET CHARACTER SET utf8");
$svgToSaveInDb = $svgToSave;

$dbh->exec("INSERT INTO cup (name, twitter, img_big, created_at) VALUES ('$name', '$twitter', '$svgToSaveInDb', NOW());");

echo $dbh->lastInsertId();