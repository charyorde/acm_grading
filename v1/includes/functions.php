<?php
/**
 * Verifying required params posted or not
 */
function verifyRequiredParams($required_fields){
	$error = false;
	$error_fields = "";
	$request_params = array();
	$request_params = $_REQUEST;

	//Handling PUT request params
	if ($_SERVER['REQUEST_METHOD'] == 'PUT'){
		$app = \Slim\Slim::getInstance();
		parse_str($app->request()->getBody(), $request_params);
	}
	foreach ($required_fields as $field){
		if (!isset($request_params[$field]) || strlen(trim($request_params[$field])) <= 0){
			$error = true;
			$error_fields .= $field . ', ';
		}
	}

	if ($error){
		//Return an appropriate response when a required field is missing
		$response = array();
		$app = \Slim\Slim::getInstance();
		$response['error'] = true;
		$response['message'] = 'Required field(s) ' . substr($error_fields, 0, -2) . ' is missing or empty';
		echoResponse(400, $response);
		$app->stop();
	}
}

/**
 * Echoing json repsonse to client
 * @param String $status_code Http response code
 * @param int $response JSON response
 */
function echoResponse($status_code, $response){
	$app = \Slim\Slim::getInstance();
	
	//HTTP response code
	$app->status($status_code);
	
	$app->contentType('application/json');
	
	echo json_encode($response);
}

/**
 * Adding middle layer to authenticate every request
 * Checking if the request has valid api key in the 'Authorization' header
 */
function authenticate(\Slim\Route $route){
	$headers = apache_request_headers();
	$response = array();
	$app = \Slim\Slim::getInstance();
	
	//Ensure there is c authorization header and check for a correct api key
	if (isset($headers['Authorization'])){
		$db = new DbHandler();
		$api_key = $headers['Authorization'];
		
		if (!$db->isValidApiKey($api_key)){
			$respones['error'] = true;
			$response['message'] = 'Access denied. Invalid API key.';
			echoResponse(401, $response);
			$app->stop();
		} else {
			global $user_id;
			$user = $db->getUserId($api_key);
			if ($user != NULL)
				$user_id = $user['id'];
		}
	} else {
		$response['error'] = true;
		$response['message'] = "API key is missing.";
		echoResponse(400, $response);
		$app->stop();
	}
}