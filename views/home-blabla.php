<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8" />
		<title>Hello World</title>
	</head>
	<body>
		<h1>Hello World</h1>
		<?php
		echo '<h2>Config</h2>';
		echo '<pre>';
		var_dump($this->PHPBF->config->getAll());
		echo '</pre>';
		if(!empty($obj)) {
			echo '<h2>Listenable_Object</h2>';
			echo '<p>Created : '.$obj.'</p>';
			$obj->saveToFile('obj.json');
		}
		if(!empty($obj) && !empty($str)) {
			echo '<hr />';
		}
		echo '<h2>Controller parameters (via the URL)</h2>';
		if(!empty($str)) {
			echo '<p>You said: '.$str.'</p>';
		}
		else {
			echo '<p>You can change the URL to see what happens. <a href="'.$this->PHPBF->config->get('site_url').'">Try it!</a></p>';
		}
		?>
	</body>
</html>