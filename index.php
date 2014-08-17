<html>
<head>
<link rel="stylesheet" type="text/css" href="s/semantic.min.css">
<style>
body{font-family: "Consolas", Times, serif;}
</style>
</head>

<body>
<table class="ui basic table">
  <thead>
    <tr>
      <th>Image</th>
      <th>Project</th>
      <th>Downloads</th>
      <th>Stage</th>
      <th>Latest approved File</th>
      <th>Latest comment</th>
    </tr>
  </thead>
  <tbody>
    <?php
$plugins = array("instances-minigamesapi", "mgarcade", "flyingcars-minigame", "warlock-minigame", "trapdoorspleef", "bowbash", "mglib-snake-challenge", "mglib-open-skywars", "mggungame", "mglib-conquer", "colormatch", "confirm-kill", "dragon-escape", "minigames-party", "skin-statue-builder", "horse-racing-plus", "sea-battle", "snake-minigame", "escape-mob");
//$plugins = array(0 => "colormatch", 1 => "confirm-kill", 2 => "dragon-escape", 3 => "minigames-party", 4 => "skin-statue-builder", 5 => "horse-racing-plus", 6 => "sea-battle", 7 => "snake-minigame", 8 => "escape-mob");

function connect($url){
	$ch = curl_init ($url);
	curl_setopt ($ch, CURLOPT_RETURNTRANSFER, true);
	return curl_exec ($ch);
}

$pre = 'http://dev.bukkit.org/bukkit-plugins/';

function buildPlugin($name, $data){
	$f = '<tr>';

	if (strpos($data,'class="warning-message"') !== false && strpos($data,'This project is awaiting approval.') !== false) {
		$f .= 'The project is not approved yet. </tr>';
		echo($f);
		return;
	}
	/*if (strpos($data,'class="warning-message"') !== false && strpos($data,'This project has no files.') !== false) {
		$f .= 'The project has no files yet, but it is approved! <3 <br></div>';
		echo($f);
		return;
	}*/
	
	$idownloads = strpos($data, 'data-value="');
	$istage = strpos($data, 'class="project-stage project-stage');
	$iimage = strpos($data, 'class="project-default-image');
	$ilatestfile = strpos($data, 'file-type');
	$icomment = strpos($data, 'class="comment-body"');
	
	// image
	if($iimage !== false){
		$f .= '<td>'.substr($data, $iimage + 30, strpos($data, '</a>', $iimage + 30) - ($iimage + 30).'</td>');
	}
	
	// name
	$f .= '<td>'.$name.'</td>';
	
	// downloads
	if($idownloads !== false){
		$f .= '<td>'.substr ($data, $idownloads + 12, strpos($data, '">', $idownloads + 12) - ($idownloads + 12)).'</td>';
	} else {
		$f .= '<td></td>';
	}
	
	// stage
	if($istage !== false){
		$f .= '<td>'.substr ($data, $istage + 38, strpos($data, '</span>', $istage + 38) - ($istage + 38)).'</td>';
	} else {
		$f .= '<td></td>';
	}
	
	// latest file
	if($ilatestfile !== false){
		$ahref = strpos($data, 'href=', $ilatestfile) - 3;
		$f .= '<td>'.substr ($data, $ahref, strpos($data, '</a>', $ahref) + 4 - $ahref).'</td>';
	} else {
		$f .= '<td></td>';
	}
	
	// latest comment
	if($icomment !== false){
		$f .= '<td>'.substr($data, $icomment + 21, strpos($data, '</div>', $icomment + 21) - $icomment + 21).'</td>';
	} else {
		$f .= '<td></td>';
	}

	$f .= '</tr>';
	echo($f);
}

$count = 0;
foreach ($plugins as &$plugin) {
    buildPlugin($plugins[$count], connect($pre.$plugins[$count]."/"));
	$count++;
}

?>
  </tbody>
</table>
<br>
</body>
</html>