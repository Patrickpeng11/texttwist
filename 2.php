<?php
    //this is the basic way of getting a database handler from PDO, PHP's built in quasi-ORM
    $dbhandle = new PDO("sqlite:scrabble.sqlite") or die("Failed to open DB");
    if (!$dbhandle) die ($error);
    $query= "SELECT rack, words FROM racks WHERE length=7 order by random() limit 1";
//$query = "SELECT * FROM racks WHERE length=7 and weight <= 10 order by random() limit 0, 10";
    $statement = $dbhandle->prepare($query);
    $statement->execute();
    $results = $statement->fetchAll(PDO::FETCH_ASSOC);
    header('HTTP/1.1 200 OK');
    header('Content-Type: application/json');
    $a = json_encode($results);
    echo $a;
    $str = substr($a,10,7);
    $word = substr($a,-10,7);

    $myrack = $str;
    $racks = [];
for($i = 0; $i < pow(2, strlen($myrack)); $i++){
	$ans = "";
	for($j = 0; $j < strlen($myrack); $j++){
		if (($i >> $j) % 2) {
		  $ans .= $myrack[$j];
		}
	}
	if (strlen($ans) > 1){
  	    $racks[] = $ans;	
	}
}
    $racks = array_unique($racks);


for ($n=1;$n<=sizeof($racks);$n++){
    
    $find="SELECT words FROM racks WHERE rack='$racks[$n]'";
    $statement = $dbhandle->prepare($find);
    $statement->execute();
    $re = $statement->fetchAll(PDO::FETCH_ASSOC);
header('HTTP/1.1 200 OK');
    header('Content-Type: application/json');
    echo json_encode($re);
}

?>
