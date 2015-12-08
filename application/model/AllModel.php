<?php

/**
 * Handles all data manipulation of the admin part
 */
class AllModel
{
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
			$all_classes[$class->instructor_id]->instructor_id = $class->instructor_id;
		}

		return $all_classes;
	}

	public static function getAccountType($user_account_type){
		$type = "Invalid user type! Contact an administrator!";
		switch ($user_account_type){
			case 5:
				$type = "student";
				break;
			case 6:
				$type = "instructor";
				break;
			case 7:
				$type = "administrator";
				break;
		}
		return $type;
	}

	public static function getBookTitle($book_id){
		$database = DatabaseFactory::getFactory()->getConnection();
		$sql = "SELECT `title` FROM `books` WHERE `book_id` = :book_id;";
		$query = $database->prepare($sql);
		$query->execute(array (
			':book_id' => $book_id
		));
		return $query->fetch()->title;
	}

	public static function getSectionText($section_id){
		$database = DatabaseFactory::getFactory()->getConnection();
		$sql = "SELECT `section_text` FROM `sections` WHERE `section_id` = :section_id;";
		$query = $database->prepare($sql);
		$query->execute(array (
			':section_id' => $section_id
		));
		return $query->fetch()->section_text;
	}

	public static function getTruncatedSectionText($section_id){
		$database = DatabaseFactory::getFactory()->getConnection();
		$sql = "SELECT `section_text` FROM `sections` WHERE `section_id` = :section_id;";
		$query = $database->prepare($sql);
		$query->execute(array (
			':section_id' => $section_id
		));
		$result = substr($query->fetch()->section_text, 0, 250);
		$result .= '<a href="' . Config::get('URL') . 'all/viewText?section_id=' . $section_id . '">...</a>';
		return $result;
	}

	public static function getClassName($class_id){
		$database = DatabaseFactory::getFactory()->getConnection();
		$sql = "SELECT `class_name` FROM `class` WHERE `class_id` = :class_id;";
		$query = $database->prepare($sql);
		$query->execute(array (
			':class_id' => $class_id
		));
		return $query->fetch()->class_name;
	}

	public static function getAllBooks(){
		$database = DatabaseFactory::getFactory()->getConnection();
		$sql = "SELECT * FROM `books`";
		$query = $database->prepare($sql);
		$query->execute();

		$all_books = array();

		foreach ($query->fetchAll() as $book) {
			array_walk_recursive($book, 'Filter::XSSFilter');

			$all_books[$book->book_id] = new stdClass();
			$all_books[$book->book_id]->book_id = $book->book_id;
			$all_books[$book->book_id]->title = $book->title;
			$all_books[$book->book_id]->author = $book->author;
			$all_books[$book->book_id]->sections = $book->sections;
		}

		return $all_books;
	}

    public static function getAllInstructors()
    {
        $database = DatabaseFactory::getFactory()->getConnection();

        $sql = "SELECT user_id, user_name, user_email, user_active, user_has_avatar, user_deleted FROM users WHERE user_account_type = 6";
        $query = $database->prepare($sql);
        $query->execute();

        $all_users_profiles = array();

        foreach ($query->fetchAll() as $user) {

            // all elements of array passed to Filter::XSSFilter for XSS sanitation, have a look into
            // application/core/Filter.php for more info on how to use. Removes (possibly bad) JavaScript etc from
            // the user's values
            array_walk_recursive($user, 'Filter::XSSFilter');

            $all_users_profiles[$user->user_id] = new stdClass();
            $all_users_profiles[$user->user_id]->user_id = $user->user_id;
            $all_users_profiles[$user->user_id]->user_name = $user->user_name;
            $all_users_profiles[$user->user_id]->user_email = $user->user_email;
            $all_users_profiles[$user->user_id]->user_active = $user->user_active;
            $all_users_profiles[$user->user_id]->user_deleted = $user->user_deleted;
            $all_users_profiles[$user->user_id]->user_avatar_link = (Config::get('USE_GRAVATAR') ? AvatarModel::getGravatarLinkByEmail($user->user_email) : AvatarModel::getPublicAvatarFilePathOfUser($user->user_has_avatar, $user->user_id));
        }

        return $all_users_profiles;
    }

}
