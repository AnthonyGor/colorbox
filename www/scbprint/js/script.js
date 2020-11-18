(function () {
  /*the statistics block*/

  var elementNumberOne = document.getElementById('statistics-number-1');
  var necessaryNumberOne = parseInt(elementNumberOne.textContent, 10);
  var elementNumberTwo = document.getElementById('statistics-number-2');
  var necessaryNumberTwo = parseInt(elementNumberTwo.textContent, 10);
  var elementNumberThree = document.getElementById('statistics-number-3');
  var necessaryNumberThree = parseInt(elementNumberThree.textContent, 10);
  var elementNumberFour = document.getElementById('statistics-number-4');
  var necessaryNumberFour = parseInt(elementNumberFour.textContent, 10);
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

  function startAllNumbers () {
    if (!isAlreadyWorked) {
      outputNumber(necessaryNumberOne, elementNumberOne, 3000, 7);
      outputNumber(necessaryNumberTwo, elementNumberTwo, 3000, 1);
      outputNumber(necessaryNumberThree, elementNumberThree, 3000, 1);
      outputNumber(necessaryNumberFour, elementNumberFour, 3000, 4);

      isAlreadyWorked = true;
    }
  }

  /*start animation*/

  var statistics = document.querySelector('.statistics');
  var statisticsCoords = statistics.getBoundingClientRect().top + (statistics.offsetHeight / 2);
  var extrasList = document.querySelector('.extras__list');
  var extrasListCoords = extrasList.getBoundingClientRect().top + (extrasList.offsetHeight / 3.5);
  var casesList = document.querySelector('.cases__list')
  var casesListCoords = casesList.getBoundingClientRect().top + (casesList.offsetHeight / 6.5);
  var blogWrapper = document.querySelector('.blog__wrapper');
  var blogWrapperCoords = blogWrapper.getBoundingClientRect().top + (blogWrapper.offsetHeight / 1.2);
  var clientsList = document.querySelector('.clients__list');
  var clientsListCoords = clientsList.getBoundingClientRect().top + (clientsList.offsetHeight / 1.4);
  // var pageSize = window.innerWidth;
  // var pageHeight = window.innerHeight;
  var windowHeight = document.documentElement.clientHeight;
  var bottomHeightValue = 0;


  // var ResolutionWidth = {
  //   'BIG': 2099,
  //   'SMALL': 1400,
  //   'MOBILE': 1080,
  //   'TABLET': 1020,
  //   'BIG_PHONE': 767,
  //   'SMALL_PHONE': 374
  // };

  window.addEventListener('scroll', function () {

    bottomHeightValue = windowHeight + window.pageYOffset;
    // console.log(blogWrapperCoords)
      if (bottomHeightValue >= statisticsCoords) {
        startAllNumbers();
      }
      if (bottomHeightValue >= extrasListCoords) {
        extrasList.classList.add('extras__list--show');
      }
      if (bottomHeightValue >= casesListCoords) {
        casesList.classList.add('cases__list--show');
      }
      if (bottomHeightValue >= blogWrapperCoords) {
        blogWrapper.classList.add('blog__wrapper--show');
      }
      if (bottomHeightValue >= clientsListCoords) {
        clientsList.classList.add('clients__list--show');
      }
  })



}());