var starOne = document.getElementById("star-one");
var starTwo = document.getElementById("star-two");
var starThree = document.getElementById("star-three");
var starFour = document.getElementById("star-four");
var starFive = document.getElementById("star-five");
var starText = document.getElementById("starRatingText");

var answer = document.getElementById("answer-holder").value;
var answerType = document.getElementById("type-holder").value;
var min = document.getElementById("min-holder").value;
var max = document.getElementById("max-holder").value;

getPercent();

function getPercent(){
	let result=0;
	let userAnswerType= "";
	let userWidth = "";
	let actualWidth = "";
	let correctAmount = Number(getCookieValue("Number_Correct"));
	
	const questionNumber = Number(getCookieValue("Question_Number"));
	const questionType = "Question_"+questionNumber+"_Type";
	const questionAnswer = "Question_"+questionNumber;
	const starCookie = "Star_"+questionNumber;
	const userAnswer = getCookieValue(questionAnswer);
	const fullLength = Math.abs(min)+Math.abs(max);
	
	userAnswerType = getCookieValue(questionType);
	
	if(answerType==="Constant"){
		if (min==0){
			actualWidth = ((answer/fullLength)*100)+"%";
			userWidth = ((userAnswer/fullLength)*100)+"%";
		}
		else{
			if(userAnswer>0){
				userWidth = (50+((userAnswer/fullLength)*100))+"%";
			}else{
				userWidth = (50-((Math.abs(userAnswer)/fullLength)*100))+"%";
			}
			
			if(answer>0){
				actualWidth = (50+((answer/fullLength)*100))+"%";
			}else{
				actualWidth = (50-((Math.abs(answer)/fullLength)*100))+"%";
			}
		}
	}
	
	if(userAnswerType==="Increase"){
		userWidth = (50+((userAnswer/fullLength)*100))+"%";
	}else if (userAnswerType==="Decrease"){
		userWidth = (50-((userAnswer/fullLength)*100))+"%";
	}
	
	if(answerType==="Increase"){
		actualWidth = (50+((answer/fullLength)*100))+"%";
	}else if (answerType==="Decrease"){
		actualWidth = (50-((answer/fullLength)*100))+"%";
	}	
	
	document.getElementById('actual-answer').style.width = actualWidth;
	document.getElementById('user-answer').style.width = userWidth;
	
	const OME = Math.abs(Math.log10(userAnswer/answer));
	
	if(answerType === "Constant"){
		if(OME < .2){
			result = 5;
			starText.innerHTML="Amazing Job!";
			if(OME === 0){
				starText.innerHTML="Perfect!";
				correctAmount = correctAmount+1;
				document.cookie = "Number_Correct=" + correctAmount+";Path='/'";
			}
		}else if (OME < .4){
			starText.innerHTML="Great Work!";
			result = 4;
		}else if (OME < .6){
			starText.innerHTML="Alright!";
			result = 3;
		}else if (OME < .8){
			starText.innerHTML="Good Try!";
			result = 2;
		}else{
			starText.innerHTML="Better luck next time!";
			result = 1;
		}
	}
	else{
		if (userAnswerType === answerType){
			if(OME < .5){
				result = 5;
				starText.innerHTML="Amazing Job!";
				if(OME === 0){
					starText.innerHTML="Perfect!";
					correctAmount = correctAmount+1;
					document.cookie = "Number_Correct=" + correctAmount+";Path='/'";
				}
			}else if (OME < .75){
				starText.innerHTML="Great Work!";
				result = 4;
			}else if (OME < 1){
				starText.innerHTML="Alright!";
				result = 3;
			}else{
				starText.innerHTML="Good Try!";
				result = 2;
			}
		}else{
			starText.innerHTML="Better luck next time!";
			result = 1;
		}
	}
	document.cookie =  starCookie +"="+ result+";Path='/'";
	percentage(result);
}

function delay(time) {
    return new Promise(resolve => setTimeout(resolve, time));
}
function delayStar(star) {
    delay(400).then(() => star.classList.add("star-on"));
}

function percentage(result){
    if(result === 0){
        removeAll();
        delay(1000);
    }
    else if(result === 1 ){
        removeAll();
        delayStar(starOne);
    }else if(result === 2){
        removeAll();
        delayStar(starOne);
        delayStar(starTwo);
    }else if(result === 3){
        removeAll();
        delayStar(starOne);
        delayStar(starTwo);
        delayStar(starThree);
    }else if(result === 4){
        removeAll();
        delayStar(starOne);
        delayStar(starTwo);
        delayStar(starThree);
        delayStar(starFour);
    }else if(result === 5){
        removeAll();
        delayStar(starOne);
        delayStar(starTwo);
        delayStar(starThree);
        delayStar(starFour);
        delayStar(starFive);
    }
}

function removeAll(){
    starOne.classList.remove("star-on");
    starTwo.classList.remove("star-on");
    starThree.classList.remove("star-on");
    starFour.classList.remove("star-on");
    starFive.classList.remove("star-on");
}

function getCookieValue(name) {
  let result = document.cookie.match("(^|[^;]+)\s*" + name + "\s*=\s*([^;]+)")
  return result ? result.pop() : ""
}