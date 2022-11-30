<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

echo "<!doctype html>";
echo "<html>";
echo "<head>";
echo "<meta charset='utf-8'>";
echo "<title>Finish</title>";
echo "</head>";

echo "<body>";
	echo "Hello";
echo "</body>";
echo "</html>";

	include("functions.php");

	$dblink=db_connect("Estimation_Game");
    if (mysqli_connect_errno())
    {
        die("Error connecting to database: ".mysqli_connect_error());   
    }


		$sql="INSERT INTO `Respondents` (`RespondentID`) VALUES (NULL)";
		$dblink->query($sql) or
			die("Something went wrong with $sql<br>".$dblink->error);
	
		$RespondantID = mysqli_insert_id($dblink);
	
		$sql="Select `QuestionID` from `Questions` order by `QuestionID`";
		$result= $dblink->query($sql)  or
			die("Something went wrong with $sql<br>".$dblink >error);

	while($row = mysqli_fetch_array($result)) {
		$QuestionID = $row['QuestionID'];
		$currentAnswer = $_COOKIE["Question_$QuestionID"];
		$currentType = $_COOKIE["Question_".$QuestionID."_Type"];
		if($currentType=="NULL"){
			$currentType = "Constant";
		}
		echo $QuestionID;
		echo "<br>";
		echo $currentAnswer;
		echo "<br>";
		echo $currentType;
		echo "<br>";
		$sql="Insert into `Answers` (`QuestionID`,`RespondentID`,`Status`,`AnswerType`,`Answer`) values ('$QuestionID','$RespondantID','Correct','$currentType','$currentAnswer')";
		$dblink->query($sql) or
			die("Something went wrong with $sql<br>".$dblink->error);
	}
?>