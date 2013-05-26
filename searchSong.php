<?php
	require_once('variables/variables.php');
?>

<body bgcolor="#F0F0F0" link="#666666" alink="#666666" vlink="#666666">

<?php
	if(!isset($_GET['search']))
	{
		?>
			<table border="0">
				<tr>
					<td style="vertical-align:middle;">
						<a href="javascript:search();" style="text-decoration:none;">
							<img src="images/search.png" />
						</a>
					</td>
					<td style="vertical-align:middle;">
						<a href="javascript:search();" style="text-decoration:none;">
							<font face="Arial" size="6">Search</font>
						</a>
					</td>
				</tr>
			</table>
		<?php
	}
	else
	{
		?>
			<table border="0">
				<tr>
					<td style="vertical-align:middle;">
						<a href="javascript:search();" style="text-decoration:none;">
							<img src="images/search.png" />
						</a>
					</td>
					<td style="vertical-align:middle;">
						<a href="javascript:search();" style="text-decoration:none;">
							<font face="Arial" size="6">Search Again</font>
						</a>
					</td>
				</tr>
			</table>

			<font face="Arial" size="6">Results for: "<?php echo $_GET['search']; ?>"</font>
			<table border="0">
		<?php
	}
?>

<script language="JavaScript">
	function zz()
	{
		Query = window.prompt("What are you looking for?", "");
		if(Query)
			window.location = 'searchSong.php?search=' + Query;
	}
</script>

<br />

<?php
	$nowPlayingList = file($NowPlayingFile);
	$database = file($QBMusicDatabase);
?>

<!--                -->
<!-- Search Results -->
<!--                -->

<?php

	$search = urldecode($_GET['search']);
	foreach ($database as $dbLine)
	{
		$songInfo = explode("\\", $dbLine);

		$FOUND = 0;
		if((strpos(strtoupper($songInfo[$ARTIST]), strtoupper($search)) !== false) || (strpos(strtoupper($songInfo[$TITLE]), strtoupper($search)) !== false) || (strpos(strtoupper($songInfo[$ALBUM]), strtoupper($search)) !== false) || (strpos(strtoupper($songInfo[$GENRE]), strtoupper($search)) !== false))
			$FOUND = 1;
		
		if($FOUND == 1)
		{
	?>
		<tr>
			<td>
				<?php $URL = "addSong.php?file=".$songInfo[$FILENAME]."&metadata=".$songInfo[$ARTIST]."%5C%5C".$songInfo[$TITLE]."%5C%5C".$songInfo[$ALBUM]."%5C%5C".$songInfo[$GENRE];?>
				<td><a href="<?php echo $URL; ?>" target="_blank"><img src="images/add.png" /></a></td>
			</td>
			<td>
				<table border="0">
					<tr><td><b><?php echo $songInfo[$ARTIST]; ?></b></td></tr>
					<tr><td><?php echo $songInfo[$TITLE]; ?></td></tr>
					<tr><td><i><?php echo $songInfo[$ALBUM]; ?></i></td></tr>
				</table>
			</td>
		</tr>
	<?php
		}
	}
?>
</table>
