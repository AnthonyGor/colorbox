(function () {
  var sliderTrack = document.querySelector('.slider-track');
  var sliderAllItem = sliderTrack.children;
  var buttonLeft = document.querySelector('.slider__button--left');
  var buttonRight = document.querySelector('.slider__button--right');
  var itemCopy = {};
  var scrollLeftWidth = sliderAllItem[0].offsetWidth;
  var scrollRightWidth = sliderAllItem[sliderAllItem.length - 1].offsetWidth;
  var itemMarginRight = parseInt(window.getComputedStyle(sliderAllItem[0], null).getPropertyValue('margin-right'), 10);
  sliderTrack.style.position = 'relative';
  // sliderTrack.style.left = (scrollRightWidth + itemMarginRight) * -1 + 'px';
  sliderTrack.style.left = 0;

  var sliderInitiate = function () {
    sliderTrack.style.position = 'relative';
    sliderTrack.style.left = 0;
    scrollLeftWidth = sliderAllItem[0].offsetWidth;
    scrollRightWidth = sliderAllItem[sliderAllItem.length - 1].offsetWidth;
    itemMarginRight = parseInt(window.getComputedStyle(sliderAllItem[0], null).getPropertyValue('margin-right'), 10);
  }

  /*moveLeft function start*/
  var moveLeft = () => {
    sliderTrack.style.left = parseInt(sliderTrack.style.left) - (scrollLeftWidth + itemMarginRight) + 'px';

    buttonLeft.removeEventListener('click', moveLeft); //cancel handler

    /*move first element start*/
    itemCopy = sliderAllItem[0].cloneNode(true);
    sliderTrack.appendChild(itemCopy);
    /*move first element end*/

    function removeItem() {
      sliderTrack.style.left = 'auto';

      sliderAllItem[0].remove();
      setTimeout(() => {
        sliderTrack.style.left = 0
      }, 20);

      buttonLeft.addEventListener('click', moveLeft);
      isMoved = false;
    }

    setTimeout(removeItem, 700)
  };
  /*moveLeft function end*/

  /*moveRight function start*/
  var moveRight = () => {
    sliderTrack.style.left = parseInt(sliderTrack.style.left) + (scrollRightWidth + itemMarginRight) + 'px';

    buttonRight.removeEventListener('click', moveRight); //cancel handler

    function moveLastElementToStart() {
      sliderTrack.style.left = 'auto';
      itemCopy = sliderAllItem[sliderAllItem.length - 1].cloneNode(true);

      var theFirstChild = sliderTrack.firstChild;
      sliderTrack.insertBefore(itemCopy, theFirstChild);

      sliderAllItem[sliderAllItem.length - 1].remove();
      setTimeout(() => {
        sliderTrack.style.left = 0
      }, 20);

      buttonRight.addEventListener('click', moveRight);
      isMoved = false;
    }

    setTimeout(moveLastElementToStart, 700)
  };
  /*moveRight function end*/

  /*drag and drop start*/

  var isMoved = false;

  var touchStart = function (startEvent, callback1, callback2) {
    var startX = startEvent.changedTouches[0].clientX;

    var touchMove = function (moveEvent) {
      var shiftX = startX - moveEvent.changedTouches[0].clientX;

      if (shiftX > 0) {
        callback1();
        sliderTrack.removeEventListener('touchmove', touchMove);
        isMoved = true;
      } else {
        callback2();
        sliderTrack.removeEventListener('touchmove', touchMove);
        isMoved = true;
      }
    };

    var touchEnd = function () {
      sliderTrack.removeEventListener('touchmove', touchMove);
      sliderTrack.removeEventListener('touchend', touchEnd);
    };
    sliderTrack.addEventListener('touchmove', touchMove);
    sliderTrack.addEventListener('touchend', touchEnd);
  }
  /*drag and drop end*/

  /*add handlers*/
  buttonLeft.addEventListener('click', moveLeft);
  buttonRight.addEventListener('click', moveRight);
  sliderTrack.addEventListener('touchstart', function (event) {
    if (!isMoved) touchStart(event, moveLeft, moveRight);
  });
  window.addEventListener('resize', sliderInitiate);
}());
