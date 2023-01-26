const modal = document.querySelector('#modal');
const closeModal = document.querySelector(".close-button");

openModal();

function openModal(){
	document.getElementById("inputForm").reset();
	modal.showModal();
}

closeModal.addEventListener("click", () => {
	const questionNumber = Number(getCookieValue("Question_Number")) + 1;
	if (questionNumber>Number(getCookieValue("Question_Amount"))){
		document.cookie = "Question_Number=1;Path='/PHP'";
		document.location.href = "Finish.php";
	}else{
		document.cookie = "Question_Number=" + questionNumber+";Path='/PHP'";
		window.location.href = '/PHP/Intervention.php';
		modal.close();
	}
});

function getCookieValue(name) {
  let result = document.cookie.match("(^|[^;]+)\s*" + name + "\s*=\s*([^;]+)")
  return result ? result.pop() : ""
}