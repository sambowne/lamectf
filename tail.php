<?php

$verbose = 0;

function textile_sanitize($string){
    $whitelist = '/[^a-zA-Z0-9 \._-]/';
    return preg_replace($whitelist, '', $string);
}

$count = textile_sanitize($_REQUEST['count']);


# Check refresh parameter
if (isset($_GET["refresh"])) { 
	$refresh = "<meta http-equiv='refresh' content='5'>"; 
	}
else { $refresh = ""; }



include 'answers.php';

if (! isset($logfile) ) {
	print" Error: logfile not set in answers.php";
	exit;
}


$version = "1.00";




$header = "<html><head><title>Scoreboard</title>";

$header .= "<style>";
$header .= "th, td { border-bottom: 1px solid $bottom_border_color;";
$header .= " margin: 0 10 0px; padding: 0 10 0px; vertical-align: middle; }";

$header .= "td.solved { background-clip: padding-box; padding: 6px; ";
$header .= "border-radius: 13px; background-color: $solved_color; ";
$header .= "border: 5px solid $solved_color_border; ";
$header .= "text-align: center; font-size: 0.7em; ";
$header .= "font-weight: 900; }";

$header .= "td.unsolved { background-clip: padding-box; padding: 6px; ";
$header .= "border-radius: 13px; background-color: $unsolved_color;";
$header .= "border: 5px solid $unsolved_color_border; ";
$header .= "text-align: center; font-size: 0.7em; ";
$header .= "font-weight: bold; }";

$header .= "td.label { border: 0px solid $unsolved_color_border; ";


$header .= "</style>";

$header .= $refresh;

$header .= "</head>";

$header .= "<body bgcolor='#ffffff'  style='font-family:Arial'>";

print $header;


$solved_prefix = "<td class='solved'><font color='$solved_font_color'>&nbsp;";
$solved_suffix = "&nbsp;</font></td>";

$unsolved_prefix = "<td class='unsolved'><font color='$unsolved_font_color'>&nbsp;";
$unsolved_suffix ="&nbsp;</font></td>";

$label_prefix = "<td class='label'><b>&nbsp;";
$label_suffix = "&nbsp;</b></td>";

print "<table style='border: $border_width solid $border_color; ";
print "border-radius: 15px; ' ";
print "cellpadding=0 cellspacing=0 border=0 align='center'> ";



# print "Reading $logfile<p>";

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

# print "Found $numlines lines<p>";

for( $i = $numlines-$count; $i<$numlines; $i++ ) { 
	$n = "<td align='center'><b><big>&nbsp;" . $csv[$i][0] . "&nbsp;</big></b></td>";
	$s = "<td align='center'><b>&nbsp;&nbsp;&nbsp;" . (string) $csv[$i][1] . "&nbsp;&nbsp;&nbsp;</b></td>";
  	print "<tr>" . $n . $s . "</tr>\n";
}


print "</td></tr></table>";


print "</body></html>\n";


echo "<p><small>Version: $version</small></p>";
?>