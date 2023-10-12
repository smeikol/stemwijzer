const options = document.querySelectorAll('input[name="Choice"]');
const nextButton = document.getElementById("NextButton");
const question = document.getElementById("QuestionHeader");
const asSelection = document.getElementById("AsSelection");
var fetching = false;
var xvalue = 0;
var yvalue = 0;
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
			if (asSelection.value == 0) {
				xvalue += parseFloat(element.value);
			}
			if (asSelection.value == 1) {
				yvalue += parseFloat(element.value);
			}
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
			if (data["status"] == 0) window.location.href = "../../Pages/Result/?" + "xvalue=" + xvalue + ",yvalue=" + yvalue;
			fetching = false;
			var index = 0;
			options.forEach(function (element) {
				if (index == 0) element.value = 0 - data[0][3];
				if (index == 1) element.value = 0 - data[0][3] / 2;
				if (index == 3) element.value = data[0][3] / 2;
				if (index == 4) element.value = data[0][3];
				element.checked = false;
				index++;
			});
			asSelection.value = data[0][2];
			question.innerHTML = data[0][1];
		})
		.catch((error) => {
			console.error("Error HUISs:", error);
		});
}
