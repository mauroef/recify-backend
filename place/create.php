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
 
if (!empty($data->name)) {
 
	$place->name = $data->name;

	// create the place
	$lastId = $place->create();

	if($lastId > 0) {

		http_response_code(201);

		echo json_encode(array(
			"id" => $lastId,
			"name" => $place->name,
			"message" => "Place was created.")
		);
	}

	else {

		http_response_code(503);

		echo json_encode(array("message" => "Unable to create place."));
	}
}

else {

		http_response_code(400);
		
    echo json_encode(array("message" => "Unable to create place. Data is incomplete."));
}
?>
