<div class="container">
	<h1>Class creation successful</h1>
	<div class="box">
            <table class="overview-table">
	    	<center><strong>Successfully created class with the following attributes:</center></strong>
                <thead>
                <tr>
                    <td>Class name</td>
                    <td>Instructor</td>
                    <td>Number of paragraphs</td>
		    <td>Class join key</td>
                </tr>
                </thead>
			<tr>
			<td><?= $this->class_name ?></td>
                        <td><?= $this->instructor ?></td>
                        <td><?= $this->num_paragraphs ?></td>
			<td><?= $this->class_key ?></td>
                        </tr>
            </table>
	    </div>
</div>
