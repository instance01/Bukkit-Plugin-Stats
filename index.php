<html>
<head>
<link href="../bukkitsnippets/pluginstatus/css/bootstrap.css" rel="stylesheet">
</head>

<body>
<?php
$plugins = array(0 => "colormatch", 1 => "confirm-kill", 2 => "dragon-escape", 3 => "minigames-party", 4 => "skin-statue-builder", 5 => "horse-racing-plus", 6 => "sea-battle", 7 => "snake-challenge", 8 => "escape-mob");

function connect($url){
	$ch = curl_init ($url);
	curl_setopt ($ch, CURLOPT_RETURNTRANSFER, true);
	return curl_exec ($ch);
}

$pre = 'http://dev.bukkit.org/bukkit-plugins/';

//print_r();

function buildPlugin($name, $data){
	$f = '<div class="well">';
	$f .= 'Info for '.$name.':<br>';
	
	if (strpos($data,'class="warning-message"') !== false && strpos($data,'This project is awaiting approval.') !== false) {
		$f .= 'The project is not approved yet. <br></div>';
		echo($f);
		return;
	}
	if (strpos($data,'class="warning-message"') !== false && strpos($data,'This project has no files.') !== false) {
		$f .= 'The project has no files yet, but it is approved! <3 <br>';
	}
	
	$i_ = strpos($data, 'data-value="');
	$i__ = strpos($data, 'class="project-stage project-stage');
	$i___ = strpos($data, 'class="project-default-image">');
	$f .= 'Downloads: '.substr ($data, $i_+12, strpos($data, '">', $i_+12) - ($i_+12)).'<br>';
	$f .= 'Stage: '.substr ($data, $i__+38, strpos($data, '">', $i__+39) - $i__).'<br>';
	$f .= substr($data, $i___ + 30, strpos($data, '>', $i___ + 31) - $i___ + 1);
	$f .= '</div>';
	echo($f);
}

$count = 0;
foreach ($plugins as &$plugin) {
    buildPlugin($plugins[$count], connect($pre.$plugins[$count]."/"));
	$count++;
}

?>

<br>
<script src="../bukkitsnippets/pluginstatus/js/bootstrap.js"></script>
</body>

</html>