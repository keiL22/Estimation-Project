<?php
	include("functions.php");
	
	$currentQuestion=rand(1, 12);
	$questionAmount=0;
	$questionText="";
	$count=1;

	if (!isset($_COOKIE["Question_Number"])){
		setcookie("Question_Number", $currentQuestion, time() + (86400 * 30), "/PHP"); // 86400 = 1 day
	}
	if (!isset($_COOKIE["Question_Count"])){
		setcookie("Question_Count", "1", time() + (86400 * 30), "/PHP"); // 86400 = 1 day
	}
	if (isset($_COOKIE["Question_Number"])){
		$currentQuestion = $_COOKIE["Question_Number"];
	}
	if (isset($_COOKIE["Question_Count"])){
		$count = $_COOKIE["Question_Count"];
	}
	if (!isset($_COOKIE["Number_Correct"])){
		setcookie("Number_Correct", "0", time() + (86400 * 30), "/PHP"); // 86400 = 1 day
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
		echo "<meta name='viewport' content='width=device-width, initial-scale=0.5'>";
		echo "<link rel='stylesheet' href='/CSS/InterventionStyle.css'>";
	echo "</head>";
	echo "<body>";
		
			$sql="Select Distinct `QuestionID` from `Questions`";
			$result= $dblink->query($sql)  or
				die("Something went wrong with $sql<br>".$dblink >error);

			$questionAmount = mysqli_num_rows($result);
			setcookie("Question_Amount", $questionAmount, time() + (86400 * 30), "/PHP");

			$sql="Select `QuestionID`,`Question`,`Hint`,`Answer`,`AnswerStatement`,`Explanation`,`AnswerUnit`,`AnswerType`,`RangeMin`,`RangeMax` from `Questions` where `QuestionID` like '$currentQuestion'";
			$result= $dblink->query($sql)  or
				die("Something went wrong with $sql<br>".$dblink >error);

			$row = mysqli_fetch_array($result);

			echo "<input type=hidden id='answer-holder' value='".$row['Answer']."'></input>";
			echo "<input type=hidden id='type-holder' value='".$row['AnswerType']."'></input>";
			echo "<input type=hidden id='min-holder' value='".$row['RangeMin']."'></input>";
			echo "<input type=hidden id='max-holder' value='".$row['RangeMax']."'></input>";
			

			echo "<dialog class='modal-box' id='modal'>";
				echo "<div class='container-box'><br><h2 id='starRatingText'>Star Rating Here</h2>";
				echo "<div class='star-box'><ul class='star-list'>
						<li class='star' id='star-one'>
						  &#11088;
						</li>
						<li class='star' id='star-two'>
						  &#11088;
						</li>
						<li class='star' id='star-three'>
						  &#11088;
						</li>
						<li class='star' id='star-four'>
						  &#11088;
						</li>
						<li class='star' id='star-five'>
						  &#11088;
						</li>
					</ul></div></div>";
				echo "<div class='container-box'><div class='submission-box answer-statement-box'><p class='answer-statement'>".$row['AnswerStatement']."</p><br>";
				echo "<p class='answer-explanation'>".$row['Explanation']."</p></div><br>";
				echo "<div class='submission-box skill-bar-box'>";
				if($row['QuestionID']=="7"||$row['QuestionID']=="11"){
					echo "<div class='bar-units'>Shown in ".$row['AnswerUnit']."</div>";
				}else if(($row['AnswerType'])!="Constant"){
					echo "<div class='bar-units'>Shown in % of ".$row['AnswerUnit']."</div>";
				}else{
					echo "<div class='bar-units'>Shown in ".$row['AnswerUnit']."</div>";
				}
				echo "<br><div class='skill-bars'><div class='bar'><div class='progress-line html'><span id='user-answer' class='user-answer'></span><span id='actual-answer' class='actual-answer'></span></div></div></div><span class='range-max'>".$row['RangeMax']."</span><span class='range-min'>".$row['RangeMin']."</span>";
				echo "</div><br><div button-container>";
				if($count==$questionAmount){
					echo "<button class='button close-button'>Finish Quiz</button>";
					setcookie("Quiz_Completion", "1", time() + (86400 * 30), "/PHP");
				}else{
					echo "<button class='button close-button'>Next Question</button>";
				}
				echo"</div><br><hr>";
				echo"<input class='sources-box' id='sourcesBox' type='checkbox' name='source-box'/>";
				echo "<label class='source-label' id='sourcesLabel' for='sourcesBox' ></label>";
				echo "<ul class='submenu'>";
					$sql2="Select `QuestionID`,`SourceText`,`SourceLink`,`SourceName` from `Sources` where `QuestionID` like '$currentQuestion'";
					$result2=$dblink->query($sql2) or
						die("Something went wrong with $sql2<br>".$dblink->error);
					while ($data=$result2->fetch_array(MYSQLI_ASSOC))
					{
						echo"<li>".$data['SourceText']."<a href='".$data['SourceLink']."' target='_blank'>".$data['SourceName']."</a><br><br></li>";
					}
				echo"</ul></div>";
			echo "</dialog>";
			
			echo "<div class='progress-box'>";
			echo "<h2>Question $count out of $questionAmount</h2>";
			echo "<div class='progress-bar'><div class='progress-bar-fill' style='width:".(($count/$questionAmount)*100)."%'></div>";
			echo "<img class='progress-globe' style='top: -38px; left:".((($count/$questionAmount)*100)-7)."%; position: relative; scale:0.7;' src='../Sources/Globe-Emoticon.png'></div></div>";
			echo "<div class='box'>";
			echo "<div class='submission-box user-question-box'><p>".$row['Question']."</p>";
			if(is_null($row['Hint'])){
				echo "</div>";
			}else{
				echo "<div class='question-hint'><i>".$row['Hint']."</i></div></div>";
			}
			echo "<form method='post' id='inputForm'>";
				echo "<br><div class='answer-col'><label for='user_answer'></label>";
				if($row['QuestionID']=="7"){
					echo "<input type='text' id='user_answer' name='user_answer'> Inch ";
					echo "<select name='answer_select' id='answer_select'>";
						echo "<option value='Increase'>Increase</option>";
						echo "<option value='Decrease'>Decrease</option></select>";
				}else if ($row['QuestionID']=="11"){
					echo "<input type='text' id='user_answer' name='user_answer'> Degree Farenheit ";
					echo "<select name='answer_select' id='answer_select'>";
						echo "<option value='Increase'>Increase</option>";
						echo "<option value='Decrease'>Decrease</option></select>";
				}
				else if (($row['AnswerType'])!="Constant"){
					echo "<input type='text' id='user_answer' name='user_answer'> % ";
					echo "<select name='answer_select' id='answer_select'>";
						echo "<option value='Increase'>Increase</option>";
						echo "<option value='Decrease'>Decrease</option>";
					echo " </select> in ".$row['AnswerUnit']."";
				}else{
					echo "<input type='text' id='user_answer' name='user_answer'> ".$row['AnswerUnit']."";
				}
				echo "</div>";
				if (is_array($_POST) && !empty($_POST)) {
					if(isset($_POST['user_answer'])){
						
						if(is_numeric($_POST['user_answer'])){
							if (($row['AnswerType'])!="Constant"){
								if($_POST['user_answer']>=0&&$_POST['user_answer']<=$row['RangeMax']){
									$userAnswer=$_POST['user_answer'];
									$QuestionCookie = "Question_$currentQuestion";
									$TypeCookie = "Question_".$currentQuestion."_Type";
									setcookie($QuestionCookie, $userAnswer, time() + (86400 * 30), "/PHP");
									if (($row['AnswerType'])!="Constant"){
										setcookie($TypeCookie, $_POST['answer_select'], time() + (86400 * 30), "/PHP");
									}else{
										setcookie($TypeCookie, "Constant", time() + (86400 * 30), "/PHP");
									}
									echo "<script modal src='../Javascript/starRating.js'></script>";
									echo "<script modal src='../Javascript/OpenModalRandom.js'></script>";
								}else{
									if (($row['AnswerType'])!="Constant"){
										echo "<span class='error' style='color:green'><br>Please a value from 0 to ".$row['RangeMax']."</span>";
									}else{
										echo "<span class='error' style='color:green'><br>Please a value from ".$row['RangeMin']." to ".$row['RangeMax']."</span>";
									}
								}
							}else{
								if($_POST['user_answer']>=$row['RangeMin']&&$_POST['user_answer']<=$row['RangeMax']){
									$userAnswer=$_POST['user_answer'];
									$QuestionCookie = "Question_$currentQuestion";
									$TypeCookie = "Question_".$currentQuestion."_Type";
									setcookie($QuestionCookie, $userAnswer, time() + (86400 * 30), "/PHP");
									if (($row['AnswerType'])!="Constant"){
										setcookie($TypeCookie, $_POST['answer_select'], time() + (86400 * 30), "/PHP");
									}else{
										setcookie($TypeCookie, "Constant", time() + (86400 * 30), "/PHP");
									}
									echo "<script modal src='../Javascript/starRating.js'></script>";
									echo "<script modal src='../Javascript/OpenModalRandom.js'></script>";
								}else{
									if (($row['AnswerType'])!="Constant"){
										echo "<span class='error' style='color:green'><br>Please a value from 0 to ".$row['RangeMax']."</span>";
									}else{
										echo "<span class='error' style='color:green'><br>Please a value from ".$row['RangeMin']." to ".$row['RangeMax']."</span>";
									}
								}
							}
						}else{
							echo "<span class='error' style='color:green'><br>Please Enter a Number"."</span>";
						}
					}
					else{
						echo "<span class='error' style='color:green'><br>Please Enter Input"."</span>";
					}
				}
				echo "<br><br>";
				echo "<input class='button' type='submit' value='Submit Answer'/>";
			echo "</form>";
			
		echo "</div>";
	echo "</body>";
	echo "</html>";
?>