<?php
	require_once('variables/variables.php');
?>

<?php
	$cookie = str_replace(" ", "", $_GET['metadata']);
	$cookie = str_replace("\\", "", $cookie);
	if(!isset($_COOKIE[$cookie]))
	{
		setcookie($cookie, "TRUE", time()+$CookieTimeout);
		file_put_contents($PriorityQueueFile, "A\\\\".$_GET['file']."\\\\".$_GET['metadata']);
		sleep($ReadDelay + 1);
	}
	else
	{
		echo '<script language="JavaScript">';
		echo '	alert("You already added this song recently, calm down!");';
		echo '</script>';
	}
	
	echo '<script language="JavaScript">';
	echo '	var w = window.opener;';
	echo '	var w2 = w.opener;';
	echo '	window.opener = self;';
	echo '	w.close();';
	echo '	w2.location.reload();';
	echo '	window.close();';
	echo '</script>';
	die();
?>
