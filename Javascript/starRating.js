var starOne = document.getElementById("star-one");
var starTwo = document.getElementById("star-two");
var starThree = document.getElementById("star-three");
var starFour = document.getElementById("star-four");
var starFive = document.getElementById("star-five");

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
	let starAmount = Number(getCookieValue("Number_Stars"));
	let correctAmount = Number(getCookieValue("Number_Correct"));
	
	const questionNumber = Number(getCookieValue("Question_Number"));
	const questionType = "Question_"+questionNumber+"_Type";
	const questionAnswer = "Question_"+questionNumber;
	const userAnswer = getCookieValue(questionAnswer);
	const fullLength = Math.abs(min)+Math.abs(max);
	
	userAnswerType = getCookieValue(questionType);
	
	if(answerType==="Constant"){
		actualWidth = ((answer/fullLength)*100)+"%";
		userWidth = ((userAnswer/fullLength)*100)+"%";
	}
	
	if(userAnswerType==="Increase"){
		userWidth = (50+((userAnswer/fullLength))*100)+"%";
	}else if (userAnswerType==="Decrease"){
		userWidth = ((userAnswer/fullLength)*100)+"%";
	}
	
	if(answerType==="Increase"){
		actualWidth = (50+((answer/fullLength))*100)+"%";
	}else if (answerType==="Decrease"){
		actualWidth = ((answer/fullLength)*100)+"%";
	}	
	
	document.getElementById('actual-answer').style.width = actualWidth;
	document.getElementById('user-answer').style.width = userWidth;
	
	const OME = Math.abs(Math.log10(userAnswer/answer));
	
	if (userAnswerType === answerType){
		if(OME < .5){
			result = 5;
			correctAmount = correctAmount+1;
			document.cookie = "Number_Correct=" + correctAmount+";Path='/'";
		}else if (OME < .75){
			result = 4;
		}else if (OME < 1){
			result = 3;
		}else{
			result = 2;
		}
	}else{
		result = 1;
	}
	starAmount = starAmount+result;
	document.cookie = "Number_Stars=" + starAmount+";Path='/'";
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