<html>
<body>
	<?php
			$chatfile = fopen("chat.txt", "r") or die("Unable to load chat!");
			echo fread($chatfile, filesize("chat.txt"));
			fclose($chatfile);
	?>
</body>
</html>