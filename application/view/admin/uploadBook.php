<!DOCTYPE html>
<html>
<body>
<h3>Create session</h3>

<form method="POST" action="processBook" enctype="multipart/form-data">
       <p><strong>Author</strong></p>
       <p><input type="text" name="Author" id="Author"></p>
       <p><strong>Title</strong></p>
       <p><input type="text" name="Title" id="Title"></p>
       <p><strong>File</strong></p>
       <p><input type="file" name="fileToUpload" id="fileToUpload"></p>
	<input type="submit" name="bookUpload" value="Submit" />
    </form>
</body>
</html>
