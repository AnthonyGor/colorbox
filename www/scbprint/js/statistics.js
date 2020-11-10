(function () {
  var elementNumberOne = document.getElementById('statistics-number-1');
  var necessaryNumberOne = parseInt(elementNumberOne.textContent, 10);
  var elementNumberTwo = document.getElementById('statistics-number-2');
  var necessaryNumberTwo = parseInt(elementNumberTwo.textContent, 10);
  var elementNumberThree = document.getElementById('statistics-number-3');
  var necessaryNumberThree = parseInt(elementNumberThree.textContent, 10);
  var elementNumberFour = document.getElementById('statistics-number-4');
  var necessaryNumberFour = parseInt(elementNumberFour.textContent, 10);
  var pageSize = window.innerWidth;
  var isAlreadyWorked = false

  function outputNumber(number, element, time, step) {
    var currentValueNumber = 0;
    var intervalTime = Math.round(time / (number / step));

    var interval = setInterval(function () {
      currentValueNumber += step;

      if (currentValueNumber >= number) {
        clearInterval(interval);
      }

      element.innerHTML = currentValueNumber;
    }, intervalTime);
  }


  window.addEventListener('scroll', function () {
    if (pageSize >= 1080 && window.pageYOffset >= 220 && !isAlreadyWorked) {
      outputNumber(necessaryNumberOne, elementNumberOne, 3000, 7);
      outputNumber(necessaryNumberTwo, elementNumberTwo, 3000, 1);
      outputNumber(necessaryNumberThree, elementNumberThree, 3000, 1);
      outputNumber(necessaryNumberFour, elementNumberFour, 3000, 4);

      isAlreadyWorked = true;
    }
  })
}());