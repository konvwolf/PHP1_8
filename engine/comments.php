<?php
header('Location: /product/' . $_POST['prod_name'] . '/');

include ($_SERVER['DOCUMENT_ROOT'].DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'const.php'); // константы сайта
include (ENGINE_PATH.'func.php'); // функции сайта
$name = $_POST['name'];
$product = $_POST['prod_name'];
$comment = $_POST['comm'];
$dataString = '\'' . $product . '\', \'' . $name . '\', \'' . $comment .'\'';
echo $dataString;
if ($name) {
    insertIntoSQLtable (COMMENTS, 'prod_name, user_name, user_comment', $dataString);
}