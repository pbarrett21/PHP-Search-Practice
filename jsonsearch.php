<?php
// Paul Barett
$NOBELPHYSICS = "./Nobel_physics.json";
$OSCAR = "./2018_Oscar.json";

$DATASOURCES = file_get_contents("./DataSources.json");
$dogs = "Nobel - Physics";
//var_dump($cats->$dogs);


//echo "Hello world!\n";

//$line = readline("search for: ");
//echo "$line";

/*
function doSearch($file, $category, $subcat, $searchterm){
	
	$decData = json_decode($file);
	$categs = $decData->categories;
	$srchterms = $decData->searchterms;

	$whichcat = $categs->$category;		//json name of category (ex: NobelPhysics.json)
	$whichterm = $srchterms->$subcat;	//category of that json to seach inside

	if(file_exists($whichcat)){
		$jsearch = file_get_contents($whichcat);
		$searchjson = json_decode($jsearch);

		//foreach(
	}else{
		echo "File doesn't even exist, yo";
	}
}

doSearch("$DATASOURCES", "Nobel - Physics", "F0", "yeet");
 */

$readyet = "";
function readGivenJson($filename, $changer, $newval, $category, $searchterm){

	//$readyet = "";
	if(file_exists($filename)){

		if($GLOBALS['readyet'] != $filename){	//only read and decode any file once. 
			$jsoncontents = file_get_contents($filename);
			$decodedjson = json_decode($jsoncontents, true);
			$GLOBALS['readyet'] = $filename;
			echo "Category: "; echo $category;
			echo "; Search Term: "; echo $searchterm;
			echo "\n";
		}

		if($changer != false){
			$decodedjson = $newval;
		}

		foreach($decodedjson as $key=>$val){
			if(gettype($val)=="array"){	
				readGivenJson($filename, true, $val, $category, $searchterm);		
			} else {
				if($val == $searchterm){
					foreach($decodedjson as $k=>$v){
						echo $v; echo "\n";
						//if its an array do the thing to print it
						if(gettype($val)=="array"){
							readGivenJson($filename, true, $val, $category, $searchterm);	
						}
					}
				}
				/*
				echo "Key = ";
			 	echo $key;
				echo " Val = ";	
				echo $val;
				echo "\n";
				 */
			}
		}
		
	} else {
		echo "ERROR READING FILE\n";
	}
}
readGivenJson($OSCAR, false, [], "firstname", "Daniel");

?>
