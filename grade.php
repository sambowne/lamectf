<?php

$verbose = 0;

function textile_sanitize($string){
    $whitelist = '/[^a-zA-Z0-9 \._-]/';
    return trim(preg_replace($whitelist, '', $string));
}

if ($_REQUEST == null){
  exit("<h1>NULL Request, invalid.</h1>");
}

$chalnum = textile_sanitize($_REQUEST['chalnum']);
$name = textile_sanitize($_REQUEST['name']);
$answer = textile_sanitize($_REQUEST['answer']);

if ((empty($chalnum)) or (empty($name)) or (empty($answer))){
  exit("<h1>Invalid input.</h1>");
}

print("Challenge: $chalnum <br>Your name: $name<br>Your answer: $answer<p>\n");

include 'answers.php';

if (! isset($logfile) ) {
	print" Error: logfile not set in answers.php";
	exit;
}



$version = "1.04";




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
if ($pos1 === false) {
  $double = false;
  if ($verbose > 0) { print "<p><small>Not a double answer</small></p>"; }
}
else {
   $double = true;
   // DOUBLE
   $pos1 = strpos($c, "_");
   $pos2 = strpos($c, "_", $pos1+1);
   $c1 = trim(substr($c, $pos1+1, $pos2-$pos1-1));
   $c2 = trim(substr($c, $pos2+1));
   if ($verbose > 0) { print "<p><small>pos1:$pos1 pos2:$pos2</small></p>"; }
   if ($verbose > 0) { print "<p><small>c1:$c1 c2:$c2</small></p>"; }

   $win = 0;
   if ($a == $c1) {
     $win = 1;
     if ($verbose > 0) { print "<p><small>WIN by matching first answer</small></p>"; }
   }

   if ($a == $c2) {
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
   $c1 = trim(substr($c, $pos1+1, $pos2-$pos1-1));
   $c2 = trim(substr($c, $pos2+1));
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
   if ($c == $a) { $win = 1; }
   else { $win = 0; }
   }



if ($win == 0) {
  echo "<h1>Answer incorrect!</h1>";
  echo "<h3>Click your browser's back button to try again.</h3>";
}
else {
  echo "<h1>Answer correct!</h1>";

  // Prepare the new entry for the file
  $current = "$name,$chalnum,$pts\n";

  // Append the new entry to the file.
  if (file_put_contents($logfile, $current, FILE_APPEND | LOCK_EX)){
    echo "<h3>Answer recorded.</h3>";
  }
  else {
    exit("Answer not recorded, try again.");
  }
}

// V 1.01 allows DOUBLE: answers
// v 1.02 alloes RANGE: answers
// v 1.03 gets logfile name from answers.php
// v 1.04 fix dictionary attack vulnerability and race condition and null input


echo "<p><small>Version: $version</small></p>";
?>
