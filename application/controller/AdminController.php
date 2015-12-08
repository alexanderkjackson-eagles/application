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

    public function sessionCreator()
    {
    	$this->View->render('admin/sessionCreator');
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

    public function processBook()
    { // Processes books for upload
	$target_dir = "/var/www/books/";
	$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
	if (file_exists($target_file)){
		echo "File already exists.";
		return;
	}
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
