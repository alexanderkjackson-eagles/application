<!DOCTYPE html>
<html>
<body>
<h3>Upload book</h3>

<form method="POST" action="processBook" enctype="multipart/form-data">
       <p><strong>Author</strong></p>
       <p><input type="text" name="Author" id="Author"></p>
       <p><strong>Title</strong></p>
       <p><input type="text" name="Title" id="Title"></p>
       <p><strong>Tags file</strong></p>
       <p><input type="file" name="tagsFile" id="tagsFile"></p>
       <p><strong>Book file</strong></p>
       <p><input type="file" name="bookFile" id="bookFile"></p>
	<input type="submit" name="bookUpload" value="Submit" />
    </form>
</body>
</html>
