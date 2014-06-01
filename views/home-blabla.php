<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8" />
		<title>Hello World</title>
	</head>
	<body>
		<h1>Hello World</h1>
		<h2>It works!</h2>
		<h3>Isn't that amazing?!</h3>
		<?php
		if(!empty($obj)) {
			echo '<p>Obj = '.$obj.'</p>';
			$obj->saveToFile('obj.json');
			echo '<hr />';
		}
		if(!empty($str)) {
			echo '<p>You said: '.$str.'</p>';
		}
		?>
	</body>
</html>