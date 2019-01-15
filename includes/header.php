<?php
echo "<html><head><title>$xrf_site_name Account</title>
<link rel=\"stylesheet\" type=\"text/css\" href=\"style.css\" />
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
$xrf_myusername
</p>
</td><td>
<p align=\"right\">
$navbox$sstatus
</p>
</td></tr></table>
</div>

<div class=\"container\" align=\"center\">";
?>