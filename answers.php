<?php

$logfile = 'demo_scores.csv';
$xfile = 'demo_scoresx.csv';
$rightpass = "secret";

$description = "<h2 align='center'>Demo CTF</h2>";

$removes = array("A", "B" ); # text to remove from score labels

$poss_chals = array("LABEL_Category A", "_A1_", "_A2_", "_A3_", "BREAK",
					"LABEL_Category B", "_B1_", "_B2_", "_B3_", "BREAK",

);

$correct_answers = array(
  array( "_A1_", "blue", 5 ),
  array( "_A2_", "DOUBLE_forward_back", 5 ),
  array( "_A3_", "RANGE_1_10", 5 ),

  array( "_B1_", "blue", 5 ),
  array( "_B2_", "DOUBLE_forward_back", 5 ),
  array( "_B3_", "RANGE_1_10", 5 ),


); 

?>