<html>
<head>
<title>Enter Flags</title>
<style>
table.flag { padding: 10px; border-radius: 15px; background-color: #ffffff; border: 10px solid #0066ff; }
table.scoreboard { padding: 10px; border-radius: 15px; background-color: #ffffff; border: 10px solid #cccccc; }
</style>

</head>
<body bgcolor="#ffffff" style="font-family:Arial">


<!-- Import answers.php -->
<?php

include 'answers.php';
if (! isset($poss_chals) ) {
	print '<h3>Error: poss_chals not set in answers.php</h3>';
	exit;
}
$nposs_chals = count($poss_chals);

if (! isset($description) ) {
	print '<h3>Error: description not set in answers.php</h3>';
	exit;
}

$remove = '_';				# Challenge ID delimiter

?>



<!-- Print Header -->
<?php
$header  = $description;
$header .= "<h3 align='center'><a href='scoreboard.php?summary=1'>Scoreboard</a> &middot; ";
$header .= "<a href='scoreboard.php'>Details</a></h3>";
print $header;
?>


<!-- Flag Submission Form -->

<form action='grade.php' method='post'>
<blockquote>

<table align='center' class='flag'><tr><td colspan=2><h2 align='center'>Enter Flag</h2></td></tr>

<tr><td><big><b>Challenge:</b></big></td>
  <td>
   <select name='chalnum'>
   <?php 
   for( $j=0; $j<$nposs_chals; $j++ ) {
     $curr_chal = $poss_chals[$j];
     $cclean = str_replace($remove, "", $curr_chal);
     $mark = substr(strtolower($cclean),0,5);
     if ( ($mark != "break") && ($mark != "label") ) {
        print "<option value='$curr_chal'>$cclean</option>";
     }
   } ?>
</select> 
</td></tr>

<tr><td><big><b>Name:</b></big></td>
  <td><textarea name='name' rows='1' cols='25'></textarea></td></tr>
<tr><td><big><b>Flag:</b></big></td>
  <td><textarea name='answer' rows='1' cols='25'></textarea>  
  </td></tr>
<tr><td colspan=2 align='center'><big><b>
<input type='submit' value='Submit'>
</td></tr>
</table>

</blockquote>
</form>

<!--
<h2>Special Scoreboards</h2>

<b>
<a href="scoreboard.php?refresh=1&summary=1">Scoreboard that Refreshes</a><br>
<a href="scoreboard.php?showtest=1&summary=1">Scoreboard Including "TESTING"</a><br>
<a href="scoreboard.php?refresh=1">Detailed Scoreboard that Refreshes</a><br>
<a href="scoreboard.php?showtest=1">Detailed Scoreboard Including "TESTING"</a><br>
<p>
 -->
<p>

<form action='scoreboard_filtered.php' method='get'>
<blockquote>

<table align='center' class='scoreboard'>

<tr><td colspan=2 align="center"><h2>Special Scoreboards</h2></td></tr>

<tr><td><big><b>Challenge:</b></big></td>
  <td><input name='challenge' rows='1' cols='25'></textarea></td></tr>
  
<tr><td><big><b>Refresh:</b></big></td>
  <td><input type="checkbox" name="refresh" value="1">Refresh<br></td></tr>
  
<tr><td><big><b>Summary:</b></big></td>
  <td><input type="checkbox" name="summary" value="1">Summary<br></td></tr>

<tr><td><big><b>Testing:</b></big></td>
  <td><input type="checkbox" name="testing" value="1">Testing<br></td></tr>

<tr><td colspan=2 align='center'><big><b>
<input type='submit' value='View'>
</td></tr>
</table>

</blockquote>
</form>
<p>

<p>

<blockquote>
<table><tr><td>
<h2>Challenges</h2>

<h3>Geography</h3>

<b><big>1. What color is the sky?</big></b>
<p>
<b><big>2. When walking along a road, which directions can you go?  Choose from these options. (There are two possible correct answers.)
<ul>
<li>Forward
<li>Back
<li>Up
<li>Down
</ul>
</big></b>
<p>
<b><big>3. Pick a number between 1 and 10.</big></b>



<h3>Biology</h3>

<b><big>4. How many eyes does a human have?</big></b>

<p>

</td></tr></table></blockquote>

<p>


<P ALIGN="CENTER">
<b>
<a href="tail.php?count=20&refresh=1">Recent Scores</a><br><br>
<a href="admin.php">Administration console</a><br><br>
<a href="https://github.com/sambowne/lamectf">Get this scoring engine</a>

</b>
</p>


Updated 5-23-19<br>

</body>
</html>



