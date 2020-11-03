(function () {
  var questionsButton = document.querySelector('.questions__button');
  var modalWindow = document.querySelector('.modal-window');
  var closeButton = document.querySelector('.modal-window__close-btn');
  var applyButton = document.querySelector('.modal-window__apply-btn');
  var pageMain = document.querySelector('.page__main');
  var pageHeader = document.querySelector('.page__header');
  var body = document.querySelector("body");
  var contactsIframe = document.querySelector('.contacts__iframe')
  var allLinks = body.querySelectorAll('a');
  var allButtons = body.querySelectorAll('button');

  var removeTabNavigation = function (array) {
    for (var i = 0; i < array.length; i++) {
      if (array[i] === closeButton || array[i] === applyButton) {
        continue;
      }
      array[i].setAttribute('tabindex', '-1');
    }
    contactsIframe.style.display = 'none';
  };

  var addTabNavigation = function (array) {
    for (var i = 0; i < array.length; i++) {
      array[i].setAttribute('tabindex', '0');
    }
    contactsIframe.style.display = 'block';
  };

  questionsButton.addEventListener('click', () => {
    modalWindow.classList.add('modal-window__overlay--open');
    setTimeout(function () {
      pageMain.classList.add('filter-blur');
    }, 300);
    setTimeout(function () {
      pageHeader.classList.add('filter-blur');
    }, 300);
    body.classList.add('modal-open');
    removeTabNavigation(allLinks);
    removeTabNavigation(allButtons);
  })

  closeButton.addEventListener('click', () => {
    modalWindow.classList.remove('modal-window__overlay--open');
    pageMain.classList.remove('filter-blur');
    pageHeader.classList.remove('filter-blur');
    body.classList.remove('modal-open');
    addTabNavigation(allLinks);
    addTabNavigation(allButtons);
  })
}());