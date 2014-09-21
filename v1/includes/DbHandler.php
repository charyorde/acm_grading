<?php
use Illuminate\Database\Capsule\Manager as Capsule;

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
		} else {
			return USER_ALREADY_EXISTED;
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
		$user = User::where('username', '=', $username)->first();
		if ($user != NULL){
			if (PassHash::check_password($user->password, $password)){
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
	public function getUserByUsername($username){
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
		$score->overall = $overall;
		$score->score = $exam_score;
		$score->cascore = $ca_score;

		$score->save();
		
		$total_score = $score->cascore + $score->score;
		
		$studentnumber = User::where('id', '=', $score->uid)->pluck('studentnumber');
		
		//we need to get the student number to add a grade
		$student = $this->getUserById($uid);
		$grade = new Grade;
		$grade->exam_score = $exam_score;
		$grade->test_score = $ca_score;
		$grade->uid = $uid;
		$grade->course = $course;
		$grade->studentnumber = $studentnumber;
		$grade->totalscore = $total_score;
		$grade->submittedby = $submittedby;
		$grade->grade = $this->gradeLetterByCountry($total_score, 'Nigeria'); // to be changed after further integration with full system - country - from config maybe?
		$grade->gradepoint = (float) $this->gradePointByCountry($grade->grade, 'Nigeria') * 3.0; // to be changed after further integration with full system - course points and country
		$grade->creditload = 3; // to be changed after further integration with full system - from course data?
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
		$score->score = $exam_score;
		$score->cascore = $ca_score;
		$score->overall = $overall;
		$score->save();
		
		//whenever we update a score, we need to update the corresponding grade
		
		$grade_id = Capsule::table('grades')->join('scores', 'scores.uid', '=', 'grades.uid')
				 ->where('grades.course', '=', $course)
				 ->where('grades.uid', '=', $uid)
		         ->where('scores.semester', '=', $semester)
		         ->where('scores.academicsession', '=', $acad_session)
				 ->pluck('grades.id'); 
		
		if (!empty($grade_id)){
			$updatedgrade['exam_score'] = $score->score;
			$updatedgrade['test_score'] = $score->cascore;
			$updatedgrade['uid'] = $uid;
			$updatedgrade['course'] = $course;
			$updatedgrade['totalscore'] = $score->score + $score->cascore;
			$updatedgrade['grade'] = $this->gradeLetterByCountry($updatedgrade['totalscore'], 'Nigeria'); // to be changed after further integration with full system
			$updatedgrade['gradepoint'] = (float) $this->gradePointByCountry($updatedgrade['grade'], 'Nigeria') * 3.0; // to be changed after further integration with full system - course credit and country
			$updatedgrade['creditload'] = 3; // to be changed after further integration with full system
			
			Capsule::table('grades')->where('id', $grade_id)->update($updatedgrade);
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
										->where('countries.country_name', '=', $country)
										->where('grading_scales.grade', '=', $grade)
										->first();	
		
		if (!empty($grade)){
			return $grade['points'];
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
		
		if (!empty($grade)){
			return $grade['grade'];
		} else {
			return NULL;
		}
	}
	
	/**
	 * Compute grade point by WES
	 * @param Double $totalscore
	 * @param Double $country the country whose score needs to be converted to WES
	 */
	public function gradePointByWES($totalscore, $country){
		$grade = Capsule::table('wes_us_scale')->join('countries', 'wes_us_scale.country_id', '=', 'countries.id')
					->where('countries.country_name', '=', $country)
					->where('wes_us_scale.lower_bound', '<=', $totalscore)
					->orderBy('wes_us_scale.lower_bound', 'desc')
					->first();
		
		if ($grade != NULL){
			return $grade['points'];
		} else {
			return NULL;
		}
	}
	
	/**
	 * Compute grade by WES (given a totalscore, return the corresponding grade or grade letter
	 * @param Double $totalscore the total score given in percentages
	 * @param String $country the country whose score needs to be converted to WES
	 */
	public function gradeLetterByWES($totalscore, $country){
		$grade = Capsule::table('wes_us_scale')->join('countries', 'wes_us_scale.country_id', '=', 'countries.id')
						->where('countries.country_name', '=', $country)
						->where('wes_us_scale.lower_bound', '<=', $totalscore)
						->orderBy('wes_us_scale.lower_bound', 'desc')
						->first();
		
		if ($grade != NULL){
			return $grade['grade'];
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
		$grades = Capsule::table('grades')->join('scores', function($join){
				$join->on('scores.uid', '=', 'grades.uid');
				$join->on('scores.course', '=', 'grades.course');
			})
		    ->select(Capsule::raw('grades.gradepoint, grades.creditload'))
		    ->where('grades.uid', '=', $uid)
		    ->where('scores.programme', '=', $programme)->get();

		if (!empty($grades)){
			$totalpoints = 0.0;
			$totalcredits = 0.0;
			foreach ($grades as $grade){
				$totalpoints = $totalpoints + (float) $grade['gradepoint'];
				$totalcredits = $totalcredits + (float) $grade['creditload'];
			}
			$gpa = (float) $totalpoints / (float) $totalcredits;
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
		$grades = Capsule::table('grades')->join('scores', function($join){
				$join->on('scores.uid', '=', 'grades.uid');
				$join->on('scores.course', '=', 'grades.course');
			})
		    ->select(Capsule::raw('grades.gradepoint, grades.creditload'))
		    ->where('grades.uid', '=', $uid)
			->where('scores.semester', '=', $semester)
			->where('scores.academicsession', '=', $acad_session)->get();

		if (!empty($grades)){
			$totalpoints = 0.0;
			$totalcredits = 0.0;
			foreach ($grades as $grade){
				$totalpoints = $totalpoints + (float) $grade['gradepoint'];
				$totalcredits = $totalcredits + (float) $grade['creditload'];
			}
			$gpa = (float) $totalpoints / (float) $totalcredits;
			return $gpa;
		} else {
			return NULL;
		}	
	}
}