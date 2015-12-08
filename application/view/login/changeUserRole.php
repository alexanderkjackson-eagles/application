<div class="container">
    <h1>LoginController/changeUserRole</h1>

    <!-- echo out the system feedback (error and success messages) -->
    <?php $this->renderFeedbackMessages(); ?>

    <div class="box">
        <h2>Change account type</h2>
        <p>
	<strong>For students:</strong> This page will demonstrate the ability to enroll or drop instructional sessions (classes). This will be done by entering an enroll code.<br />
	<strong>For others:</strong> This page will use the same code-based authentication system to provide soon-to-be instructors and administrators the ability to elevate their privileges to their correct user-type. They will be provided these codes by others.
	<!--
	This page will demonstrate the ability to enroll or drop instructional sessions (classes). Once part of a class, a user will be able to view and contact the other student profiles, minus the vital tag data. They will be able to message the instructor/students via the site, but they will have no email privileges. They will also have access to class sessions, which will consist of sets of questions. Should the instructor want participation to be mandatory, they will be able to view assignments and due dates, which themselves will consist of completing a certain number of questions from selections.
	In addition to this, soon-to-be instructors will be able to enter a code to be elevate to the instructor user type. The same is for researchers/site administrators. --!>
        </p>
	    <p>
	    </p>

        <h2>Currently, your account type is: <?php $userType = Session::get('user_account_type'); 
		switch(Session::get('user_account_type')) {
			case 1:
				echo "Pupil.";
				break;
			case 2:
				echo "Instructor.";
				break;
			case 7:
				echo "Administrator (Research-type)";
				break;
	
			default:
				echo "Invalid user type. Contact webmaster@projectweb.site";
			}
	?></h2>
        <!-- basic implementation for two account types: type 1 and type 2 -->
	<form action=TODO method="post">
		Enter code:
		<input type="text" name="code">
	</form>
    </div>
</div>
