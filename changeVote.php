<?php
	require_once('variables/variables.php');
?>

<?php
	if($_GET['direction'] == UP)
		$direction = "+";
	else
		$direction = "-";

	file_put_contents($PriorityQueueFile, $direction."\\\\".$_GET['songID']);
	sleep($ReadDelay + 1);
	echo "<meta http-equiv=\"refresh\" content=\"0;URL=index.php?added=TRUE\">";
?>
