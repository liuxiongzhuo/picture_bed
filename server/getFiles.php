<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header('Content-Type: application/json');
$upload_dir = './'.json_decode(file_get_contents("php://input"),true)['queryDir'].'/';
// echo $_POST;
// $upload_dir = './'.'upload'.'/';
$files=array();
$dir = new DirectoryIterator($upload_dir);
foreach ($dir as $key => $value) {
    $files[]=$value->getFilename();
}
echo json_encode(['status'=>'success','files'=>$files]);