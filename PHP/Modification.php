<?php
	include("functions.php");
	$total=4;
	$count=1;

	if (!isset($_COOKIE["Count_Number"])){
		setcookie("Count_Number", "1", time() + (86400 * 30), "/PHP"); // 86400 = 1 day
	}
	if (isset($_COOKIE["Count_Number"])){
		$count = $_COOKIE["Count_Number"];
	}
	

	echo "<!DOCTYPE html>";
	echo "<html>";
	echo "<head>";
		echo "<title>Modification Page</title>";
		echo "<meta name='description' content='Quix page for Estimation Game'>";
		echo "<meta name='viewport' content='width=device-width, initial-scale=0.7'>";
		echo "<link rel='stylesheet' href='/CSS/InterventionStyle.css'>";
	echo "</head>";
	echo "<body>";
			
			echo "<div class='progress-box'>";
			echo "<h2>INTERVENTION TUTORIAL</h2>";
			echo "<div class='progress-bar'><div class='progress-bar-fill' style='width:".(($count/$total)*100)."%'></div>";
			echo "<img class='progress-globe' style='top: -38px; left:".((($count/$total)*100)-7)."%; position: relative; scale:0.7;' src='../Sources/Globe-Emoticon.png'></div></div>";
			echo "<div class='box'>";
			switch ($count) {
    			case 1:
        			echo "<p> Please read the text on the following page carefully. The text will help you to complete the activities that follow. </p><br>";
					
					echo "<form  method='post'>";
    					echo "<div button-container><input type='submit' type='button' name='insert' value='Continue'></div>";
					echo "</form>";
					
					if(isset($_POST['insert'])){
						$count=$count+1;
						setcookie("Count_Number", $count, time() + (86400 * 30), "/PHP");
						header("refresh: 0");
    				}
					
        			break;
    			case 2:
        			echo "<div class='submission-box user-question-box'><div class='answer-statement'>ROUGH ESTIMATES</div><br><div class='answer-explanation'>Sometimes people estimate everyday numbers in their head. For example, you might quickly estimate the cost of tax and tip in your head before ordering a meal at a restaurant. These calculations are naturally very rough and imprecise, and it is okay if your guess is not perfect. In this activity you will estimate many numbers, and when you do, you should try to feel comfortable if your estimates are not perfectly correct. Before we start, let's learn a few strategies to improve our estimation accuracy.</div><br>";
					
					echo "<div class='answer-statement'>REFERENCE NUMBERS</div><br><div class='answer-explanation'>Numbers that you already know (called reference numbers) can help you estimate numbers that you do not know. <br> For example, if you know that it takes 5 apples to make one carton of apple juice,  you can use this information to estimate the number of apples it takes to make a gallon of apple juice. I guess that about 20 cartons fit in a gallon, thus 20 × 5 = 100 apples are needed to make a gallon of apple juice.</div><br>";
					
					echo "<div class='answer-statement'>SIMPLIFYING NUMBERS</div><br><div class='answer-explanation'>When using reference numbers, you may want to round values to make mental computation easier. For example, let’s estimate the population of California given that the population of Kentucky is 4.47 million people. Before we estimate, we first round the Kentucky population to 4 million to make the math easier, and scale this value according to our beliefs about the size of California compared to Kentucky. If you were to guess that California is about ten times more populous than Kentucky, you might estimate that California has 10 × 4 million = 40 million people.</div></div><br>";
					
					echo "<form  method='post'>";
    					echo "<div button-container><input type='submit' type='button' name='insert' value='Continue'></div>";
					echo "</form>";
					
					if(isset($_POST['insert'])){
						$count=$count+1;
						setcookie("Count_Number", $count, time() + (86400 * 30), "/PHP");
						header("refresh: 0");
    				}
        			break;
    			case 3:
        			echo "<div class='submission-box user-question-box'><div class='answer-statement'>Now you try:</div><br><div class='answer-explanation'>What is the number of pennies that fit inside of a tennis ball?<br><i>Hint: 53 pennies fit inside of a ping-pong ball.</i></div>";
					
					echo "<form method='post' id='inputForm'>";
						echo "<br><div class='answer-col'><label for='user_answer'></label>";
						if (is_array($_POST) && !empty($_POST)) {
							if(isset($_POST['user_answer'])){
								if(is_numeric($_POST['user_answer'])){
									echo "<span class='error' style='color:blue'>Correct Answer: 212 pennies"."</span>";
									echo "<span class='error' style='color:green'><br>Nice Try!"."</span>";
									echo "<br><br><div button-container><input type='submit' type='button' name='insert' value='Continue'></div>";

								}else{
									echo "<input type='text' id='user_answer' name='user_answer'> Pennies</div>";
									echo "<span class='error' style='color:green'><br>Please Enter a Number"."</span>";
									echo "<br><br><input class='button' type='submit' value='Submit Answer'/>";
								}
							}else{
								echo "<input type='text' id='user_answer' name='user_answer'> Pennies</div>";
								echo "<span class='error' style='color:green'><br>Please Enter Input"."</span>";
								echo "<br><br><input class='button' type='submit' value='Submit Answer'/>";
							}
						}else{
							echo "<input type='text' id='user_answer' name='user_answer'> Pennies</div>";
							echo "<br><input class='button' type='submit' value='Submit Answer'/>";
						}
					echo "</form>";
					if(isset($_POST['insert'])){
						$count=$count+1;
						setcookie("Count_Number", $count, time() + (86400 * 30), "/PHP");
						header("refresh: 0");
					}

        			break;
				case 4:
					echo "<div class='submission-box user-question-box'><div class='answer-statement'>Try another one:</div><br><div class='answer-explanation'>What is the average weight in pounds of garbage produced per person in the USA every day?<br><i>Hint: an uneaten apple typically weighs 0.33 pounds.</i></div>";
					
					echo "<form method='post' id='inputForm'>";
						echo "<br><div class='answer-col'><label for='user_answer'></label>";
						if (is_array($_POST) && !empty($_POST)) {
							if(isset($_POST['user_answer'])){
								if(is_numeric($_POST['user_answer'])){
									echo "<span class='error' style='color:blue'>Correct Answer: 5 lbs"."</span>";
									echo "<span class='error' style='color:green'><br>Great!"."</span>";
									echo"<br><br><a href='Intervention.php'>";
										echo "<div button-container><button type='button'>";
											echo "Redirect to Quiz";
										echo "</button></div>";
									echo "</a>";
									if (isset($_SERVER['HTTP_COOKIE'])) {
										$cookies = explode(';', $_SERVER['HTTP_COOKIE']);
										foreach($cookies as $cookie) {
											$parts = explode('=', $cookie);
											$name = trim($parts[0]);
											setcookie($name, '', time()-1000);
											setcookie($name, '', time()-1000, '/');
										}
									}
								}else{
									echo "<input type='text' id='user_answer' name='user_answer'> Pounds</div>";
									echo "<span class='error' style='color:green'><br>Please Enter a Number"."</span>";
									echo "<br><br><input class='button' type='submit' value='Submit Answer'/>";
								}
							}else{
								echo "<input type='text' id='user_answer' name='user_answer'> Pounds</div>";
								echo "<span class='error' style='color:green'><br>Please Enter Input"."</span>";
								echo "<br><br><input class='button' type='submit' value='Submit Answer'/>";
							}
						}else{
							echo "<input type='text' id='user_answer' name='user_answer'> Pounds</div>";
							echo "<br><input class='button' type='submit' value='Submit Answer'/>";
						}
					echo "</form>";			
					break;		
			}
				
				echo "</div>";
		echo "</div>";
	echo "</body>";
	echo "</html>";
?>