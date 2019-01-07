<?php
$translations = [
	"en" => [ utf8_decode("Ended %a days, %H hours, and %i minutes ago.")      , utf8_decode("%a days, %H hours, and %i minutes left.")      ],
	"br" => [ utf8_decode("Finalizado h? %a dias, %H horas e %i minutos.")     , utf8_decode("%a dias, %H horas e %i minutos restantes.")    ],
	"es" => [ utf8_decode("Finalizó hace %a días, %H horas y %i minutos.")     , utf8_decode("Quedan %a días, %H horas y %i minutos.")       ],
	"fr" => [ utf8_decode("Termin? depuis %a jours, %H heures et %i minutes.") , utf8_decode("%a jours, %H heures et %i minutes restantes.") ],
	"pl" => [ utf8_decode("Zakonczono %a dni, %H godzin i %i minut temu.")     , utf8_decode("Pozostalo %a dni, %H godzin i %i minut.")      ]
];
$translation = (empty($_GET["lang"]) || empty($translations[$_GET["lang"]]))  ? $translations["en"] : $translations[$_GET["lang"]];

$now = new DateTime("now");
$final_date = date_create(empty($_GET["final"]) ? "2018-12-31 23:59:59" : $_GET["final"]);

$text = null;
if ($now > $final_date)
{
	$text = date_diff($final_date, $now) -> format($translation[0]);
	if (!empty($_GET["gt"]))
		$text = utf8_decode($_GET["gt"]) . $text;
}
else
{
	$text = date_diff($now, $final_date) -> format($translation[1]);
	if (!empty($_GET["lt"]))
		$text = utf8_decode($_GET["lt"]) . $text;
}

header("Content-Type: image/png");
$image = @imagecreate(strlen($text) * 10 + 10, 20) or die("Internal Error.");

imagecolortransparent($image, imagecolorallocate($image, 255, 255, 255));

imagestring($image, 5, 5, 5, $text, imagecolorallocate($image, 178, 178, 178));
imagepng($image);
imagedestroy($image);
?>