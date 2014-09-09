<?php
/**
 * User registration
 * url - /register
 * method - POST
 * params - username, password
 */
$app->post('/register', function() use ($app){
	verifyRequiredParams(array('name', 'email', 'password'));

	$response = array();

	$username = $app->request->post('username');
	$password = $app->request->post('password');

	$db = new DbHandler();
	$result = $db->createUser($username, $password);

	if ($result == USER_CREATED_SUCCESSFULLY){
		$response['error'] = false;
		$response['message'] = 'You are successfully registered.';
		echoResponse(201, $response);
	} else if ($result == USER_CREATE_FAILED){
		$response['error'] = true;
		$response['message'] = "Oops! An error occurred while registering.";
		echoResponse(200, $response);
	} else if ($res = USER_ALREADY_EXISTED){
		$response['error'] = true;
		$response['message'] = 'Sorry, this user already exists.';
		echoResponse(200, $response);
	}
});

/**
 * User login
 * url - /login
 * method - POST
 * params - username, password
 */
$app->post('/login', function() use ($app){
	verifyRequiredParams(array('username', 'password'));

	$username = $app->request()->post('username');
	$password = $app->request()->post('password');
	$response = array();

	$db = new DbHandler();
	if ($db->checkLogin($username, $password)){
		$user = $db->getUserByUsername($username);

		if ($user != NULL){
			$response['error'] = false;
			$response['name'] = $user->username;
			$response['api_key'] = $user->api_key;
		} else {
			$response['error'] = true;
			$response['message'] = 'An error occurred. Please try again.';
		}
	} else {
		$response['error'] = true;
		$response['message'] = 'Login failed. Incorrect credentials';
	}

	echoResponse(200, $response);
});
