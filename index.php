<html>
<head>
<title>Demo CTF</title>
<style>
table { padding: 10px; border-radius: 15px; background-color: "#ffffff"; border: 10px solid "#0066ff"; }
</style>

</head>
<body bgcolor="#ffffff" style="font-family:Arial">

<table><tr><td>x</td></tr></table>

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
?>



<!-- Print Header -->
<?php
$header  = $description;
$header .= "<h3 align='center'><a href='scoreboard.php'>Scoreboard</a></h3>";
print $header;
?>


<!-- Flag Submission Form -->

<form action='grade.php' method='post'>
<blockquote>

<table><tr><td><h3 align='center'>Enter flags below</h3></td></tr></table>

<tr><td><big><b>Challenge:</b></big></td>
  <td>
   <select name='chalnum'>
   <?php 
   for( $j=0; $j<$nposs_chals; $j++ ) {
     $curr_chal = $poss_chals[$j];
     print "<option value='$curr_chal'>$curr_chal</option>";
   } ?>
</select> 
</td></tr>

<tr><td><big><b>Name:</b></big></td>
  <td><textarea name='name' rows='1' cols='25'></textarea></td></tr>
<tr><td><big><b>Flag:</b></big></td>
  <td><textarea name='answer' rows='1' cols='25'></textarea>  
  </td></tr>
<tr><td colspan=2 align='center'><big><b>
<input type='submit' name='canvas' value='Submit'>
</td></tr>
</table>

</blockquote>
</form>


<p>

<blockquote>
<table><tr><td>
<h2>Challenges</h2>

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
<p>
</td></tr></table></blockquote>

<h2>Special Scoreboards</h2>

<b><a href="scoreboard.php?refresh=1">Scoreboard that Refreshes</a><br>
<a href="scoreboard.php?showtest=1">Scoreboard Including "TESTING"</a>
<p>


<hr>

Posted 5-18-19<br>

</body>
</html>



