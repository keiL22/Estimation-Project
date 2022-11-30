<?php
	include("functions.php");
	$currentQuestion=1;
	$questionAmount=0;
	$questionText="";

	if (!isset($_COOKIE["Question_Number"])){
		setcookie("Question_Number", "1", time() + (86400 * 30), "/PHP"); // 86400 = 1 day
	}
	if (isset($_COOKIE["Question_Number"])){
		$currentQuestion = $_COOKIE["Question_Number"];
	}

	$dblink=db_connect("Estimation_Game");
    if (mysqli_connect_errno())
    {
        die("Error connecting to database: ".mysqli_connect_error());   
    }

	echo "<!DOCTYPE html>";
	
	echo "<html>";
	echo "<head>";
		echo "<title>Intervention Page</title>";
		echo "<meta name='description' content='Quix page for Estimation Game'>";
		echo "<meta name='viewport' content='width=device-width, initial-scale=0.7'>";
		echo "<link rel='stylesheet' href='/CSS/InterventionStyle.css'>";
	echo "</head>";
	echo "<body>";
		echo "<div class='box'>";
			$sql="Select Distinct `QuestionID` from `Questions`";
			$result= $dblink->query($sql)  or
				die("Something went wrong with $sql<br>".$dblink >error);

			$questionAmount = mysqli_num_rows($result);
			setcookie("Question_Amount", $questionAmount, time() + (86400 * 30), "/PHP");

			$sql="Select `QuestionID`,`Question`,`Hint`,`AnswerUnit`,`AnswerType`,`RangeMin`,`RangeMax` from `Questions` where `QuestionID` like '%$currentQuestion%'";
			$result= $dblink->query($sql)  or
				die("Something went wrong with $sql<br>".$dblink >error);

			$row = mysqli_fetch_array($result);

			echo "<dialog class='modal-box' id='modal'>";
				echo "<br><h2>Star Rating Here</h2><br><hr>";
				echo "<p>Question Answer here</p><br>";
				echo "<p>Question Explanation here </p><br><hr>";
				echo "<p>Number Line here</p><br><hr>";
				echo "<button class='button close-button'>Next Question</button>";
			echo "</dialog>";
			echo "<h2>Question $currentQuestion out of $questionAmount</h2>";
			echo "<hr>";

			echo $row['Question'];
			echo "<form method='post' id='inputForm'>";
				echo "<label for='user_answer'> Answer </label>";
				echo "<input type='text' id='user_answer' name='user_answer'>";
				if (!empty($row['AnswerType'])){
					echo "<select name='answer_select' id='answer_select'>";
						echo "<option value='increase'>Increase</option>";
						echo "<option value='increase'>Decrease</option>";
					echo "</select>";
				}
				if (is_array($_POST) && !empty($_POST)) {
					if(isset($_POST['user_answer'])){
						if(is_numeric($_POST['user_answer'])){
							if($_POST['user_answer']>=$row['RangeMin']&&$_POST['user_answer']<=$row['RangeMax']){
								$userAnswer=$_POST['user_answer'];
								$cookieName = "Question_$currentQuestion";
								setcookie($cookieName, $userAnswer, time() + (86400 * 30), "/PHP");
								echo "<script modal src='../Javascript/OpenModal.js'></script>";
							}else{
								echo "<br><br>Please a value from ".$row['RangeMin']." to ".$row['RangeMax'];
							}
						}else{
							echo "<br><br>Please Enter a Number";
						}
					}
					else{
						echo "<br><br>Please Enter Input";
					}
				}
				echo "<br><br>";
				echo "<input class='button' type='submit' value='Submit Answer'/>";
			echo "</form>";
			
		echo "</div>";
	echo "</body>";
	echo "</html>";
?>