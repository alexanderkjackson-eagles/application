<div class="container">
	<h1>Key generator</h1>
	<p>These keys are to be provided to soon-to-be administrators or instructors.</p>
	<div class="box">
	<body>
		<form action="generateKeyProcessor" method="post" enctype="multipart/form-data">
		<input type="radio" name="user_type" value="Instructor">Instructor</input>
		<br>
		<input type="radio" name="user_type" value="Administrator">Administrator</input>
		<br>
		Force value:<input type="text" name="force_value" value="">
		<br>
		Expiration on (YY-MM-DD):<input type="text" name="expiration" value=""> 
		<br>
		<input type="submit">
		</form>
	</body>
	</div>
</div>
