<?php
// Paul Barett
$NOBELPHYSICS = "./Nobel_physics.json";
echo "Hello world!\n";

$line = readline("search for: ");
echo "$line";

function readGivenJson($filename){
	if(file_exists($filename)){
		$jsoncontents = file_get_contents($filename);
		$decodedjson = json_decode($jsoncontents);
		
		$subjson = '';
		foreach ($decodedjson->prizes as $key => $value) {
			foreach($value as $subkey => $subvalue){
				echo "$subkey\n";
			}
		}

		/*foreach ($decodedjson[$subjson] as $subkey => $subvalue) {
			echo "$subkey = $subvalue\n";
		}*/

	} else {
		echo "ERROR READING FILE\n";
	}
}

readGivenJson($NOBELPHYSICS);










?>
