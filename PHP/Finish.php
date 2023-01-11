<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

	include("functions.php");
	$numCorrect = 0;
	$numQuestions = 1;
	
	if(isset($_COOKIE["Number_Correct"])) {
  		$numCorrect = $_COOKIE["Number_Correct"];
	}

	if(isset($_COOKIE["Question_Amount"])) {
  		$numQuestions = $_COOKIE["Question_Amount"];
	}

	$numStars=0;
	$numStarsTotal=$numQuestions*5;

	echo "<!DOCTYPE html>";
	
	echo "<html>";
	echo "<head>";
		echo "<title>Summary Page</title>";
		echo "<meta name='description' content='Quiz page for Estimation Game'>";
		echo "<meta name='viewport' content='width=device-width, initial-scale=0.7'>";
		echo "<link rel='stylesheet' href='/CSS/finishStyle.css'>";
	echo "</head>";
	echo "<body>";
		echo "<div class='box'>";

			echo "<h2>SUMMARY</h2>";
			echo "<hr><div class='container'>";

			echo $numCorrect." <b>Questions</b> exactly correct out of ".$numQuestions." <b>Total Questions.</b><br></div><br>";
			for ($i = 1; $i<=$numQuestions; $i++){
				$starCookieName = "Star_".$i;
				if($_COOKIE[$starCookieName]==0){
					echo "<div class='star-box'><ul class='star-list'>
						<li class='star star-question'>
							Question ".$i." :
						</li>
						<li class='star'>
						  &#11088;
						</li>
						<li class='star'>
						  &#11088;
						</li>
						<li class='star'>
						  &#11088;
						</li>
						<li class='star'>
						  &#11088;
						</li>
						<li class='star'>
						  &#11088;
						</li>
					</ul></div>";
				}else if($_COOKIE[$starCookieName]==1){
					echo "<div class='star-box'><ul class='star-list'>
						<li class='star star-question'>
							Question ".$i." :
						</li>
						<li class='star star-on'>
						  &#11088;
						</li>
						<li class='star'>
						  &#11088;
						</li>
						<li class='star'>
						  &#11088;
						</li>
						<li class='star'>
						  &#11088;
						</li>
						<li class='star'>
						  &#11088;
						</li>
					</ul></div>";
				}else if($_COOKIE[$starCookieName]==2){
					echo "<div class='star-box'><ul class='star-list'>
						<li class='star star-question'>
							Question ".$i." :
						</li>
						<li class='star star-on'>
						  &#11088;
						</li>
						<li class='star star-on'>
						  &#11088;
						</li>
						<li class='star'>
						  &#11088;
						</li>
						<li class='star'>
						  &#11088;
						</li>
						<li class='star'>
						  &#11088;
						</li>
					</ul></div>";
				}else if($_COOKIE[$starCookieName]==3){
					echo "<div class='star-box'><ul class='star-list'>
						<li class='star star-question'>
							Question ".$i." :
						</li>
						<li class='star star-on'>
						  &#11088;
						</li>
						<li class='star star-on'>
						  &#11088;
						</li>
						<li class='star star-on'>
						  &#11088;
						</li>
						<li class='star'>
						  &#11088;
						</li>
						<li class='star'>
						  &#11088;
						</li>
					</ul></div>";
				}else if($_COOKIE[$starCookieName]==4){
					echo "<div class='star-box'><ul class='star-list'>
						<li class='star star-question'>
							Question ".$i." :
						</li>
						<li class='star star-on'>
						  &#11088;
						</li>
						<li class='star star-on'>
						  &#11088;
						</li>
						<li class='star star-on'>
						  &#11088;
						</li>
						<li class='star star-on'>
						  &#11088;
						</li>
						<li class='star'>
						  &#11088;
						</li>
					</ul></div>";
				}else if($_COOKIE[$starCookieName]==5){
					echo "<div class='star-box'><ul class='star-list'>
						<li class='star star-question'>
							Question ".$i." :
						</li>
						<li class='star star-on'>
						  &#11088;
						</li>
						<li class='star star-on'>
						  &#11088;
						</li>
						<li class='star star-on'>
						  &#11088;
						</li>
						<li class='star star-on'>
						  &#11088;
						</li>
						<li class='star star-on'>
						  &#11088;
						</li>
					</ul></div>";
				}
				$numStars=$numStars+$_COOKIE[$starCookieName];
			}
			echo "<br><div class='container'>".$numStars." <b>Stars</b> obtained out of ".$numStarsTotal." <b>Total Stars</b><br></div><br>";
		echo "</div>";
	echo "</body>";
echo "</html>";

	if (isset($_SERVER['HTTP_COOKIE'])) {
		$cookies = explode(';', $_SERVER['HTTP_COOKIE']);
		foreach($cookies as $cookie) {
			$parts = explode('=', $cookie);
			$name = trim($parts[0]);
			setcookie($name, '', time()-1000);
			setcookie($name, '', time()-1000, '/');
		}
	}

	$pageWasRefreshed = isset($_SERVER['HTTP_CACHE_CONTROL']) && $_SERVER['HTTP_CACHE_CONTROL'] === 'max-age=0';


	if($pageWasRefreshed ) {
  		header('Location: ../index.html');
	}

	/*$dblink=db_connect("Estimation_Game");
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
		echo "Question Number : ".$QuestionID;
		echo "<br>";
		echo "User Answer for Question ".$QuestionID." : ".$currentAnswer;
		echo "<br>";
		echo "User Answer Type for Question ".$QuestionID." : ".$currentType;
		echo "<br><br>";
		$sql="Insert into `Answers` (`QuestionID`,`RespondentID`,`Status`,`AnswerType`,`Answer`) values ('$QuestionID','$RespondantID','Correct','$currentType','$currentAnswer')";
		$dblink->query($sql) or
			die("Something went wrong with $sql<br>".$dblink->error);
	}*/
?>