<html>
<head>
<link href="css/bootstrap.css" rel="stylesheet">
</head>

<body>
<?php
$plugins = array("instances-minigamesapi", "mgarcade", "flyingcars-minigame", "warlock-minigame", "trapdoorspleef", "bowbash", "mglib-snake-challenge", "mglib-open-skywars", "mggungame", "mglib-conquer", "colormatch", "confirm-kill", "dragon-escape", "minigames-party", "skin-statue-builder", "horse-racing-plus", "sea-battle", "snake-minigame", "escape-mob");
//$plugins = array(0 => "colormatch", 1 => "confirm-kill", 2 => "dragon-escape", 3 => "minigames-party", 4 => "skin-statue-builder", 5 => "horse-racing-plus", 6 => "sea-battle", 7 => "snake-minigame", 8 => "escape-mob");

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
	/*if (strpos($data,'class="warning-message"') !== false && strpos($data,'This project has no files.') !== false) {
		$f .= 'The project has no files yet, but it is approved! <3 <br></div>';
		echo($f);
		return;
	}*/
	
	$i_ = strpos($data, 'data-value="');
	$i__ = strpos($data, 'class="project-stage project-stage');
	$i___ = strpos($data, 'class="project-default-image');
	$ilatestfile = strpos($data, 'file-type');
	$icomment = strpos($data, 'class="comment-body"');
	
	if($i_ !== false){
		$f .= 'Downloads: '.substr ($data, $i_+12, strpos($data, '">', $i_+12) - ($i_+12)).'<br>';
	}
	if($i__ !== false){
		$f .= 'Stage: '.substr ($data, $i__+38, strpos($data, '</span>', $i__+38) - ($i__ + 38)).'<br>';
	}
	if($ilatestfile !== false){
		$ahref = strpos($data, 'href=', $ilatestfile) - 3;
		$f .= 'Latest approved file: '.substr ($data, $ahref, strpos($data, '</a>', $ahref) + 4 - $ahref).'<br>';
	}
	if($i___ !== false){
		$f .= substr($data, $i___ + 30, strpos($data, '</a>', $i___ + 30) - ($i___ + 30).'<br>');
	}
	if($icomment !== false){
		$f .= '<div class="well">Last Comment: '.substr($data, $icomment + 21, strpos($data, '</div>', $icomment + 21) - $icomment + 21).'</div>';
	}

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
<script src="js/bootstrap.js"></script>
</body>

</html>