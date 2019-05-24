<?php

$verbose = 0;

function textile_sanitize($string){
    $whitelist = '/[^a-zA-Z0-9 \._-]/';
    return preg_replace($whitelist, '', $string);
}

if (isset($_GET["challenge"])) { 
	$challenge = textile_sanitize($_REQUEST['challenge']); 
	}
else { $challenge = ""; }

if (isset($_GET["refresh"])) { 
	$refresh = textile_sanitize($_REQUEST['refresh']); 
	}
else { $refresh = ""; }

if (isset($_GET["summary"])) { 
	$summary = textile_sanitize($_REQUEST['summary']); 
	}
else { $summary = ""; }

if (isset($_GET["testing"])) { 
	$testing = textile_sanitize($_REQUEST['testing']); 
	}
else { $testing = ""; }

# print "Calling with refresh=$refresh<br>challenge=$challenge<br>summary=$summary<br>";

$url = "scoreboard.php?";

if ($summary != "") { $url .= "summary=" . $summary . "&"; }
if ($refresh != "") { $url .= "refresh=" . $refresh . "&"; }
if ($challenge != "") { $url .= "challenge=" . $challenge . "&"; }
if ($testing != "") { $url .= "showtest=" . $testing . "&"; }

# print "URL: $url<br>";

header("Location: $url");
die();
?>
