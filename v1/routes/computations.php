<?php
/**
 * Compute grade point by country
 * method GET
 * url /compute/gradepoint/grade/:grade/country/:country
 */
$app->get('/compute/gradepointbycountry/grade/:grade/country/:country', 'authenticate', function($grade, $country){
	$response = array();
	$db = new DbHandler();

	$gradepoints = $db->gradePointByCountry($grade, $country);
	if ($gradepoints != NULL){
		$response['error'] = false;
		$response['gradepoint'] = $gradepoints;
		echoResponse(200, $response);
	} else {
		$response['error'] = true;
		$response['message'] = 'Could not compute grade point by country.';
		echoResponse(404, $response);
	}
});

/**
 * Compute grade point by country
 * method POST
 * params - country, grade
 * url /compute/gradepointbycountry
*/
$app->post('/compute/gradepointbycountry', 'authenticate', function() use ($app){
	verifyRequiredParams(array('grade', 'country'));

	$response = array();

	$country = $app->request->post('country');
	$grade = $app->request->post('grade');

	$db = new DbHandler();
	$gradepoints = $db->gradePointByCountry($grade, $country);
	if ($gradepoints != NULL){
		$response['error'] = false;
		$response['gradepoint'] = $gradepoints;
		echoResponse(200, $response);
	} else {
		$response['error'] = true;
		$response['message'] = 'Could not compute grade point by country.';
		echoResponse(404, $response);
	}
});


/**
 * Compute grade by country
 * method POST
 * params - country, totalscore
 * url /compute/gradebycountry
*/
$app->post('/compute/gradebycountry', 'authenticate', function() use ($app){
	verifyRequiredParams(array('totalscore', 'country'));

	$response = array();

	$totalscore = $app->request->post('totalscore');
	$country = $app->request->post('country');

	$db = new DbHandler();
	$gradeletter = $db->gradeLetterByCountry($totalscore, $country);
	if ($gradeletter != NULL){
		$response['error'] = false;
		$response['grade_letter'] = $gradeletter;
		echoResponse(200, $response);
	} else {
		$response['error'] = true;
		$response['message'] = 'Could not compute grade for specified country.';
		echoResponse(404, $response);
	}
});

/**
 * Compute grade by country
 * method GET
 * url /compute/gradebycountry/score/:totalscore/country/:country
*/
$app->get('/compute/gradebycountry/score/:totalscore/country/:country', 'authenticate', function($totalscore, $country){
	$response = array();

	$db = new DbHandler();
	$gradeletter = $db->gradeLetterByCountry($totalscore, $country);
	if ($gradeletter != NULL){
		$response['error'] = false;
		$response['grade_letter'] = $gradeletter;
		echoResponse(200, $response);
	} else {
		$response['error'] = true;
		$response['message'] = 'Could not compute grade for specified country.';
		echoResponse(404, $response);
	}
});

/**
 * Compute cumulative GPA
 * method POST
 * params - uid, studentnumber, programme
 * url /compute/cumulativegpa
*/
$app->post('/compute/cumulativegpa', 'authenticate', function() use ($app){
	verifyRequiredParams(array('uid', 'studentnumber', 'programme'));

	$response = array();

	$uid = $app->request->post('uid');
	$studentnumber = $app->request->post('studentnumber');
	$programme = $app->request->post('programme');

	$db = new DbHandler();
	$gpa = $db->computeCumulativeGPA($uid, $studentnumber, $programme);
	if ($gpa != NULL){
		$response['error'] = false;
		$response['cumulative_gpa'] = $gpa;
		echoResponse(200, $response);
	} else {
		$response['error'] = true;
		$response['message'] = 'Could not compute cumulative GPA.';
		echoResponse(404, $response);
	}
});

/**
 * Compute cumulative GPA
 * method GET
 * url /compute/cumulativegpa/user/:uid/:studentnumber/:programme
*/
$app->get('/compute/cumulativegpa/user/:uid/:studentnumber/:programme', 'authenticate', function($uid, $studentnumber, $programme){
	$response = array();

	$db = new DbHandler();
	$gpa = $db->computeCumulativeGPA($uid, $studentnumber, $programme);
	if ($gpa != NULL){
		$response['error'] = false;
		$response['cumulative_gpa'] = $gpa;
		echoResponse(200, $response);
	} else {
		$response['error'] = true;
		$response['message'] = 'Could not compute cumulative gpa.';
		echoResponse(404, $response);
	}
});

/**
 * Compute current GPA
 * method POST
 * params - uid, studentnumber, semester, academicsession
 * url /compute/currentgpa
*/
$app->post('/compute/currentgpa', 'authenticate', function() use ($app){
	verifyRequiredParams(array('uid', 'studentnumber', 'semester', 'academicsession'));

	$response = array();

	$uid = $app->request->post('uid');
	$studentnumber = $app->request->post('studentnumber');
	$semester = $app->request->post('semester');
	$academicsession = $app->request->post('academicsession');

	$db = new DbHandler();
	$gpa = $db->computeCurrentGPA($uid, $studentnumber, $semester, $academicsession);
	if ($gpa != NULL){
		$response['error'] = false;
		$response['current_gpa'] = $gpa;
		echoResponse(200, $response);
	} else {
		$response['error'] = true;
		$response['message'] = 'Could not compute current GPA.';
		echoResponse(404, $response);
	}
});

/**
 * Compute current GPA
 * method GET
 * url /compute/currentgpa/:uid/:studentnumber/:semester/:academicsession
*/
$app->get('/compute/currentgpa/:uid/:studentnumber/:semester/:academicsession', 'authenticate', function($uid, $studentnumber, $semester, $academicsession){
	$response = array();

	$db = new DbHandler();
	$gpa = $db->computeCurrentGPA($uid, $studentnumber, $semester, $academicsession);
	if ($gpa != NULL){
		$response['error'] = false;
		$response['current_gpa'] = $gpa;
		echoResponse(200, $response);
	} else {
		$response['error'] = true;
		$response['message'] = 'Could not compute current gpa.';
		echoResponse(404, $response);
	}
});