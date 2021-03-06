<?php
	require_once('variables/variables.php');
	
	if(0 == filesize($NowPlayingFile))
	{
		?>
			<br /><br /><br /><br /><br />
			<center><font size="6px" face="Arial"><b>Oops!</b></font></center><br />
			<center><img src="images/jim.png" /></center><br />
			<center><font size="4px" face="Arial">The QueueBot Server is either <b>not running</b><br />or both of the Queues are <b>Empty</b>!</font></center>
		<?php
			echo '<meta http-equiv="refresh" content="'.$IndexRefreshTime.'">';
			die();
	} 
?>

<body bgcolor="#F0F0F0" link="#666666" alink="#666666" vlink="#666666">

<script language="JavaScript">
	function search()
	{
		Query = window.prompt("What are you looking for?", "");
		if(Query)
			window.open('searchSong.php?search=' + Query);
	}
	function focusAndGo(URL)
	{
		window.focus();
		window.location.href = URL;
	}
</script>

<table border="0">
	<tr>
		<td style="vertical-align:middle;">
			<a href="javascript:search();" style="text-decoration:none;">
				<img src="images/search.png" />
			</a>
		</td>
		<td style="vertical-align:middle;">
			<a href="javascript:search();" style="text-decoration:none;">
				<font face="Arial" size="6">Search Songs</font>
			</a>
		</td>
	</tr>
</table>

<br />

<?php
	$nowPlayingList = file($NowPlayingFile);
	$database = file($QBMusicDatabase);
?>

<!--                  -->
<!-- Now Playing Song -->
<!--                  -->
<font face="Arial" size="6">Now Playing</font>
<table border="0">

<?php
	$index = 0;
	foreach ($nowPlayingList as $song)
	{
		$songInfo = explode("\\\\", $song);
		
		if($index == 0)
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
			<a href="vetoSong.php?songID=<?php echo $songInfo[$NPID]; ?>" target="_blank"><img src="images/veto.png" /></a><br />
			<center><font color="<?php echo $vetoColor; ?>"><b><?php echo $veto[0]; ?>/<?php echo $veto[1]; ?></b></font></center>
		</td>
		<td>
			<table border="0">
				<tr><td><b><?php echo $songInfo[$NPARTIST]; ?></b></td></tr>
				<tr><td><?php echo $songInfo[$NPTITLE]; ?></td></tr>
				<tr><td><i><?php echo $songInfo[$NPALBUM]; ?></i></td></tr>
			</table>
		</td>
	</tr>
</table>
		
<!--                  -->
<!-- Queued Song List -->
<!--                  -->
<?php
		}
		else
		{
			if($index == 1)
			{
				?>
				<font face="Arial" size="6">Queued Up</font>
				<table border="0">
				<?php
			}
			$UPVOTED = false;
			$DOWNVOTED = false;
			$UPIMG = "aupgray.gif";
			$DOWNIMG = "adowngray.gif";
			$voteColor = $REDDITNEU;
			$VOTENUM = $songInfo[$QRATING];
			$cookie = $songInfo[$QID]."UP";
			if(isset($_COOKIE[$cookie]))
			{
				$UPVOTED = true;
				$UPIMG = "aupmod.gif";
				$voteColor = $REDDITUP;
			}
			$cookie = $songInfo[$QID]."DOWN";
			if(isset($_COOKIE[$cookie]))
			{
				$DOWNVOTED = true;
				$DOWNIMG = "adownmod.gif";
				$voteColor = $REDDITDOWN;
			}
			if($VOTENUM == 0)
				$VOTENUM = "&bull;";

			$UPURL = '<a href="changeVote.php?songID='.$songInfo[$QID].'&direction=UP" target="_blank">';
			$DOWNURL = '<a href="changeVote.php?songID='.$songInfo[$QID].'&direction=DOWN" target="_blank">';
?>
	<tr>
		<td>
			<table border="0" align="center">
				<tr><td align="center"><?php echo $UPURL; ?><img src="images/<?php echo $UPIMG; ?>" /></a></td></td>
				<tr><td align="center"><font face="Arial" color="<?php echo $voteColor ?>" <?php if($VOTENUM == "&bull;") { echo 'size="4px"'; } else { echo 'size="3px"'; } ?>><b><?php echo $VOTENUM; ?></b></font></td></tr>
				<tr><td align="center"><?php echo $DOWNURL; ?><img src="images/<?php echo $DOWNIMG; ?>" /></a></td></td>
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

	echo '<meta http-equiv="refresh" content="'.$IndexRefreshTime.'">';
?>
</table>
