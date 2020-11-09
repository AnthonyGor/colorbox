(function () {
  var extrasList = document.querySelector('.extras__list');
  var casesList = document.querySelector('.cases__list')
  var blogWrapper = document.querySelector('.blog__wrapper');
  var clientsList = document.querySelector('.clients__list');
  var pageSize = window.innerWidth;

  window.addEventListener('scroll', function () {
    // console.log(window.pageYOffset)

    if (pageSize >= 1400) {
      if (window.pageYOffset >= 1300) {
        extrasList.classList.add('extras__list--show');
      }
      if (window.pageYOffset >= 2500) {
        casesList.classList.add('cases__list--show');
      }
      if (window.pageYOffset >= 3900) {
        blogWrapper.classList.add('blog__wrapper--show');
      }
      if (window.pageYOffset >= 4600) {
        clientsList.classList.add('clients__list--show');
      }
    } else {
      extrasList.classList.add('extras__list--show');
      casesList.classList.add('cases__list--show');
      blogWrapper.classList.add('blog__wrapper--show');
      clientsList.classList.add('clients__list--show');
    }
  })
}());