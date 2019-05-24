<html>
<head>
<title>Admin Console</title>
<style>
table { padding: 10px; border-radius: 15px; background-color: #ffffff; border: 10px solid #0066ff; }
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



<form action='clean.php' method='post'>
<blockquote>

<table align='center'><tr><td><h3 align='center'>Enter flags below</h3></td></tr>

<tr><td colspan=2 align="center"><h2>Change Name</h2></td></tr>

<tr><td><big><b>Old Name:</b></big></td>
  <td><textarea name='oldname' rows='1' cols='25'></textarea></td></tr>
<tr><td><big><b>New Name:</b></big></td>
  <td><textarea name='newname' rows='1' cols='25'></textarea></td></tr>
<tr><td><big><b>Max Changes:</b></big></td>
  <td><textarea name='maxchanges' rows='1' cols='25' value="3"></textarea></td></tr>
<tr><td><big><b>Password:</b></big></td>
  <td><input name='password' rows='1' cols='25' type="password"></textarea>  
  </td></tr>
<tr><td colspan=2 align='center'><big><b>
<input type='submit' name='canvas' value='Submit'>
</td></tr>
</table>

</blockquote>
</form>


<hr>

Updated 5-21-19<br>

</body>
</html>



