   
<head>
	<script>
	    var counter = 1;

    var limit = 6;

    function addInput(divName){

         if (counter == limit)  {

              alert("You have reached the limit of adding " + counter + " inputs");

         }

         else {

              var newdiv = document.createElement('div');

              newdiv.innerHTML = "Book " + (counter + 1) + " <br><input type='text' name='myInputs[]'>";

              document.getElementById(divName).appendChild(newdiv);

              counter++;

         }

    }
	</script>
</head>

<body>
<h3>Create session</h3>


   <script src="/wp-includes/js/addInput.js" language="Javascript" type="text/javascript"></script>

    <form id="form1" method="POST" action="createSection.php">
			
    <div id="addSession">
			<p><strong>Enter Instructor ID: </strong><br>
			<input type='text' name='instructorID' size='10' />
			</p>

			<p><strong>Enter Number of Paragraphs to be Generated: </strong><br>
			<input type='text' name='paragraphParameter' size='10' />
			</p>
		
        Book 1<br><input type="text" name="myInputs[]">
		
    </div>

         <input type="button" value="Add another Book ID" onClick="addInput('addSession');">
		 
		<br><br><input type="submit" name="addbutton" value="Create Section" />
    </form>
</body>
