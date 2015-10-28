<?php
	exec("git fetch");
	if (exec("git rev-parse HEAD") != exec("git rev-parse @{u}")){
		echo "Updating\n";
	exec("git pull");
	}
	else
		echo "No update available.\n";
?>
