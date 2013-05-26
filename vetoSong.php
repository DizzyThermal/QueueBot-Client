<?php
	require_once('variables/variables.php');
?>

<?php
	$cookie = $_GET['songID']."VETO";
	
	if(!isset($_COOKIE[$cookie]))
	{
		setcookie($cookie, "TRUE", time()+$CookieTimeout);
		file_put_contents($PriorityQueueFile, "V");
		sleep($ReadDelay + 1);	
	}
	else
	{
		echo '<script language="JavaScript">';
		echo '	alert("You already vetoed this song, calm down!");';
		echo '</script>';
	}
	
	echo '<script language="JavaScript">';
	echo '	opener.location.reload();';
	echo '	window.close();';
	echo '</script>';
	die();
?>
