const modal = document.querySelector('#modal');
const closeModal = document.querySelector(".close-button");

openModal();

function openModal(){
	document.getElementById("inputForm").reset();
	modal.showModal();
}

closeModal.addEventListener("click", () => {
	const questionCount = Number(getCookieValue("Question_Count")) + 1;
	const currentQuestion = Number(getCookieValue("Question_Number"));
	document.cookie = "Question_Status_"+currentQuestion+"=True;Path='/PHP'";
	
	var arr = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12];
	
	for (let i = 1; i <= 12; i++) {
		let questionCompletedCookie = "Question_Status_"+i;
		if(getCookieValue(questionCompletedCookie)==="True"){
			arr.splice(arr.indexOf(i), 1);
		}
	}

	var questionNumber = arr[Math.floor(Math.random()*arr.length)];
	
	if (questionCount>Number(getCookieValue("Question_Amount"))){
		document.cookie = "Question_Count=1;Path='/PHP'";
		document.location.href = "Finish.php";
	}else{
		document.cookie = "Question_Count=" + questionCount+";Path='/PHP'";
		document.cookie = "Question_Number=" + questionNumber+";Path='/PHP'";
		window.location.href = '/PHP/Random.php';
		modal.close();
	}
});

function getCookieValue(name) {
  let result = document.cookie.match("(^|[^;]+)\s*" + name + "\s*=\s*([^;]+)")
  return result ? result.pop() : ""
}