<?php
header('Content-Type: text/html; charset=iso-8859-15');
if ($xrf_mystylepref == "") {$xrf_style = $xrf_style_default;}
else {$xrf_style = $xrf_mystylepref;}
echo "<html><head><title>$xrf_site_name Account</title>
<link rel=\"stylesheet\" type=\"text/css\" href=\"styles/$xrf_style/style.css\" />
<link rel=\"stylesheet\" type=\"text/css\" href=\"styles/print/style.css\" media=\"print\" />
</head><body>";

if ($xrf_myid != 0)
{
	$navbox = "<a href=\"index.php\">Home</a> - <a href=\"logout.php\">Log out</a><br>";
	if ($xrf_myulevel == 0)
		$sstatus = "<font color=\"red\"><b>Banned</b></font>";
	if ($xrf_myulevel == 1)
		$sstatus = "<font color=\"red\"><b>Not Activated</b></font>";
}

echo "<div class=\"header\" align=\"center\">
<table width=\"100%\"><tr><td>
<p align=\"left\">
<font size=\"6\">$xrf_site_name Account</font><br>
<span class=\"navigation-box\">$xrf_myusername</span>
</p>
</td><td>
<p align=\"right\" class=\"navigation-box\">
$navbox$sstatus
</p>
</td></tr></table>
</div>

<div class=\"container\" align=\"center\">";
?>