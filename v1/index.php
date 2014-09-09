<?php

require_once 'includes/DbHandler.php';
require_once 'includes/PassHash.php';
require_once 'includes/functions.php';
require '../vendor/autoload.php';


$app = new \Slim\Slim();

// User id from db - Global variable
$user_id = NULL;

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

/**
 * Adding a new grade
 * method POST
 * params - programme, course, uid, islocked, semester, academicsession, overall, exam_score, ca_score, submittedby
 * url /grades
 */
$app->post('/grades', 'authenticate', function() use ($app){
	//Ensure all required parameters are available
	verifyRequiredParams(array('programme', 'course', 'uid', 'islocked', 'semester', 'academicsession', 'exam_score', 'ca_score', 'submittedby'));
	
	$response = array();
	$programme = $app->request->post('programme');
	$course = $app->request->post('course');
	$uid = $app->request->post('uid');
	$islocked = $app->request->post('islocked');
	$semester = $app->request->post('semester');
	$academicsession = $app->request->post('academicsession');
	$exam_score = $app->request->post('exam_score');
	$ca_score = $app->request->post('ca_score');
	$submittedby = $app->request->post('submittedby');
	if (!isset($app->request->post('overall'))){
		$overall = NULL;
	}
	
	global $user_id;
	$db = new DbHandler();
	$score = $db->addScore($programme, $course, $uid, $islocked, $semester, $academicsession, $overall, $exam_score, $ca_score, $submittedby);
	
	if ($score != NULL){
		$response['error'] = false;
		$response['message'] = 'Grade created successfully.';
		$response['score_id'] = $score->id;
	} else {
		$response['error'] = true;
		$response['message'] = 'Failed to create grade. Please try again.';
	}
	echoResponse(201, $response);
});

/**
 * Update already existing grade
 * method POST
 * params - programme, course, uid, islocked, semester, overall, exam_score, ca_score, submittedby
 * url - /grades/:id
 */
$app->post('/grades/:id', 'authenticate', function($score_id) use ($app){
	//Ensure all required parameters are available
	verifyRequiredParams(array('programme', 'course', 'uid', 'islocked', 'semester', 'academicsession', 'exam_score', 'ca_score', 'submittedby'));
	
	$response = array();
	$programme = $app->request->post('programme');
	$course = $app->request->post('course');
	$uid = $app->request->post('uid');
	$islocked = $app->request->post('islocked');
	$semester = $app->request->post('semester');
	$academicsession = $app->request->post('academicsession');
	$exam_score = $app->request->post('exam_score');
	$ca_score = $app->request->post('ca_score');
	$submittedby = $app->request->post('submittedby');
	if (!isset($app->request->post('overall'))){
		$overall = NULL;
	}
	
	global $user_id;
	$db = new DbHandler();
	$result = $db->updateScore($score_id, $programme, $course, $uid, $islocked, $semester, $academicsession, $overall, $exam_score, $ca_score, $submittedby);
	
	if ($result){
		$response['error'] = false;
		$response['message'] = 'Grade updated successfully.';
	} else {
		$response['error'] = true;
		$response['message'] = 'Grade failed to update. Please try again!';
	}
	
	echoResponse(200, $response);
});

/**
 * Update already existing grade
 * method PUT
 * params - programme, course, uid, islocked, semester, overall, exam_score, ca_score, submittedby
 * url - /grades/:id
 */
$app->put('/grades/:id', 'authenticate', function($score_id) use ($app){
	//Ensure all required parameters are available
	verifyRequiredParams(array('programme', 'course', 'uid', 'islocked', 'semester', 'academicsession', 'exam_score', 'ca_score', 'submittedby'));

	$response = array();
	$programme = $app->request->put('programme');
	$course = $app->request->put('course');
	$uid = $app->request->put('uid');
	$islocked = $app->request->put('islocked');
	$semester = $app->request->put('semester');
	$academicsession = $app->request->put('academicsession');
	$exam_score = $app->request->put('exam_score');
	$ca_score = $app->request->put('ca_score');
	$submittedby = $app->request->put('submittedby');
	if (!isset($app->request->put('overall'))){
		$overall = NULL;
	}

	$db = new DbHandler();
	$result = $db->updateScore($score_id, $programme, $course, $uid, $islocked, $semester, $academicsession, $overall, $exam_score, $ca_score, $submittedby);

	if ($result){
		$response['error'] = false;
		$response['message'] = 'Grade updated successfully.';
	} else {
		$response['error'] = true;
		$response['message'] = 'Grade failed to update. Please try again!';
	}

	echoResponse(200, $response);
});

/**
 * Compute grade point by country
 * method GET
 * url /gradepoint/:country/:grade
 */
$app->get('/gradepoint/:country/:grade', 'authenticate', function($country, $grade){
	$response = array();
	$db = new DbHandler();
	
	$gradepoints = $db->gradePointByCountry($country, $grade);
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
 * url /gradepoint/:country/:grade
 */
$app->post('/gradepoint', 'authenticate', function() use ($app){
	verifyRequiredParams(array('country', 'grade'));
	
	$response = array();
	
	$country = $app->request->post('country');
	$grade = $app->request->post('grade');
	
	$db = new DbHandler();
	$gradepoints = $db->gradePointByCountry($country, $grade);
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
 * url /gradebycountry
 */
$app->post('/gradebycountry', 'authenticate', function() use ($app){
	verifyRequiredParams(array('country', 'totalscore'));

	$response = array();

	$country = $app->request->post('country');
	$totalscore = $app->request->post('totalscore');

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
 * url /gradebycountry/:totalscore/:country
 */
$app->get('/gradebycountry/:totalscore/:country', 'authenticate', function($totalscore, $country){
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
 * Compute grade point by WES
 * method POST
 * params - totalscore
 * url /gradebywes
 */
$app->post('/gradepointbywes', 'authenticate', function() use ($app){
	verifyRequiredParams(array('totalscore'));

	$response = array();

	$totalscore = $app->request->post('totalscore');

	$db = new DbHandler();
	$gradepoint = $db->gradePointByWES($totalscore);
	if ($gradepoint != NULL){
		$response['error'] = false;
		$response['WES_grade_point'] = $gradeletter;
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
 * url /gradepointbywes/:totalscore
*/
$app->get('/gradepointbywes/:totalscore', 'authenticate', function($totalscore){
	$response = array();

	$db = new DbHandler();
	$gradepoint = $db->gradePointByWES($totalscore);
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
 * params - totalscore
 * url /gradebywes
 */
$app->post('/gradebywes', 'authenticate', function() use ($app){
	verifyRequiredParams(array('totalscore'));

	$response = array();

	$totalscore = $app->request->post('totalscore');

	$db = new DbHandler();
	$grade = $db->gradeByWES($totalscore);
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
 * url /gradebywes/:totalscore
*/
$app->get('/gradebywes/:totalscore', 'authenticate', function($totalscore){
	$response = array();

	$db = new DbHandler();
	$grade = $db->gradeByWES($totalscore);
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
 * Compute cumulative GPA
 * method POST
 * params - uid, studentnumber, programme
 * url /
 */
$app->post('/cumulativegpa', 'authenticate', function() use ($app){
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
 * url /cumulativegpa/:uid/:studentnumber/:programme
*/
$app->get('/cumulativegpa/:uid/:studentnumber/:programme', 'authenticate', function($uid, $studentnumber, $programme){
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
 * url /
 */
$app->post('/currentgpa', 'authenticate', function() use ($app){
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
 * url /currentgpa/:uid/:studentnumber/:semester/:academicsession
*/
$app->get('/cumulativegpa/:uid/:studentnumber/:semester/:academicsession', 'authenticate', function($uid, $studentnumber, $semester, $academicsession){
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