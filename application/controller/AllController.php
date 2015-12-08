<?php

class allController extends Controller
{
    /**
     * Construct this object by extending the basic Controller class
     */
public function __construct()
{
        parent::__construct();

        // special authentication check for the entire controller: Note the check-ADMIN-authentication!
        // All methods inside t public function getAllClasses(){
	Auth::checkStudentAuthentication();
}

public function studentList(){
	$this->View->Render("all/studentList");
}

public function viewAnswers(){
	$this->View->Render("all/viewAnswers");
}

public function elevate(){
	$this->View->Render("all/elevate");
}

public function joinClass(){
	$this->View->Render("all/joinClass");
}

public function viewText(){
	$this->View->Render("all/viewText");
}

public function register(){
	$this->View->Render("all/register");
}

public function getAllClasses(){
                $database = DatabaseFactory::getFactory()->getConnection();
                $sql = "SELECT * FROM `class`";
                $query = $database->prepare($sql);
                $query->execute();

                $all_classes = array();

                foreach ($query->fetchAll() as $class) {
                        array_walk_recursive($class, 'Filter::XSSFilter');

                        $all_classes[$class->class_id] = new stdClass();
                        $all_classes[$class->class_id]->class_id = $class->class_id;
                        $all_classes[$class->class_id]->num_paragraphs = $class->num_paragraphs;
                        $all_classes[$class->class_id]->class_name = $class->class_name;
                        $all_classes[$class->class_id]->class_key = $class->class_key;
                        $all_classes[$class->class_id]->instructor_id = $class->instructor_id;
                }

                return $all_classes;
}

    /**
     * This method lists the classes.
     */

   public function classList(){
   	$this->View->render('all/classList', array(
		'classList' => self::getAllClasses()));
   }

   public function processKey(){
   	$key = $_POST['key'];
	$database = DatabaseFactory::getFactory()->getConnection();
	$sql = "SELECT * FROM `special_keys` WHERE `key` = :key;";
	$query = $database->prepare($sql);
	$query->execute(array(
		':key' => $key
		));
	$res = $query->fetch();
	if (!$res){
		echo "This is an incorrect key.";
		return;
	}

	if ($res->key_type == "Instructor"){
		$account_type = 6;
	}

	else if ($res->key_type == "Administrator"){
		$account_type = 7;
	}
	else{
		echo "Serious error. Please bookmark this page and email webmaster@projectweb.site";
		return;
	}

	$sql = "UPDATE `users` SET `user_account_type` = :account_type WHERE `user_id` = :user_id;";
	$query = $database->prepare($sql);
	$query->execute(array(
		':account_type' => $account_type,
		':user_id' => Session::get('user_id')
		));
		Session::set('user_account_type', $account_type);
		echo "You are now an " . $res->key_type . '.';
   }

   public static function processAnswer(){
   	$tag = $_POST['tag'];
	// Check if the tag provided is valid.
	if (!in_array($tag, Session::get('tags'))){
		echo "<strong><p>Error: Tag \"" . $tag . "\" is not an option. Please return to the previous page and select one suggested from the drop-down list.</strong></p>";
		Session::set('Error-inv-tag', true);
		return;
	}
	$user_id = Session::get('user_id');
	$book_id = Session::get('book_id');
	$class_id = Session::get('class_id');
	$excerptStart = (int) Session::get('excerptStart');
	$excerptSize = (int) Session::get('excerptSize');

	$database = DatabaseFactory::getFactory()->getConnection();
	// Check if the user has already input for this section
	$sql = "SELECT section_id FROM `answers` WHERE `user_id` = :user_id AND `book_id` = :book_id AND `section_id` = :section_id ORDER BY `book_id` ASC ";
	$query = $database->prepare($sql);
	// Establish range of sections tagged.
	$sections = range($excerptStart, $excerptStart+$excerptSize-1);

	$matches = array();
	// Find all matching sections tagged before.
	for ($i = 0; $i < $excerptSize; $i++){
		$query->execute( array(
			':user_id' => $user_id,
			':book_id' => $book_id,
			':section_id' => $sections[$i]
			));
			$result = $query->fetch();
			if ($result)
				array_push($matches, $result->section_id);
	}
	// Update sections to only reference those untagged by this user.
	$sections = array_diff($sections, $matches);

	$sql = "INSERT INTO `huge`.`answers` (`user_id`, `book_id`, `class_id`, `section_id`, `tag`) VALUES (:user_id, :book_id, :class_id, :section_id, :tag);";
	$sql2 = "UPDATE `sections` SET num_answers = num_answers + 1 WHERE `section_id` = :section_id;";
	$query2 = $database->prepare($sql2);
	$query = $database->prepare($sql);
	$sql3 = "SELECT * FROM `sections` WHERE `section_id` = :section_id;";
	$query3 = $database->prepare($sql3);
	$set_dominant_tag_sql = "UPDATE `sections` SET dominant_tag = :dominant_tag, dominant_tag_count = :dominant_tag_count WHERE `section_id` = :section_id;";
	$set_dominant_tag_query = $database->prepare($set_dominant_tag_sql);
	$get_dominant_tag_sql = "SELECT `dominant_tag` FROM `sections` WHERE `section_id` = :section_id;";
	$get_answer_tags_sql = "SELECT `tag` FROM `answers` WHERE `section_id` = :section_id;";
	$get_answer_tags_query = $database->prepare($get_answer_tags_sql);
	$increment_dominant_tag_sql = "UPDATE `sections` SET dominant_tag = dominant_tag + 1 WHERE `section_id` = :section_id;";
	$increment_dominant_tag_query = $database->prepare($increment_dominant_tag_sql);
	// Update only sections the user has not tagged before.
	foreach ($sections as $section_id){
		$query->execute(array( // Insert answers
			':user_id' => $user_id,
			':book_id' => $book_id,
			':class_id' => $class_id,
			':section_id' => $section_id,
			':tag' => $tag
		));
		$query2->execute(array( // Update num_answers in sections
			':section_id' => $section_id
		));
		$query3->execute(array( // Get all of section from sections
			':section_id' => $section_id
		));
		while ($res = $query3->fetch()){
			$dominant_tag_count = (float)$res->dominant_tag_count;
			$num_answers = (float)$res->num_answers;
			if ( $res->dominant_tag == $tag ){
				$increment_dominant_tag_query->execute( array(
					':section_id' => $section_id
				));
			}
			if ( ($dominant_tag_count / $num_answers) < 0.50 ){ // Update dominant_tag
				$_tagList = Session::get('tags');
				$tagList = array();
				foreach ($_tagList as $key => $value){
					$tagList["$value"] = 0;
				}
				$get_answer_tags_query->execute( array(
					':section_id' => $section_id
					));
				while ($res = $get_answer_tags_query->fetch()){
					$tagList["$res->tag"] += 1;
				}
				$largestValue = 0;
				$largestKey = 0;
				foreach($tagList as $key => $value){
					if ($value > $largestValue){
						$largestValue = $value;
						$largestKey = $key;
					}
				}
				$set_dominant_tag_query->execute( array(
					':dominant_tag' => $largestKey,
					':dominant_tag_count' => $largestValue,
					':section_id' => $section_id
					));
			}
		}
	}
	Redirect::to("all/index");
   }

   public static function getBooks($class_id){
	$database = DatabaseFactory::getFactory()->getConnection();
	$sql = "SELECT `book_id` FROM `class_books` WHERE `class_id` = :class_id;";
	$query = $database->prepare($sql);
	$query->execute(array(
		':class_id' => $class_id
		));

	$retBooks = array();
	while ($row = $query->fetch(PDO::FETCH_ASSOC)){
		array_push($retBooks, $row['book_id']);
	}
	return $retBooks;
   }

   public static function getNumParagraphs($class_id){
	$database = DatabaseFactory::getFactory()->getConnection();
	$sql = "SELECT `num_paragraphs` FROM `class` WHERE `class_id` = :class_id;";
	$query = $database->prepare($sql);
	$query->execute(array(
		':class_id' => $class_id
		));

	return (int) $query->fetch()->num_paragraphs;
   }

   public static function getTags($book_id){
	$database = DatabaseFactory::getFactory()->getConnection();
	$sql = "SELECT `tag` FROM `tags_lists` WHERE `book_id` = :book_id;";
	$query = $database->prepare($sql);
	$query->execute(array(
		':book_id' => $book_id
		));
	
	$retTags = array();
	while ($row = $query->fetch(PDO::FETCH_ASSOC)){
		array_push($retTags, $row['tag']);
	}
	return $retTags;
   }

   public static function getQuestionText($book_id, $num_paragraphs){
	// Get the number of sections of the book.
	$database = DatabaseFactory::getFactory()->getConnection();
	$sql = "SELECT `sections` FROM `books` WHERE `book_id` = :book_id;";
	$query = $database->prepare($sql);
	$query->execute(array(
		':book_id' => $book_id
		));
	$numSections = (int) $query->fetch()->sections;

	// Get the start section of the book.	
	$sql = "SELECT `section_id` from `sections` WHERE `book_id` = :book_id;";
	$query = $database->prepare($sql);
	$query->execute(array(
		':book_id' => $book_id
		));
	$bookStart = (int) $query->fetch()->section_id;
	
	// Get a randomly-generated start of the excerpt.
	$excerptStart = rand($bookStart, $bookStart+($numSections-$num_paragraphs)); // Generates random excerptStart from the first to the last-num_paragraphs sections.
	
	// Create a string, excerptText, which contains the text with the desired number of paragraphs.
	$excerptText = ''; 
	$sql = "SELECT `section_text` FROM `sections` WHERE `section_id` = :section_id;";
	$query = $database->prepare($sql);
	for ($i = 0; $i < $num_paragraphs; $i++){
		$query->execute(array(
			':section_id' => $excerptStart+$i
			));
		$excerptText .= $query->fetch()->section_text;
		$excerptText .= "<br><br>";
	}
	Session::set('excerptStart', $excerptStart);
	Session::set('excerptSize', $num_paragraphs);
   	return $excerptText;
   }

    public static function generateQuestion($class_id){
    	if (Session::get('Error-inv-tag') == "true"){ // Is the user returning from an error condition? If so, show the same question.
		Session::set('Error-inv-tag', "false");
		return array("text" => Session::get('Error-text'), "tags" => Session::get('tags'));
	}
    	$books = self::getBooks($class_id);
	$book_id = $books[array_rand($books)]; // Get a random Book ID
	$numParagraphs = self::getNumParagraphs($class_id);
	$tags = self::getTags($book_id);
	$paragraphs = self::getQuestionText($book_id, $numParagraphs);

	Session::set('tags', $tags); // Using Session as a cache.
	Session::set('book_id', $book_id);
	Session::set('Error-text', $paragraphs);

	return array("text" => $paragraphs, "tags" => $tags);
    }

    public function index()
    {
    	$class_id = Session::get('class_id');
	if (!$class_id);{
		Session::set('class_id', 0);
		$class_id = 0;
	}
    	$question = self::generateQuestion(Session::get('class_id'));
	$this->View->render('all/questionGenerator', array(
		"question" => $question
		)
	);
    }
}
