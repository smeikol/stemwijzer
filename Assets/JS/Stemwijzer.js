const options = document.querySelectorAll('input[name="Choice"]');
const backButton = document.getElementById("BackButton");
const nextButton = document.getElementById("NextButton");
const question = document.getElementById("QuestionHeader");
const asSelection = document.getElementById("AsSelection");
const counter = document.getElementById("counter");
var fetching = false;
var valueArray = [];
var arrayIndex = 0;
UpdateProgress();

options.forEach(function (element) {
	element.addEventListener("click", function () {
		NextButtonActivation("remove");
	});
});

function UpdateProgress() {
	counter.innerHTML = arrayIndex + 1;
}

function NextButtonActivation(state) {
	if (state == "remove") {
		nextButton.classList.remove("DissabledButtons");
	}
	if (state == "add") {
		nextButton.classList.add("DissabledButtons");
	}
	nextButton.blur();
}

nextButton.addEventListener("click", function () {
	NextQuestion();
});

backButton.addEventListener("click", function () {
	PrevQuestion();
});

function PrevQuestion() {
	if (fetching) return;
	fetching = true;
	fetch("../../Assets/Templates/FetchQuestion.php", {
		method: "POST",
		headers: {
			"Content-Type": "application/json",
		},
		body: JSON.stringify({ status: "back" }),
	})
		.then((response) => response.json())
		.then((data) => {
			if (data["status"] == 0) window.location.href = "../../Pages/Home/";
			fetching = false;
			var index = 0;
			asSelection.value = data[0][2];
			arrayIndex--;
			options.forEach(function (element) {
				if (index === 2) {
					index++;
					if (asSelection.value == 1 && element.value == valueArray[arrayIndex][1]) element.checked = true;
					if (asSelection.value == 0 && element.value == valueArray[arrayIndex][0]) element.checked = true;
					return;
				}
				if (index == 0) element.value = 0 - data[0][3];
				if (index == 1) element.value = 0 - data[0][3] / 2;
				if (index == 3) element.value = data[0][3] / 2;
				if (index == 4) element.value = data[0][3];
				if (asSelection.value == 1 && element.value == valueArray[arrayIndex][1]) element.checked = true;
				if (asSelection.value == 0 && element.value == valueArray[arrayIndex][0]) element.checked = true;
				index++;
			});
			question.innerHTML = data[0][1];
			NextButtonActivation("remove");
			UpdateProgress();
		})
		.catch((error) => {
			console.error("Error HUISs:", error);
		});
}

function NextQuestion() {
	if (fetching) return;
	fetching = true;
	fetch("../../Assets/Templates/FetchQuestion.php", {
		method: "POST",
		headers: {
			"Content-Type": "application/json",
		},
		body: JSON.stringify({ status: "next" }),
	})
		.then((response) => response.json())
		.then((data) => {
			options.forEach((element) => {
				if (element.checked) {
					var xvalue = 0;
					var yvalue = 0;

					if (asSelection.value == 0) {
						xvalue += parseFloat(element.value);
					}
					if (asSelection.value == 1) {
						yvalue += parseFloat(element.value);
					}
					if (arrayIndex != valueArray.length) {
						valueArray[arrayIndex] = [xvalue, yvalue];
					} else {
						valueArray.push([xvalue, yvalue]);
					}
				}
			});
			var xvalue = 0;
			var yvalue = 0;
			valueArray.forEach((element) => {
				xvalue += parseFloat(element[0]);
				yvalue += parseFloat(element[1]);
			});
			if (data["status"] == 0) window.location.href = "../../Pages/Result/?" + "xvalue=" + xvalue + "&yvalue=" + yvalue;
			fetching = false;
			var index = 0;
			asSelection.value = data[0][2];
			arrayIndex++;
			options.forEach(function (element) {
				element.checked = false;
				if (index === 2) {
					index++;
					if (arrayIndex != valueArray.length) {
						if (asSelection.value == 1 && element.value == valueArray[arrayIndex][1]) element.checked = true;
						if (asSelection.value == 0 && element.value == valueArray[arrayIndex][0]) element.checked = true;
					}
					return;
				}
				if (index == 0) element.value = 0 - data[0][3];
				if (index == 1) element.value = 0 - data[0][3] / 2;
				if (index == 3) element.value = data[0][3] / 2;
				if (index == 4) element.value = data[0][3];
				if (arrayIndex != valueArray.length) {
					if (asSelection.value == 1 && element.value == valueArray[arrayIndex][1]) element.checked = true;
					if (asSelection.value == 0 && element.value == valueArray[arrayIndex][0]) element.checked = true;
				}
				index++;
			});
			question.innerHTML = data[0][1];
			if (arrayIndex == valueArray.length) {
				NextButtonActivation("add");
			}
			UpdateProgress();
		})
		.catch((error) => {
			console.error("Error HUISs:", error);
		});
}