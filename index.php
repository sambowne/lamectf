<html>
<head>
<title>Demo CTF</title>
</head>
<body bgcolor="#ffffff" style="font-family:Arial">


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



$verbose = 1;

$border_width = "5";
$border_color = "blue";

$header  = $description;

$header .= "<h3 align='center'><a href='scoreboard.php'>Scoreboard</a></h3>";

# $header .= "<table style='border: $border_width solid $border_color; ";
# $header .= "border-radius: 15px; ' ";
# $header .= "cellpadding=0 cellspacing=0 align='center'> ";

print $header;
print "<blockquote>";
print "<table style='border: $border_width solid $border_color; ";
print "border-radius: 15px; '"; 
print "cellpadding=10 border=10 width='800px'><tr><td align='center'>";
print "<big><b>Enter flags below</b></big><p>";

print "<form action='grade.php' method='post'>";

print "<table cellpadding=5>";

print "<tr><td><big><b>Challenge:</b></big></td>";
print "  <td>";
print "   <select name='chalnum'>";

for( $j=0; $j<$nposs_chals; $j++ ) {
  $curr_chal = $poss_chals[$j];
  print "<option value='$curr_chal'>$curr_chal</option>";
}

print "</select> ";
print "</td></tr>";




print "<tr><td><big><b>Name:</b></big></td>";
print "  <td><textarea name='name' rows='1' cols='25'></textarea></td></tr>";
print "<tr><td><big><b>Flag:</b></big></td>";
print "  <td><textarea name='answer' rows='1' cols='25'></textarea>  ";
print "  </td></tr>";
print "<tr><td colspan=2 align='center'><big><b>";
print "<input type='submit' name='canvas' value='Submit'>";
print "</td></tr>";
print "</table>";

print "</form>";

print "</td></tr></table>";

print "</blockquote>";


?>


<blockquote>
<table cellpadding=10 border=5><tr><td>
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



