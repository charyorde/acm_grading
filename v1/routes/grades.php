<?php
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
