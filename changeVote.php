<?php
	require_once('variables/variables.php');
?>

<?php
	$UPcookie = $_GET['songID']."UP";
	$DOWNcookie = $_GET['songID']."DOWN";

	if(isset($_COOKIE[$UPcookie]))
	{
		$direction = "-";
		setcookie($UPcookie, "FALSE", 1);
		if($_GET['direction'] == "UP")
			file_put_contents($PriorityQueueFile, $direction."\\\\".$_GET['songID']);
		else
		{
			file_put_contents($PriorityQueueFile, $direction."\\\\".$_GET['songID']."\n".$direction."\\\\".$_GET['songID']);
			setcookie($DOWNcookie, "TRUE", time()+$CookieTimeout);
		}
	}
	else if(isset($_COOKIE[$DOWNcookie]))
	{
		$direction = "+";
		setcookie($DOWNcookie, "FALSE", 1);
		if($_GET['direction'] == "DOWN")
			file_put_contents($PriorityQueueFile, $direction."\\\\".$_GET['songID']);
		else
		{
			file_put_contents($PriorityQueueFile, $direction."\\\\".$_GET['songID']."\n".$direction."\\\\".$_GET['songID']);
			setcookie($UPcookie, "TRUE", time()+$CookieTimeout);
		}
	}
	else
	{
		if($_GET['direction'] == UP)
		{
			$direction = "+";
			setcookie($UPcookie, "TRUE", time()+$CookieTimeout);
		}
		else
		{
			$direction = "-";
			setcookie($DOWNcookie, "TRUE", time()+$CookieTimeout);
		}

		file_put_contents($PriorityQueueFile, $direction."\\\\".$_GET['songID']);
	}

	sleep($ReadDelay);

	echo '<script language="JavaScript">';
	echo '	opener.location.reload();';
	echo '	window.close();';
	echo '</script>';
	die();
?>
