const options = document.querySelectorAll('input[name="Choice"]');
const nextButton = document.getElementById("NextButton");

console.log(options);
options.forEach(function (element) {
	element.addEventListener("click", function () {
		nextButton.classList.remove("DissabledButtons");
	});
});
