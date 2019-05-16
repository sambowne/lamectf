<?php



$verbose = 0;

include 'poss_chals.php';
if (! isset($logfile) {
	print" Error: logfile not set in answers.php":
	exit;
}
if (! isset($xfile) {
	print" Error: xfile not set in answers.php":
	exit;
}


$header = "<html><head><title>Submit Answers</title>";
$header .= "</head>";
$header .= "<body bgcolor='#ffffff'  style='font-family:Arial'>";
$header .= <h2>Submit Answers</h2>;
$header .= "<table style='border: $border_width solid $border_color; ";
$header .= "border-radius: 15px; ' ";
$header .= "cellpadding=0 cellspacing=0 border=0 align='center'> ";

print $header';
print "<blockquote>";
print "<table cellpadding=10 border=10 width='800px'><tr><td align='center'>";
print "<big><b>Enter flags below</b></big><p>";

print "<form action='grade.php' method='post'>";

print "<table cellpadding=5>";

print "<tr><td><big><b>Challenge:</b></big></td>";
print "  <td>";
print "   <select name='chalnum'>";

for $c in $poss_chals {
  print "<option value="$c">$c</option>";
}

print "</select> ";
print "</td></tr>";




print "<tr><td><big><b>Name:</b></big></td>";
print "  <td><textarea name="name" rows="1" cols="25"></textarea></td></tr>";
print "<tr><td><big><b>Flag:</b></big></td>";
print "  <td><textarea name="answer" rows="1" cols="25"></textarea>  ";
print "  </td></tr>";
print "<tr><td colspan=2 align="center"><big><b>";
print "<input type="submit" name="canvas" value="Submit">";
print "</td></tr>";
print "</table>";

print "</form>";

print "</td></tr></table>";

print "</blockquote>";





?>