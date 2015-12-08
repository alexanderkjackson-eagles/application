<?php

class AdminController extends Controller
{
    /**
     * Construct this object by extending the basic Controller class
     */
    public function __construct()
    {
        parent::__construct();

        // special authentication check for the entire controller: Note the check-ADMIN-authentication!
        // All methods inside this controller are only accessible for admins (= users that have role type 7)
        Auth::checkAdminAuthentication();
    }

    /**
     * This method controls what happens when you move to /admin or /admin/index in your app.
     */
    public function generateData(){
    	$this->View->render('admin/generateData', array(
		'books' => AdminModel::getAllBooks(),
		'instructors' => AdminModel::getAllInstructors()
		));
    }

    public function generateKey(){
    	$this->View->render('admin/generateKey');
    }

    public function validateDate($date){
// From https://stackoverflow.com/questions/19271381/correctly-determine-if-date-string-is-a-valid-date-in-that-format
    $dt = DateTime::createFromFormat('Y-m-d', $date);
    $current_dt = DateTime::createFromFormat('Y-m-d', "now");
    if ($dt < $current_dt){
	    return 0;
    }
    return $dt != false && !array_sum($dt->getLastErrors());
    }

    public function generateKeyProcessor(){
	$key_type = $_POST['user_type'];
	$force_value = $_POST['force_value'];

	if (sizeof($force_value) > 12){
		echo "Error: size of force_value is too large. It must be 12 or fewer characters.";
		return;
	}

	if (!$force_value){
		$force_value = uniqid();
	}

	//if ( self::validateDate($expiration_date) ){
	//	echo "Date format is incorrect. Perhaps you have traveled back in time? Remember to use YY-MM-DD";
	//	echo self::validateDate($expiration_date);
	//	return;
	//} OH, I can't get this to work.

	$database = DatabaseFactory::getFactory()->getConnection();
	$sql = "INSERT INTO `special_keys` (`key_type`, `key`, `expiration_date`) VALUES (:key_type, :force_value, NULL);";
	$query = $database->prepare($sql);
	$query->execute(array(
		'key_type' => $key_type,
		'force_value' => $force_value
	));
	echo "Successfully generated key: " . $force_value . " for  " . $key_type;
    }
    
    public function processData(){
	$book_ids = array();
	foreach ($_POST as $key => $value)
		if (substr($key, 0, 8) == "book_id_")
			array_push($book_ids, $value);

	$sql = "SELECT * FROM `sections` WHERE (`book_id` = :book_id) AND (`num_answers` != 0)";
	$database = DatabaseFactory::getFactory()->getConnection();
	$query = $database->prepare($sql);

	$section_data = array();
    	foreach ($book_ids as $value){
		$query->execute( array(
		':book_id' => $value
		));

		while ($res = $query->fetch()){
			array_push($section_data, $res);
		}

	}
	$this->View->render('admin/viewData', array(
		'section_data' => $section_data
	));
    }

    public function index()
    {
	    $this->View->render('admin/index', array(
			    'users' => UserModel::getPublicProfilesOfAllUsers())
	    );
    }

    public function bookList()
    {
    	$this->View->render('admin/bookList', array(
		    'books' => AdminModel::getAllBooks())
	);
    }

    public function instructorList()
    {
    	$this->view->render('admin/instructorList', array(
		'instructors' => AdminModel::getAllInstructors()));
    }

    public function sessionCreator()
    {
    	$this->View->render('admin/sessionCreator', array(
		'books' => AdminModel::getAllBooks(),
		'instructors' => AdminModel::getAllInstructors()
		)
	);
    }

    public function sessionEditor()
    {
    	$this->View->render('admin/sessionEditor');
    }

    public function aggregateData()
    {
    	$this->View->render('admin/aggregateData');
    }

    public function uploadBook()
    {
    	$this->View->render('admin/uploadBook');
    }

    public function processSession()
    { // Processes sections for entry into database
	$database = DatabaseFactory::getFactory()->getConnection();

	$instructor = $_POST["select_instructor"];
	$num_paragraphs = $_POST["paragraphParameter"];
	$class_key = uniqid(); // Possibly irresponsible use of uniqid(). It is not cryptographically secure.
	$class_name = $_POST["class_name"];

	// Get class_id
	$sql = "SELECT `AUTO_INCREMENT` FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = 'huge' AND TABLE_NAME = 'class';";
	$query = $database->prepare($sql);
	$class_id = $query->execute();
    	
	// Insert class row into table
	$sql = "INSERT INTO `huge`.`class` (`class_id`, `num_paragraphs`, `class_name`, `class_key`, `instructor_id`) VALUES (:class_id, :num_paragraphs, :class_name, :class_key, :instructor_id);";
	
	$query = $database->prepare($sql);
	$query->execute( array(':class_id' => $class_id, ':num_paragraphs' => $num_paragraphs, ':class_name' => $class_name, ':class_key' => $class_key, ':instructor_id' => $instructor) );

	// Add each book ID to the class_books table. (This relates the two)
	$sql = "INSERT INTO `huge`.`class_books` (`class_id`, `book_id`) VALUES (:class_id, :book_id);";
	$query = $database->prepare($sql);
	foreach ($_POST as $key => $value)
		if (substr($key, 0, 8) == "book_id_")
			$query->execute( array(':class_id' => $class_id, ':book_id' => $value) );
	$this->View->render('admin/sessionCreatorComplete', array(
		'instructor' => $instructor,
		'num_paragraphs' => $num_paragraphs,
		'class_key' => $class_key,
		'class_name' => $class_name,
		)
	);
    }

    public function processBook()
    { // Processes books for upload
	// Check for duplicate book upload.
	$title = $_POST["Title"];
	$database = DatabaseFactory::getFactory()->getConnection();
	$sql = "Select * FROM `books` WHERE `title` LIKE :title";
	$query = $database->prepare($sql);
	$query->execute( array(':title' => $title) );
	if ($query->fetch()){
		echo "Error: Book with title \"" . $title . "\" already exists.";
		return;
	}
	if ($_FILES["bookFile"]["size"] > 2000000 || $_FILES["tagsFile"]["size"] > 2000000){
		echo "Error: File is too large. (Maximum size: 2M)";
		return;
	}
	// Get author, booksFile, and tagsFile variables.
	$author = $_POST["Author"];
	$bookFile = $_FILES["bookFile"]["tmp_name"];
	$tagsFile = $_FILES["tagsFile"]["tmp_name"];

	// Get file text as input
	$input = file_get_contents($bookFile);
	// Break input into paragraphs array.
	$paragraphs = explode("\n\n", $input);
	$num_paragraphs = sizeof($paragraphs);
	// Insert book into books table
	$sql = "INSERT INTO `huge`.`books` (`book_id`, `title`, `author`, `sections`) VALUES (NULL, :title, :author, :num_paragraphs);";
	$query = $database->prepare($sql);
	$query->execute( array(':title' => $title, ':author' => $author, ':num_paragraphs' => $num_paragraphs) );
	// Get Book's ID TODO: Do this the right way with INFORMATION_SCHEMA
	$sql = "SELECT book_id FROM `books` WHERE `title` LIKE :title";
	$query = $database->prepare($sql);
	$query->execute( array(':title' => $title) );
	$book_id = $query->fetch()->book_id;
	// Insert book into class 0 (The sentinel class)
	$sql = "INSERT INTO `huge`.`class_books` (`class_id`, `book_id`) VALUES (:class_id, :book_id);";
	$query = $database->prepare($sql);
	$query->execute( array(
		':class_id' => 0,
		':book_id' => $book_id
		));
	// Setup SQL insert into sections table
	$sql = "INSERT INTO `huge`.`sections` (`section_id`, `book_id`, `section_text`) VALUES (NULL, :book_id, :paragraph);";
	$query = $database->prepare($sql);
	for ($i = 0; $i < $num_paragraphs; $i++){
		$query->execute( array(':book_id' => $book_id, ':paragraph' => $paragraphs[$i]) );
	}
	// Insert tags
	$input = file_get_contents($tagsFile);
	$tags = explode("\n", $input);
	$num_tags = sizeof($tags);
	$sql = "INSERT INTO `huge`.`tags_lists` (`book_id`, `tag`, `tag_popularity`) VALUES ( :book_id, :tag, 0)";
	$query = $database->prepare($sql);
	for ($i = 0; $i < $num_tags-1; $i++){
		$query->execute( array(':book_id' => $book_id, ':tag' => $tags[$i]) );
	}
	echo "Inserted book: \"" . $title . "\" with author \"" . $author . ",\" " . $num_paragraphs . " paragraphs, and " . $num_tags . " tags.";
    }

	public function actionAccountSettings()
	{
		AdminModel::setAccountSuspensionAndDeletionStatus(
			Request::post('suspension'), Request::post('softDelete'), Request::post('user_id')
		);

		Redirect::to("admin");
	}
	public static function checkUpdate()
	{ /* Checks if an update is available and updates if so. TODO: Autoupdate on FORCE_UPDATE file's presence and provide optional update otherwise.*/
		exec("git fetch", $output, $res);
		if (exec("git rev-parse HEAD") != exec("git rev-parse @{u}")){
			echo "<center><strong>Update available; Automatically installed. </strong></center>\n";
			exec("git pull");
		}
		else
			echo "<center><strong>Application version is current.</strong></center>";
		}
}
