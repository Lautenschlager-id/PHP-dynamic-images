<?php
$now = new DateTime("now");
$final_date = date_create(empty($_GET["final"]) ? "2018-12-31 23:59:59" : $_GET["final"]);

$text = null;
if ($now > $final_date)
	$text = date_diff($final_date, $now) -> format("Ended %a days, %H hours, and %i minutes ago.");
else
	$text = date_diff($now, $final_date) -> format("%a days, %H hours, and %i minutes left.");

header("Content-Type: image/png");
$image = @imagecreate(strlen($text) * 10 + 10, 20) or die("Internal Error.");

imagecolortransparent($image, imagecolorallocate($image, 255, 255, 255));

imagestring($image, 5, 5, 5, $text, imagecolorallocate($image, 178, 178, 178));
imagepng($image);
imagedestroy($image);
?>