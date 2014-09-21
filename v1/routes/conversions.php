<?php
/**
 * Compute grade point by WES
 * method POST
 * params - totalscore, country
 * url /compute/gradepointbywes/
 */
$app->post('/compute/gradepointbywes/', 'authenticate', function() use ($app){
	verifyRequiredParams(array('totalscore', 'country'));

	$response = array();

	$totalscore = $app->request->post('totalscore');
	$country = $app->request->post('country');

	$db = new DbHandler();
	$gradepoint = $db->gradePointByWES($totalscore, $country);
	if ($gradepoint != NULL){
		$response['error'] = false;
		$response['WES_grade_point'] = $gradepoint;
		echoResponse(200, $response);
	} else {
		$response['error'] = true;
		$response['message'] = 'Could not compute grade point by WES.';
		echoResponse(404, $response);
	}
});

/**
 * Compute grade point by WES
 * method GET
 * url /compute/gradepointbywes/score/:totalscore/country/:country
*/
$app->get('/compute/gradepointbywes/score/:totalscore/country/:country', 'authenticate', function($totalscore, $country){
	$response = array();

	$db = new DbHandler();
	$gradepoint = $db->gradePointByWES($totalscore, $country);
	if ($gradepoint != NULL){
		$response['error'] = false;
		$response['WES_grade_point'] = $gradepoint;
		echoResponse(200, $response);
	} else {
		$response['error'] = true;
		$response['message'] = 'Could not compute grade point by WES.';
		echoResponse(404, $response);
	}
});

/**
 * Compute grade by WES
 * method POST
 * params - totalscore, country
 * url /compute/gradebywes
*/
$app->post('/compute/gradebywes', 'authenticate', function() use ($app){
	verifyRequiredParams(array('totalscore', 'country'));

	$response = array();

	$totalscore = $app->request->post('totalscore');
	$country = $app->request->post('country');

	$db = new DbHandler();
	$grade = $db->gradeLetterByWES($totalscore, $country);
	if ($grade != NULL){
		$response['error'] = false;
		$response['WES_grade'] = $grade;
		echoResponse(200, $response);
	} else {
		$response['error'] = true;
		$response['message'] = 'Could not compute WES grade.';
		echoResponse(404, $response);
	}
});

/**
 * Compute grade by WES
 * method GET
 * url /compute/gradebywes/score/:totalscore/country/:country
*/
$app->get('/compute/gradebywes/score/:totalscore/country/:country', 'authenticate', function($totalscore, $country){
	$response = array();

	$db = new DbHandler();
	$grade = $db->gradeLetterByWES($totalscore, $country);
	if ($grade != NULL){
		$response['error'] = false;
		$response['WES_grade'] = $grade;
		echoResponse(200, $response);
	} else {
		$response['error'] = true;
		$response['message'] = 'Could not compute WES grade.';
		echoResponse(404, $response);
	}
});
