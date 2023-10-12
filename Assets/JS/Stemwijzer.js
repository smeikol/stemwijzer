const options = document.querySelectorAll('input[name="Choice"]');
const nextButton = document.getElementById("NextButton");
const question = document.getElementById("QuestionHeader");
var fetching = false;
var uservalue = 0;
options.forEach(function (element) {
	element.addEventListener("click", function () {
		nextButton.classList.remove("DissabledButtons");
	});
});

nextButton.addEventListener("click", function () {
	FetchNextQuestion();
});

function FetchNextQuestion() {
	var check = false;
	if (fetching) return;
	options.forEach((element) => {
		if (element.checked) {
			uservalue += parseFloat(element.value);
			console.log(uservalue);
		}
	});
	fetching = true;
	fetch("../../Assets/Templates/FetchQuestion.php", {
		method: "POST",
		headers: {
			"Content-Type": "application/json",
		},
	})
		.then((response) => response.json())
		.then((data) => {
			fetching = false;
			var index = 0;
			options.forEach(function (element) {
				if (index == 0) element.value = 0 - data[3];
				if (index == 1) element.value = 0 - data[3] / 2;
				if (index == 3) element.value = data[3] / 2;
				if (index == 4) element.value = data[3];
				element.checked = false;
				index++;
			});
			question.innerHTML = data[1];
		})
		.catch((error) => {
			console.error("Error HUISs:", error);
		});
}
