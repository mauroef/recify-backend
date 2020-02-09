<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
 
include_once '../config/database.php';
include_once '../objects/place.php';
 
$database = new Database();
$db = $database->getConnection();
 
$place = new Place($db);
 
$data = json_decode(file_get_contents("php://input"));
 
$place->id = $data->id;
 
$place->name = $data->name;

if($place->update()){
 
    http_response_code(200);
 
    echo json_encode(array(
        "id" => $place->id,
        "name" => $place->name,
        "message" => "Place was updated."
    ));
}
 
else{
 
    http_response_code(503);
     
    echo json_encode(array("message" => "Unable to update place."));
}
?>
