<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
 
// include database and object files
include_once '../config/database.php';
include_once '../objects/band.php';
 
// instantiate database and product object
$database = new Database();
$db = $database->getConnection();
 
// initialize object
$band = new Band($db);
 
// query bands
$stmt = $band->read();
$num = $stmt->rowCount();

// check if more than 0 record found
if($num > 0) {
 
	// bands array
	$band_arr = array();
	$band_arr["records"] = array();

	// retrieve our table contents
	// fetch() is faster than fetchAll()
	// http://stackoverflow.com/questions/2770630/pdofetchall-vs-pdofetch-in-a-loop
	while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
		// extract row
		// this will make $row['name'] to
		// just $name only
		extract($row);

		$band_item = array(
			"id" => $id,
			"name" => $name,                     
		);

		array_push($band_arr["records"], $band_item);
	}
 
	// set response code - 200 OK
	http_response_code(200);

	// show bands data in json format
	echo json_encode($band_arr);
} 
else {
 
	// set response code - 404 Not found
	http_response_code(404);

	// tell the user no bands found
	echo json_encode(
		array("message" => "No bands found.")
	);
}
