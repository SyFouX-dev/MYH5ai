<?php

include_once ("My_H5AI.php");



//$link = $_SERVER("PATH_INFO");
$url = str_replace("/index.php" , './' , $_SERVER["REQUEST_URL"]);
$open = new H5AI("./" . $link);
$open->getFiles(scandir($open->getPath()), $open->getPath());
$open->printTree($open->getTree());


?>

    
    

