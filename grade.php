<?php

$verbose = 0;

function textile_sanitize($string){
    $whitelist = '/[^a-zA-Z0-9 \._-]/';
    return preg_replace($whitelist, '', $string);
}

$chalnum = textile_sanitize($_REQUEST['chalnum']);
$name = textile_sanitize($_REQUEST['name']);
$answer = textile_sanitize($_REQUEST['answer']);


print("Challenge: $chalnum <br>Your name: $name<br>Your answer: $answer<p>\n");

include 'answers.php';

if (! isset($logfile) ) {
	print" Error: logfile not set in answers.php":
	exit;
}



$version = "1.02";




// FIND CHALLENGE, IF POSSIBLE
$found = 0;
foreach ($correct_answers as $ca) {
  $pchal = $ca[0];
  $pcorrect = $ca[1];
  if ($verbose > 1) {
    print "Comparing to Chal $pchal Correct: <b>$pcorrect</b><br>";
  }
  
  if ($pchal == $chalnum) {
    $correct = $ca[1];
    $pts = $ca[2];
    $found = 1;
    if ($verbose > 1) {
      print "Challenge found! $pchal Correct: <b>$correct</b> for $pts<br>";
    }
  }
  	
}

if ($found = 0) {
  exit("<h2>ERROR: Challenge Not Found--Check answers.php/h2>");
}












// $correct = "foo";

$a = strtolower($answer);
$c = strtolower($correct);

if ($verbose > 0){ print "<p><small>A:$a C:$c</small></p>"; }


// CHECK FOR DOUBLE ANSWER, like DOUBLE_left_right

$pos1 = strpos($c, "double_");
if ($pos1 === false) { $double = false; }
else { 
   $double = true; 
   // DOUBLE
   $pos1 = strpos($c, "_");
   $pos2 = strpos($c, "_", $pos1+1);
   $c1 = substr($c, $pos1+1, $pos2-$pos1-1);
   $c2 = substr($c, $pos2+1);
   if ($verbose > 0) { print "<p><small>pos1:$pos1 pos2:$pos2</small></p>"; }
   if ($verbose > 0) { print "<p><small>c1:$c1 c2:$c2</small></p>"; }
   
   $win = 0;
   $pos = strpos($a, $c1);
   if ($pos === false) {  }
   else { 
   	   $win = 1; 
   	   if ($verbose > 0) { print "<p><small>WIN by matching first answer</small></p>"; }
   	   }
   
   $pos = strpos($a, $c2);
   if ($pos === false) {  }
   else { 
   	   $win = 1; 
   	   if ($verbose > 0) { print "<p><small>WIN by matching second answer</small></p>"; }
   	   }
   
   }
   
// CHECK FOR RANGE ANSWER, like RANGE_1_4

$pos1 = strpos($c, "range_");
if ($pos1 === false) { 
	$range = false; 
  	if ($verbose > 0) { print "<p><small>Not a range answer</small></p>"; }
	}
else { 
  // RANGE
   $range = true; 
   if ($verbose > 0) { print "<p><small>This is a range answer!</small></p>"; }
   $pos1 = strpos($c, "_");
   $pos2 = strpos($c, "_", $pos1+1);
   $c1 = substr($c, $pos1+1, $pos2-$pos1-1);
   $c2 = substr($c, $pos2+1);
   if ($verbose > 0) { print "<p><small>pos1:$pos1 pos2:$pos2</small></p>"; }
   if ($verbose > 0) { print "<p><small>c1:$c1 c2:$c2</small></p>"; }
   if ($verbose > 0) { 
   	print "<p>Intvals: ";
   	print intval($c);
   	print intval($c1);
   	print intval($c2); }
   
   $win = 0;
   if ( (intval($a) >= intval($c1)) and (intval($a) <= intval($c2)) ) {
   	   $win = 1; 
   	   if ($verbose > 0) { print "<p><small>WIN because $a is between $c1 and $c2</small></p>"; }
   	   }
   }
 
if ( (! $double) and (! $range) ) {
   $pos = strpos($a, $c);
   if ($pos === false) { $win = 0; }
   else { $win = 1; }
   }



// $pos = strpos($a, $c);

if ($win == 0)
   {
  echo "<h1>Answer incorrect!</h1>";
  echo "<h3>Click your browser's back button to try again.</a></h3>";
  }
else  {
  echo "<h1>Answer correct!</h1>";

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
  
  if ($verbose > 0) {
    for( $i = 0; $i<$numlines; $i++ ) { 
      print "<b>Log line $i:</b> ". $csv[$i][0] . " " . $csv[$i][1] . " " . $csv[$i][2] . "<br>\n";
    }
  }
  

 
  // Append a new line to the file
  $current .= "$name,$chalnum,$pts\n";

  // Write the contents back to the file
  file_put_contents($logfile, $current);
}

// V 1.01 allows DOUBLE: answers
// v 1.02 alloes RANGE: answers
// v 1.03 gets logfile name from answers.php


echo "<p><small>Version: $version</small></p>";
?>