<?php
/**
 * Class to handle all db operations
 * This class will have CRUD methods for database tables
 * 
 * @author David Adamo Jr.
 */
class DbHandler {
	/**
	 * Creating new user
	 * @param String $username
	 * @param String $password
	 */
	public function createUser($username, $password){
		require_once 'PassHash.php';
		$response = array();
		
		//Prevent duplicate user registrations
		if (!$this->isUserExists($username)){
			$password_hash = PassHash::hash($password);
			
			//Generate an api key for secure access to the api methods
			$api_key = $this->generateApiKey();
			
			$user = new User;
			$user->username = $username;
			$user->password = $password_hash;
			$user->api_key = $api_key;
			
			if ($user->save()){
				return USER_CREATED_SUCCESSFULLY;
			} else {
				return USER_CREATE_FAILED;
			}
		}
	}
	
	/**
	 * Generating a random unique md5 string for user api key
	 */
	private function generateApiKey(){
		return md5(uniqid(rand(), true));
	}
	
	/**
	 * Checking user login
	 * @param String $username user's username
	 * @param String $password user's password
	 * @return boolean User login status success/fail
	 */
	public function checkLogin($username, $password){
		$user_count = User::where('username', '=', $username)->count();
		if ($user_count > 0){
			if (PassHash::check_password($users[0]->password, $password)){
				return TRUE;				
			} else {
				return FALSE;
			}
		} else {
			return FALSE;
		}
	}
	
	/**
	 * Checking for duplicate user by username
	 * @param String $username username to check in db
	 * @return boolean
	 */
	private function isUserExists($username){
		$user_count = User::where('username', $username)->count();
		return $user_count;
	}
	
	/**
	 * Get user by username
	 * @param String $username
	 */
	private function getUserByUsername($username){
		$user = User::where('username', $username)->first();
		return $user;
	}
	
	/**
	 * Fetching user api key
	 * @param String $user_id user id primary key in user table
	 */
	public function getApiKeyById($user_id){
		$user = User::where('id', '=', $user_id)->first();
		if ($user != NULL){
			return $user->api_key;
		} else {
			return NULL;
		}
	}
	
	/**
	 * Fetching user id by api key
	 * @param String $api_key user api key
	 */
	public function getUserId($api_key){
		$user = User::where('api_key', '=', $api_key)->first();
		if ($user != NULL){
			return $user->id;
		} else {
			return NULL;
		}
	}
	
	/**
	 * Fetching a user by ID
	 * @param int $user_id
	 */
	public function getUserById($user_id){
		$user = User::where('id', '=', $user_id)->first();
		return $user;
	}
	
	/**
	 * Validating user api key
	 * If the api key is in the db, it is a valid key
	 * @param String $api_key user api key
	 * @return boolean
	 */
	public function isValidApiKey($api_key){
		$user = User::where('api_key', '=', $api_key);
		if ($user != NULL){
			return TRUE;
		} else {
			return FALSE;
		}
	}
	
	/**
	 * Add a new score
	 * @param int $programme the programme to which this score applies
	 * @param int $course the course to which this score applies
	 * @param int $uid the student user id
	 * @param bool $is_locked whether the score is locked or not
	 * @param String $semester The current academic semester
	 * @param String $acad_session The current academic session
	 * @param int $overall the total score possible
	 * @param Double $exam_score the student's exam score
	 * @param Double $ca_score the student's CA score
	 * @param int $submittedby the id of the lecturer or teacher who submitted the score
	 * 
	 */
	public function addScore($programme, $course, $uid, $is_locked, $semester, $acad_session, $overall, $exam_score, $ca_score, $submittedby){
		$score = new Score;
		$score->programme = $programme;
		$score->course = $course;
		$score->uid = $uid;
		$score->islocked = $is_locked;
		$score->semester = $semester;
		$score->academicsession = $acad_session;
		if (trim($exam_score) == ''){
			$score->exam_score == NULL;
		} else {
			$score->exam_score = $exam_score;
		}
		$score->score = $exam_score;
		if (trim($ca_score) == ''){
			$score->cascore = NULL;
		} else {
			$score->cascore = $ca_score;
		}
		$score->save();
		
		$total_score = $score->cascore + $score->score;
		
		//we need to get the student number to add a grade
		$student = $this->getUserById($uid);
		$grade = new Grade;
		$grade->exam_score = $exam_score;
		$grade->test_score = $test_score;
		$grade->uid = $uid;
		$grade->course = $course;
		$grade->studentnumber = $studentnumber;
		$grade->totalscore = $totalscore;
		$grade->save();
		
		return $score;
	}
	
	/**
	 * Update score
	 * @param int $programme the programme to which this score applies
	 * @param int $course the course to which this score applies
	 * @param int $uid the student user id
	 * @param bool $is_locked whether the score is locked or not
	 * @param String $semester The current academic semester
	 * @param String $acad_session The current academic session
	 * @param int $overall the total score possible
	 * @param Double $exam_score the student's exam score
	 * @param Double $ca_score the student's CA score
	 * @param int $submittedby the id of the lecturer or teacher who submitted the score
	 */
	public function updateScore($score_id, $programme, $course, $uid, $is_locked, $semester, $acad_session, $overall, $exam_score, $ca_score, $submittedby){
		$score = Score::where('id', '=', $score_id)->first();
		$score->programme = $programme;
		$score->course = $course;
		$score->uid = $uid;
		$score->islocked = $is_locked;
		$score->semester = $semester;
		$score->academicsession = $acad_session;
		if (trim($exam_score) == ''){
			$score->exam_score == NULL;
		} else {
			$score->exam_score = $exam_score;
		}
		$score->score = $exam_score;
		if (trim($ca_score) == ''){
			$score->cascore = NULL;
		} else {
			$score->cascore = $ca_score;
		}
		$score->save();
		
		//whenever we update a score, we need to update the corresponding grade
		$grade = Grade::where('course', '=', $course)->where('uid', '=', $uid)->where('semester', '=', $semester)->where('academicsession', '=', $acad_session)->first();
		if ($grade != NULL){
			$grade->exam_score = $score->score;
			$grade->test_score = $score->cascore;
			$grade->uid = $uid;
			$grade->course = $course;
			$grade->totalscore = $score->score + $score->cascore;
		}
		
		if ($grade->save()){
			return TRUE;
		} else {
			return FALSE;
		}
	}
	
	/**
	 * Compute grade point by country
	 * @param String $grade the grade letter
	 * @param String $country the target country
	 */
	public function gradePointByCountry($grade, $country){
		$grade = Capsule::table('grading_scales')->join('country_system', 'grading_scales.grading_system_id', '=', 'country_system.grading_system_id')
										->join('countries', 'country_system.country_id', '=', 'countries.id')
										->where('country_name', '=', $country)
										->where('grade', '=', $grade)
										->first();	
		
		if ($grade != NULL){
			return $grade->points;
		} else {
			return NULL;
		}
	}
	
	/**
	 * Compute grade by country (find grade letter by country)
	 * @param Double $totalscore the total score
	 * @param String $country the target country
	 */
	public function gradeLetterByCountry($totalscore, $country){
		$grade = Capsule::table('grading_scales')->join('country_system', 'grading_scales.grading_system_id', '=', 'country_system.grading_system_id')
						->join('countries', 'country_system.country_id', '=', 'countries.id')
						->where('countries.country_name', '=', $country)
						->where('lower_bound', '<=', $totalscore)
						->orderBy('lower_bound', 'desc')
						->first();
		
		if ($grade != NULL){
			return $grade->grade;
		} else {
			return NULL;
		}
	}
	
	/**
	 * Compute grade point by WES
	 * @param Double $totalscore
	 */
	public function gradePointByWES($totalscore){
		$grade = Capsule::table('grading_scales')->join('grading_systems', 'grading_scales.grading_system_id', '=', 'grading_systems.id')
					->where('grading_systems.type', '=', 'WES Nigeria')
					->where('lower_bound', '<=', $totalscore)
					->orderBy('lower_bound', 'desc')
					->first();
		
		if ($grade != NULL){
			return $grade->points;
		} else {
			return NULL;
		}
	}
	
	/**
	 * Compute grade by WES (given a totalscore, return the corresponding grade or grade letter
	 * @param Double $totalscore the total score given in percentages
	 */
	public function gradeLetterByWES($totalscore){
		$grade = Capsule::table('grading_scales')->join('grading_systems', 'grading_scales.grading_system_id', '=', 'grading_systems.id')
						->where('grading_systems.type', '=', 'WES Nigeria')
						->where('lower_bound', '<=', $totalscore)
						->orderBy('lower_bound', 'desc')
						->first();
		
		if ($grade != NULL){
			return $grade->grade;
		} else {
			return NULL;
		}
	}
	
	/**
	 * Compute student's cumulative GPA
	 * @param int $uid the student's ID
	 * @param String $student_number A student number. Should valide if user is in role "Student"
	 * @param String $programme the student's programme
	 */	
	public function computeCumulativeGPA($uid, $student_number, $programme){
		$totals = Capsule::table('grades')->where('uid', '=', $uid)->join('scores', 'scores.uid', '=', 'grades.uid')
						->select(DB::raw('SUM(points) AS totalpoints, SUM(creditload) AS totalcredit'))
						->where('grades.studentnumber', '=', $student_number)
						->where('scores.programme', '=', $programme)->first();
		if ($totals != NULL){
			$gpa = (float) $totals->totalpoints / (float) $totals->totalcredit;
			return $gpa;
		} else {
			return NULL;
		}	
	}
	
	/**
	 * Compute student's current GPA
	 * @param int $uid the student's ID
	 * @param int $student_number A student number. Should validate if user is in role "Student"
	 * @param String $semester Academic semester
	 * @param String $acad_session Academic session
	 */
	public function computeCurrentGPA($uid, $student_number, $semester, $acad_session){
		$totals = Capsule::table('grades')->where('uid', '=', $uid)
							->select(DB::raw('SUM(points) AS totalpoints, SUM(creditload) AS totalcredit'))
							->where('semester', '=', $semester)
							->where('studentnumber', '=', $student_number)
							->where('academicsession', '=', $acad_session)
							->first();
		if ($totals != NULl){
			$gpa = (float) $totals->totalpoints / (float) $totals->totalcredit;
			return $gpa;
		} else {
			return NULL;
		}
	}
}