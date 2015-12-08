<div class="container">
	<div class="box">
		<div>
            <table class="overview-table">
	    	<center><strong>Data</center></strong>
                <thead>
                <tr>
                    <td>Book Title</td>
                    <td>Section Text</td>
                    <td>Number of answers</td>
                    <td>Dominant Tag</td>
		    <td>Agreement (%)</td>
                </tr>
                </thead>
                <?php foreach ($this->section_data as $section) { ?>
			<tr>
			<td><?= AllModel::getBookTitle($section->book_id) ?></td>
                        <td><?= AllModel::getTruncatedSectionText($section->section_id) ?></td>
                        <td><?= $section->num_answers ?></td>
                        <td><?= $section->dominant_tag ?></td>
                        <td><?php 
			$res=((float)$section->dominant_tag_count / (float)$section->num_answers);
			if ($res > 0.7) {
				echo '<font color="green">';
				echo $res;
				echo '</font>';
			}
			else if ($res > 0.6){
				echo '<font color="FE9000">';
				echo $res;
				echo '</font>';
			}
			else if ($res < 0.6){
				echo '<font color="red">';
				echo $res;
				echo '</font>';
			}
			?></td>
                        </tr>
                <?php } ?>
            </table>
		</div>
	</div>
</div>
