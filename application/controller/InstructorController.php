<?php

class InstructorController extends Controller
{
    /**
     * Construct this object by extending the basic Controller class
     */
    public function __construct()
    {
        parent::__construct();

        // special authentication check for the entire controller: Note the check-ADMIN-authentication!
        // All methods inside this controller are only accessible for instructors (= users that have role type 6, are in class)
	Auth::checkInstructorAuthentication();
    }

    /**
     * This method controls what happens when you move to /instructor or /instructor/index in your app.
     */
    public function index()
    {
	    $this->View->render('instructor/index', array(
			    'users' => UserModel::getPublicProfilesOfAllStudents())
	    );
    }

	public function actionAccountSettings()
	{
		InstructorModel::setAccountSuspensionAndDeletionStatus(
			Request::post('suspension'), Request::post('softDelete'), Request::post('user_id')
		);

		Redirect::to("instructor");
	}
}
