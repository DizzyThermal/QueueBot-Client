<?php
	require_once('variables/variables.php');
?>

<?php
	file_put_contents($PriorityQueueFile, "A\\\\".$_GET['file']."\\\\".$_GET['metadata']);
	sleep($ReadDelay + 1);
	echo "<meta http-equiv=\"refresh\" content=\"0;URL=index.php#".$_GET['pos']."\">";
?>
