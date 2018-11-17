<?php
// Paul Barett
$NOBELPHYSICS = "./Nobel_physics.json";
$OSCAR = "./2018_Oscar.json";

$DATASOURCES = "./DataSources.json";

$readyet = "";
function doSearch($filename, $changer, $newval, $searchcategory, $searchterm){

	if(file_exists($filename)){

		if($GLOBALS['readyet'] != $filename){	//only read and decode any file once instead of once per recursion 
			$jsoncontents = file_get_contents($filename);
			$decodedjson = json_decode($jsoncontents, true);
			$GLOBALS['readyet'] = $filename;
			echo "File: "; echo $filename;
			echo "; Category: "; echo $searchcategory;
			echo "; Search Term: "; echo $searchterm;
			echo "\n";
		}

		if($changer != false){	//change value of $decodedjson in foreach to go into subjsons
			$decodedjson = $newval;
		}

		foreach($decodedjson as $key=>$val){	//search through json and output search results
			
			if(gettype($val)=="array"){	
				doSearch($filename, true, $val, $searchcategory, $searchterm);		
			} else {
				if($val == $searchterm){
			
					foreach($decodedjson as $k=>$v){
						echo $k; echo ": "; echo $v; echo "\n";
						//if its an array do the thing to print it
						if(gettype($val)=="array"){
							doSearch($filename, true, $val, $searchcategory, $searchterm);	
						}
					}
				}
			}
		}
		
	} else {
		echo "ERROR READING FILE\n";
	}
}
#doSearch($DATASOURCES, false, [], "firstname", "Peter");

function getJsonCategories($filename) {
	if(file_exists($filename)){
		$filecontents = file_get_contents($filename);
		$decodejson = json_decode($filecontents, true);
		
		$catcount = 0;
		$categoryarray = array();
		foreach($decodejson["categories"] as $key=>$val){
			$categoryarray[$catcount] = $key;
			$catcount++;
		}
		return $categoryarray;
	} else {
		echo "File doesn't exist";
	}
}

function getJsonSearchTerms($filename){
	if(file_exists($filename)){
		$filecontents = file_get_contents($filename);
		$decodejson = json_decode($filecontents, true);

		$searchcount = 0;
		$searchtermarray = array();
		foreach($decodejson["searchterms"] as $skey=>$sval){
			$searchtermarray[$searchcount] = $sval;
			$searchcount++;
		}
		return $searchtermarray;
	} else {
		echo "Make sure the file is correct";
	}
}
$catray = getJsonCategories($DATASOURCES);
$searchray = getJsonSearchTerms($DATASOURCES);

function echoArray($array){
	for($iter = 0; $iter < count($array); $iter++){
		echo '<option value = "';
		echo $array[$iter];
		echo '">';
		echo $array[$iter];
		echo "</option>\n";
	}
}

#echoArray($catray);

?>
<html>
	<body>
		<FORM action="jsonsearch.php" method="get">
			<select id = "Category" class = "dropdown">
				<?php echoArray($catray); ?>
			</select>
			<br>
			<select id = "Searchterm" class = "dropdown">
				<?php echoArray($searchray); ?>
			</select>
			<br>
			<input type = "text" name = "searchquery" class = "searchbox">
			<INPUT type="submit" value="   Submit   ">
		</FORM>
	</body>
</html>
<?php

?>
