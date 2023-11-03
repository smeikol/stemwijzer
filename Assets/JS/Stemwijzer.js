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
}

nextButton.addEventListener("click", function () {
	FetchNextQuestion();
});

backButton.addEventListener("click", function () {
	FetchBackQuestion();
});

function FetchNextQuestion() {
	var check = false;
	console.log(valueArray);
	console.log(arrayIndex);

	if (fetching) return;
	if (valueArray.length != arrayIndex) {
		FetchedNextQuestion();
		return;
	}

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
			valueArray.push([xvalue, yvalue]);
			arrayIndex = valueArray.length;
			check = true;
		}
	});

	if (!check) return;

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
			var xvalue = 0;
			var yvalue = 0;
			valueArray.forEach((element) => {
				xvalue += parseFloat(element[0]);
				yvalue += parseFloat(element[1]);
			});
			if (data["status"] == 0) window.location.href = "../../Pages/Result/?" + "xvalue=" + xvalue + "&yvalue=" + yvalue;
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
			NextButtonActivation("add");
			UpdateProgress();
		})
		.catch((error) => {
			console.error("Error HUISs:", error);
		});
}

function FetchBackQuestion() {
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
			options.forEach(function (element) {
				if (index === 2) {
					index++;
					return;
				}
				if (index == 0) element.value = 0 - data[0][3];
				if (index == 1) element.value = 0 - data[0][3] / 2;
				if (index == 3) element.value = data[0][3] / 2;
				if (index == 4) element.value = data[0][3];

				if (asSelection.value == 1 && element.value == valueArray[arrayIndex - 1][1]) element.checked = true;
				if (asSelection.value == 0 && element.value == valueArray[arrayIndex - 1][0]) element.checked = true;
				index++;
			});
			arrayIndex--;
			question.innerHTML = data[0][1];
			NextButtonActivation("remove");
			UpdateProgress();
		})
		.catch((error) => {
			console.error("Error HUISs:", error);
		});
}

function FetchedNextQuestion() {
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
			valueArray[arrayIndex] = [xvalue, yvalue];
			arrayIndex++;
		}
	});
	if (valueArray.length == arrayIndex) {
		FetchNextQuestion();
		return;
	}
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
			asSelection.value = data[0][2];
			var xvalue = 0;
			var yvalue = 0;
			valueArray.forEach((element) => {
				xvalue += parseFloat(element[0]);
				yvalue += parseFloat(element[1]);
			});
			if (data["status"] == 0) window.location.href = "../../Pages/Result/?" + "xvalue=" + xvalue + "&yvalue=" + yvalue;
			fetching = false;
			var index = 0;
			options.forEach(function (element) {
				if (index == 0) element.value = 0 - data[0][3];
				if (index == 1) element.value = 0 - data[0][3] / 2;
				if (index == 3) element.value = data[0][3] / 2;
				if (index == 4) element.value = data[0][3];
				if (asSelection.value == 1 && element.value == valueArray[arrayIndex][1]) element.checked = true;
				if (asSelection.value == 0 && element.value == valueArray[arrayIndex][0]) element.checked = true;
				index++;
			});
			question.innerHTML = data[0][1];
			UpdateProgress();
		})
		.catch((error) => {
			console.error("Error HUISs:", error);
		});
}
