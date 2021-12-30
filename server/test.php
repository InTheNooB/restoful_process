<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");
switch ($_SERVER['REQUEST_METHOD']) {
    case 'POST':
        $myfile = fopen("newfile.txt", "w") or die("Unable to open file!");
        $txt = $_POST['a'];
        fwrite($myfile, $txt);
        fclose($myfile);
        break;
}
