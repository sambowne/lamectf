<?php

$verbose = 0;

function textile_sanitize($string){
    $whitelist = '/[^a-zA-Z0-9 \._-]/';
    return preg_replace($whitelist, '', $string);
}

$oldname = textile_sanitize($_REQUEST['oldname']);
$newname = textile_sanitize($_REQUEST['newname']);
$password = textile_sanitize($_REQUEST['password']);
$maxchanges = textile_sanitize($_REQUEST['maxchanges']);


print("Challenge: $chalnum <br>Your name: $name<br>Your answer: $answer<p>\n");

include 'answers.php';

if (! isset($logfile) ) {
	print" Error: logfile not set in answers.php";
	exit;
}

if (! isset($rightpass) ) {
	print" Error: rightpass not set in answers.php";
	exit;
}

if ($rightpass != $password ) {
	print" Error: Wrong password";
	exit;
}



$version = "1.00";







print "Reading $logfile<p>";

// Open the file to get existing content
$current = file_get_contents($logfile);
if ($verbose > 0) print "<pre>$current</pre>";
$array = str_getcsv ($current);
  
$csv = array_map('str_getcsv', file($logfile));
$numlines = count($csv);
if ($verbose > 1) print "<p>CSV contains $numlines lines.<p>\n";
  
if ($verbose > 1) print "<h2>CSV:</h2><pre>";
if ($verbose > 1) print_r($csv);
if ($verbose > 1) print "</pre>\n";

print "Found $numlines lines<p>";


$changes = 0;
$newlog = "";
for( $i = 0; $i<$numlines; $i++ ) { 
  if( $csv[$i][0] == $oldname )  {
  	print "Line $i contains $oldname; changing to $newname<br>";
  	$csv[$i][0] = $newname;
  	$changes += 1;
  }
  if( $csv[$i][0] != "" )  {
  $newlog .= $csv[$i][0] . "," . $csv[$i][1] . "," . $csv[$i][2] . "\n";
  }
}

print "Found $changes lines with $oldname<p>";

if ($changes > $maxchanges) {
	print "Too many changes! $changes <p>";
	exit;
}

print "Updating $logfile<p>";

// Write the contents back to the file
file_put_contents($logfile, $newlog);
# file_put_contents("foo", $newlog);



echo "<p><small>Version: $version</small></p>";
?>