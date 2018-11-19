<?php
// Paul Barett
// John Geddes

function doSearch($filename, $changer, $newval, $searchcategory, $searchterm){
	if(file_exists($filename)){
		if($GLOBALS['readyet'] != $filename){	//only read and decode any file once instead of once per recursion
			$jsoncontents = file_get_contents($filename);
			$decodedjson = json_decode($jsoncontents, true);
			$GLOBALS['readyet'] = $filename;
			echo "File: " . $filename;
			echo "; Category: " . $searchcategory;
			echo "; Search Term: " . $searchterm;
		}

		if($changer != false){	//change value of $decodedjson in foreach to go into subjsons
			$decodedjson = $newval;
		}

		foreach($decodedjson as $key=>$val){	//search through json and output search results
			if(gettype($val)=="array"){
				doSearch($filename, true, $val, $searchcategory, $searchterm);
			} else {
				if($key == $searchcategory && $val == $searchterm){
					global $resultcount;
					$resultcount++;		//increment $resultcount if a result is found
					echo "<br>";
					foreach($decodedjson as $k=>$v){
						if(gettype($v) != "array"){
							echo $k . ": " . $v . "<br>";
						} else {
							echo "&emsp;" . $k . ":";	//&emsp; is a tab character in HTML
							foreach($v as $kk=>$vv){
								echo "<br>";
								foreach($vv as $kkey=>$vval){
									echo "&emsp;&emsp;" . $kkey . ": " . $vval . "<br>";
								}
							}
						}
					}
				}
			}
		}
	} else {
		echo "ERROR READING FILE\n";
	}
}

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

function echoArray($array){
	for($iter = 0; $iter < count($array); $iter++){
		echo '<option value = "';
		echo $array[$iter];
		echo '">';
		echo $array[$iter];
		echo "</option>\n";
	}
}

function askUser(){
?>
<html>
	<body>
		<FORM action="jsonsearch.php" method="get">
			<p>Select list to search through:<br>
			<select id = "Category" class = "dropdown" name = "category">
				<?php $DATASOURCES = "./DataSources.json"; $catray = getJsonCategories($DATASOURCES); echoArray($catray); ?>
			</select>
			<br>
			<p>Category:<br>
			<select id = "Searchterm" class = "dropdown" name = "searchterms">
				<?php $DATASOURCES = "./DataSources.json"; $searchray = getJsonSearchTerms($DATASOURCES); echoArray($searchray); ?>
			</select>
			<br>
			<p>Search:<br>
			<input type = "text" name = "whichfield" class = "searchbox">
			<INPUT type="submit" value="   Submit   ">
		</FORM>
	</body>
</html>
<?php
}

$DATASOURCES = "./DataSources.json";
$datacontents = file_get_contents($DATASOURCES);
$datadecode = json_decode($datacontents, true);
$resultcount = 0;
$readyet = "";

if(isset($_GET['category']) && isset($_GET['searchterms']) && isset($_GET['whichfield'])){
	foreach($datadecode["categories"] as $key=>$val){
		if($_GET['category'] == $key){
			$jsonname = $val;
		}
	}

	doSearch($jsonname, false, [], $_GET['searchterms'], strip_tags($_GET['whichfield']));	//remove html tags in input

	if($resultcount == 0){	//check if no results were listed
		echo "<br>No results found for the search term and category.";
	}
} else {
	askUser();
}

?>
