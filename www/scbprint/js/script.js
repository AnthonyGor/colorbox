(function () {
  const questionsButton = document.querySelector('.questions__button');
  const  modalWindow = document.querySelector('.modal-window');
  const closeButton = document.querySelector('.modal-window__close-btn');
  const pageMain = document.querySelector('.page__main');
  const pageHeader = document.querySelector('.page__header');
  const body = document.querySelector("body");

  questionsButton.addEventListener('click', () => {
    modalWindow.classList.add('modal-window__overlay--open');
    pageMain.classList.add('filter-blur');
  })

  closeButton.addEventListener('click', () => {
    modalWindow.classList.remove('modal-window__overlay--open');
    pageMain.classList.remove('filter-blur');
  })
}());