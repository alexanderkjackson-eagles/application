<?php

/**
 * Handles all data manipulation of the admin part
 */
class AdminModel
{
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

	public static function setAccountSuspensionAndDeletionStatus($suspensionInDays, $softDelete, $userId)
	{
		$database = DatabaseFactory::getFactory()->getConnection();

		if ($suspensionInDays > 0) {
			$suspensionTime = time() + ($suspensionInDays * 60 * 60 * 24);
		} else {
			$suspensionTime = null;
		}

        // FYI "on" is what a checkbox delivers by default when submitted. Didn't know that for a long time :)
		if ($softDelete == "on") {
			$delete = 1;
		} else {
			$delete = 0;
		}

		$query = $database->prepare("UPDATE users SET user_suspension_timestamp = :user_suspension_timestamp, user_deleted = :user_deleted  WHERE user_id = :user_id LIMIT 1");
		$query->execute(array(
			':user_suspension_timestamp' => $suspensionTime,
			':user_deleted' => $delete,
			':user_id' => $userId
		));

		if ($query->rowCount() == 1) {
			Session::add('feedback_positive', Text::get('FEEDBACK_ACCOUNT_SUSPENSION_DELETION_STATUS'));
			return true;
		}
	}
}
