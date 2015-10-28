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
    public function index()
    {
	    $this->View->render('admin/index', array(
			    'users' => UserModel::getPublicProfilesOfAllUsers())
	    );
    }

	public function actionAccountSettings()
	{
		AdminModel::setAccountSuspensionAndDeletionStatus(
			Request::post('suspension'), Request::post('softDelete'), Request::post('user_id')
		);

		Redirect::to("admin");
	}
	public static function checkUpdate()
	{ /* Checks if an update is available and offers to update. TODO: Autoupdate on FORCE_UPDATE file's presence. */
	exec("git fetch");
	if (exec("git rev-parse HEAD") != exec("git rev-parse @{u}")){
		echo "Updating.\n";
	exec("git pull");
	}
	else
		echo "No update available";
	}
}
