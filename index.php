<?php
	require_once('variables/variables.php');
?>
<script language="JavaScript">
	function search()
	{
		Query = window.prompt("What are you looking for?", "");
		if(Query)
			window.open('searchSong.php?search=' + Query);
	}
	function openPage(pageString)
	{
		window.open(pageString, '', 'width=200,height=200');
	}
</script>

<a href="javascript:search();"><font size="6">Search Songs</font></a><br /><br />

<?php
	$nowPlayingList = file($NowPlayingFile);
	$database = file($QBMusicDatabase);
?>

<font size="6" family="Verdana"><b>Now Playing</b></font>
<table border="0">

<?php
	foreach ($nowPlayingList as $song)
	{
		$songInfo = explode("\\\\", $song);
		
		if(sizeof($songInfo) <= 4)
		{
			$veto = explode("/", $songInfo[$NPVETO]);
			$vetoColor = $VETOGOOD;
			if(($veto[0]/$veto[1]) >= .5)
				$vetoColor = $VETOWEAK;
			if(($veto[0]/$veto[1]) >= .75)
				$vetoColor = $VETOWARN;
?>
			<tr>
				<td>
					<a href="#" onClick="javascript:openPage('vetoSong.php');"><img src="images/veto.png" /></a><br />
					<center><font color="<?php echo $vetoColor; ?>"><b><?php echo $veto[0]; ?>/<?php echo $veto[1]; ?></b></font></center>
				</td>
				<td>
					<table border="0">
						<tr><td><b><?php echo $songInfo[$NPTITLE]; ?></b></td></tr>
						<tr><td><?php echo $songInfo[$NPTITLE]; ?></td></tr>
						<tr><td><i><?php echo $songInfo[$NPALBUM]; ?></i></td></tr>
					</table>
				</td>
			</tr>
		</table>
		<font size="6" family="Verdana"><b>Queued Up</b></font>
		<table border="0">
<?php
		}
		else
		{
			$voteColor = $REDDITNEU;
			if($songInfo[$QRATING] >= 1)
				$voteColor = $REDDITUP;
			if($songInfo[$QRATING] <= -1)
				$voteColor = $REDDITDOWN;
?>
			<tr>
				<td>
					<table border="0" align="center">
						<tr><td align="center"><a href="#" onClick="javascript:openPage('changeVote.php?songID=<?php echo $songInfo[$QID] ?>&direction=UP');"><img src="images/upvote.png" /></a></td></td>
						<tr><td align="center"><font color="<?php echo $voteColor ?>"><b><?php echo $songInfo[$QRATING]; ?></b></font></td></tr>
						<tr><td align="center"><a href="#" onClick="javascript:openPage('changeVote.php?songID=<?php echo $songInfo[$QID] ?>&direction=DOWN');"><img src="images/downvote.png" /></a></td></td>
					</table>
				</td>
				<td>
					<table border="0">
						<tr><td><b><?php echo $songInfo[$QARTIST]; ?></b></td></tr>
						<tr><td><?php echo $songInfo[$QTITLE]; ?></td></tr>
						<tr><td><i><?php echo $songInfo[$QALBUM]; ?></i></td></tr>
					</table>
				</td>
			</tr>
<?php
		}
		$index++;
	}

?>
	</table>

	<table border="0">
	<tr>
		<td>&nbsp;</td>
		<td><b>Artist Name</b></td>
		<td><b>Song Title</b></td>
		<td><b>Album Name</b></td>
	</tr>

<?php
	foreach ($database as $dbLine)
	{
		$songInfo = explode("\\", $dbLine);
	?>
		<tr>
			<td><a href="#" onClick="javascript:openPage('addSong.php?file=<?php echo $songInfo[$FILENAME] ?>&metadata=<?php echo $songInfo[$ARTIST] ?>%5C%5C<?php echo $songInfo[$TITLE] ?>%5C%5C<?php echo $songInfo[$ALBUM] ?>');"><img src="images/add.png" /></a></td>
			<td><?php echo $songInfo[$ARTIST]; ?></td>
			<td><?php echo $songInfo[$TITLE]; ?></td>
			<td><?php echo $songInfo[$ALBUM]; ?></td>
		</tr>
	<?php
	}

?>
	</table>
<?php
?>
