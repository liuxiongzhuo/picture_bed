<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header('Content-Type: application/json');
$target_dir = './'.$_POST['uploadDir'].'/';
$uploaded_file = $_FILES['fileToUpload'];
$file_extension = pathinfo($uploaded_file['name'], PATHINFO_EXTENSION);
$target_file = $target_dir  . time() . '.' . $file_extension;
if (move_uploaded_file($uploaded_file['tmp_name'], $target_file)) {
    echo json_encode(['status' => 'success', 'message' => '文件上传成功']);
}
else{
    echo json_encode(['status'=>'error','message'=>'文件上传失败']);
}