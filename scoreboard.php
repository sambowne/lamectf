<?php

# THIS SECTION CAN BE CUSTOMIZED FOR EACH CTF

$title = "<h1 align='center'>Splunk Threat Hunting CTF</h1>\n";
$title .= "<h2 align='center'><a href='https://www.meetup.com/pacifichackers/?_xtd=gqFyqTE5OTAxMDkyNaFwp2FuZHJvaWQ&from=ref'>Pacific Hackers Meetup</a></h2>\n";
$title .= "<h3 align='center'>Sunnyvale, CA &middot; May 11, 2019</h3>\n";

# THIS SECTION CHANGES THE LOOK OF THE SCOREBOARD

$version="2.01";

#$border_color = "#efdcff";
$border_color = "#D783FF";
$border_width = "10px";

$bottom_border_color = "#dfccff";

#$solved_color = "#00ff00";
$solved_color = "#ffffff";
$solved_color_border = "#D783FF";

$unsolved_color = "#ffffff";
$unsolved_color_border = "#666666";
# $unsolved_color = "#ff0000";

$solved_font_color = "#000000";
$unsolved_font_color = "#000000";
# $unsolved_font_color = "#ffffff";


# Check refresh parameter
if (isset($_GET["refresh"])) { 
	$refresh = "<meta http-equiv='refresh' content='5'>"; 
	}
else { $refresh = ""; }


$header = "<html><head><title>Scoreboard</title>";

$header .= "<style>";
$header .= "th, td { border-bottom: 1px solid $bottom_border_color;";
$header .= " margin: 0 10 0px; padding: 0 10 0px;}";

$header .= "td.solved { background-clip: padding-box; padding: 4px; ";
$header .= "border-radius: 13px; background-color: $solved_color; ";
$header .= "border: 4px solid $solved_color_border; ";
$header .= "text-align: center; font-size: 0.7em; ";
$header .= "font-weight: 900; }";

$header .= "td.unsolved { background-clip: padding-box; padding: 7px; ";
$header .= "border-radius: 13px; background-color: $unsolved_color;";
$header .= "border: 1px solid $unsolved_color_border; ";
$header .= "text-align: center; font-size: 0.7em; ";
$header .= "font-weight: bold; }";

$header .= "</style>";

$header .= $refresh;

$header .= "</head>";

$header .= "<body bgcolor='#ffffff'  style='font-family:Arial'>";
$header .= $title;
$header .= "<table style='border: $border_width solid $border_color; ";
$header .= "border-radius: 15px; ' ";

$header .= "cellpadding=0 cellspacing=0 border=0 align='center'> ";

$solved_prefix = "<td class='solved'><font color='$solved_font_color'>&nbsp;";

$solved_suffix ="&nbsp;</font></td>";

# $unsolved_prefix = "<td bgcolor='$unsolved_color' align='center'><font color='$unsolved_font_color'><b>&nbsp;";
$unsolved_prefix = "<td  class='unsolved'><font color='$unsolved_font_color'>&nbsp;";

$unsolved_suffix ="&nbsp;</font></td>";



# DO NOT CHANGE ANTHING BELOW THIS LINE

$verbose = 2;

include 'answers.php';
if (! isset($logfile) ) {
	print" Error: logfile not set in answers.php";
	exit;
}
if (! isset($xfile) ) {
	print" Error: xfile not set in answers.php";
	exit;
}

$remove = '_';					    # Challenge ID delimiter
$break_mark = "BREAK";		# In poss_chals;
$max_row_length = 20;		# includes break marks


include 'poss_chals.php';
$nposs_chals = count($poss_chals);

if ($verbose>1) {
	print "<p>Nposs_chals: $poss_chals:<br>";
	print_r($poss_chals);
	print "<p>";
}


# Check skipsam parameter
if (! isset($_GET["skipsam"])) { $skipsam = 1; }
else { $skipsam = 0; }



# OUTPUT HEADER

print $header;


# READ SCORE LOGS  
$csv = array_map('str_getcsv', file($logfile));
$csvx = array_map('str_getcsv', file($xfile));
$csv = array_merge($csv, $csvx);

$numlines = count($csv);
$numlinesx = count($csvx);

if ($verbose > 1) print "<p>CSV contains $numlines lines.<p>\n";
  
if ($verbose > 1) print "<h2>CSV:</h2><pre>";
if ($verbose > 1) print_r($csv);
if ($verbose > 1) print "</pre>\n";
  
if ($verbose > 1) {
  for( $i = 0; $i<$numlines; $i++ ) { 
    if ( isset($csv[$i][0]) && isset($csv[$i][1]) && isset($csv[$i][2]) ){
  
      print "<b>Log line $i:</b> ". $csv[$i][0] . " " . $csv[$i][1] . " " . $csv[$i][2] . "<br>\n";
    }
  }
}


# Accumulate Scores
$winners = array();
$chals = array();
$unsolved_chals = array();
$scores = array();

for( $i = 0; $i<$numlines; $i++ ) { 
  if ( isset($csv[$i][0]) && isset($csv[$i][1]) && isset($csv[$i][2]) ){
    if ( strlen($csv[$i][0]) >0 && strlen($csv[$i][1]) >0 && strlen($csv[$i][2]) >0 ){
      $w = $csv[$i][0];
      $c = $csv[$i][1];
      $s = $csv[$i][2];

      if ($verbose>1) print "Processing log line $i: $w $c $s<br>\n";

      if ( (($skipsam >0) and ($w == "SAM-TESTING")) || ($w == "") ) {
        if ($verbose>1) print "Skipping SAM<br>\n";
      } else {
        if (in_array($w, $winners)) {
          $key = array_search($w, $winners); 
          if ($verbose>1) print "Name already in winners list at index $key!<br>\n";
          $cold = $chals[$key];
          $sold = $scores[$key];
          if ($verbose>1) print "Old chals = $cold Old score = $sold<br>\n";
          $pos = strpos($cold, $c);
          if ($pos === false) {
            if ($verbose>1) print "New data; appending it to results<br>\n";
            $chals[$key] = $chals[$key] . " " . $c;
            $scores[$key] = $scores[$key] + $s;
          }
          else {
            if ($verbose>1) print "Duplicate data; ignoring it<br>\n";
          }
        }   
        else {
          if ($verbose>1) print "Name is new!  Adding it to winners list!<br>\n";
          array_push($winners, $w);
          array_push($chals, $c);
          array_push($scores, $s);
        }
      }
    }
  }
}

$numwinners = count($winners);






# Build output strings
$outlines = array();

for( $i = 0; $i<$numwinners; $i++ ) { 
  $ci = $chals[$i];
  $chal_list = "";
  $chal_count = 0;
  for( $j=0; $j<$nposs_chals; $j++ ) {
  	$curr_chal = $poss_chals[$j];
    if ($verbose>1) { print "<p>i, j, ci: $i $j $ci<p>"; }
    
   	$pos = strpos($ci, $curr_chal);
    if ($pos === false) { 						# UNSOLVED
    	$cell_prefix = $unsolved_prefix;
    	$cell_suffix = $unsolved_suffix;
    	
    	# $boxcolor = $unsolved_color; 
    	# $fontcolor = $unsolved_font_color; 
    	} 
    else { 										# SOLVED
    	$cell_prefix = $solved_prefix;
    	$cell_suffix = $solved_suffix;
    	
    	# $boxcolor = $solved_color; 
    	# $fontcolor = $solved_font_color; 
    	}
    
    $cclean = str_replace($remove, "", $curr_chal);
    if ($verbose>1) { print "Cell: $i $j $boxcolor<br>"; }
    
	# ROW TOO LONG
    if (($chal_count+1) % $max_row_length == 0) { 
    	$chal_list .= "</tr><tr>"; 
    	$chal_count = -1;
    	}

	# BREAK MARK FOUND
    if ($curr_chal == $break_mark) { 
    	$chal_list .= "</tr><tr>"; 
    	$chal_count = -1;
    	}
    else {		# Add non-break challenge numbers to list
	    $chal_list .= "$cell_prefix$cclean$cell_suffix";
    }
    

    $chal_count += 1;
  }
  $chal_list .= "</tr>\n";
  if ($verbose>1) { print "\n<h2>$i $chal_list</h2>\n"; }
  
  # Add Kahoot Markers
  for( $j=0; $j<$numlinesx; $j++ ) {
  	$namex = $csvx[$j][0];
  	$labelx = $csvx[$j][1];
  	$ptsx = $csvx[$j][2];

  	if ($namex === $winners[$i]) {
        $lclean = str_replace("_", ":", $labelx);
  		$lclean .= strval($ptsx);
      $chal_list .= "$solved_prefix$lclean$solved_suffix";
  	}  		
  }


  $sort = (string) ($scores[$i] + 10000);
  $n = "<td align='center'><b><big>&nbsp;" . $winners[$i] . "&nbsp;</big></b></td>";
  $s = "<td align='center'><b>&nbsp;&nbsp;&nbsp;" . (string) $scores[$i] . "&nbsp;&nbsp;&nbsp;</b></td>";
  $c =  "<td><table cellspacing=5 border=0><tr>$chal_list</tr></table></td>";
  array_push($outlines, ($sort . $n . $s . $c));
}

rsort($outlines);


# DIAGNOSTIC OUTPUT
if ($verbose > 2) {
  print "<h2>Outlines</h2>";
  for( $i = 0; $i<$numwinners; $i++ ) { 
  	  $cdiag = str_replace("<", "!", $outlines[$i]);
    print $cdiag;
    print "<br>";
  }
}  

# DIAGNOSTIC OUTPUT
if ($verbose > 2) {
  print "<h2>Winners</h2><pre>";
  print_r($winners);
  print "</pre>";
  
  print "<h2>Chals</h2><pre>";
  print_r($chals);
  print "</pre>";
  
  print "<h2>Scores</h2><pre>";
  print_r($scores);
  print "</pre>";  
}  


# Print scores

for( $i = 0; $i<$numwinners; $i++ ) { 
	print "<tr><td align='center'>&nbsp;&nbsp;" . (string)($i+1) . "</td>";
  	print substr($outlines[$i], 5);
  

}



print "</td></tr></table>";
print "<p>Version: $version <p>";

print "</body></html>\n";



# v1.01 removed 'EH1." from challenges string
# v1.02 requires auth parameter
# v1.03 adds column headers
# v1.04 removes "EH", added authorization
# v1.05 removed auth token, moved to content server, implemented skipsam as a parameter, 
#       implmented _ terminators
# v1.06 added extra credit xfile
# v1.07 removes "A" from chalnum
# v 1.08 sorts "Challenges Solved" list and uses small tags
# v 1.09 shows challenges remaining
# v 1.10 gathers challenges, separates leaders, skips blank names
# v 1.11 labels Solved and unsolved
# v 1.12 better sorting
# v 1.13 labels kahoots
# v 1.14 string to remove placed in $remove
# v 2.00 moved formatting to strings at top, added rank #
# v 2.01 reads xfile and logfile from answers.php


?>