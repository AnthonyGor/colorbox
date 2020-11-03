(function () {
  var pageHeader = document.querySelector('.page__header');
  var introduction = document.querySelector('.introduction');
  var currentIntroductionMarginTop = parseInt(getComputedStyle(introduction).marginTop, 10);
  var currentPageWidth = document.documentElement.clientWidth;

  var ResolutionWidth = {
    'BIG': 2099,
    'SMALL': 1400,
    'MOBILE': 1079
  };
  var IntroductionMarginTopValue = {
    'BIG': 82,
    'MIDDLE': 55.6,
    'SMALL': 49,
    'MOBILE': 150
  };

  window.addEventListener('resize', function () {
    currentPageWidth = document.documentElement.clientWidth;

    if (currentPageWidth > ResolutionWidth.BIG) {
      currentIntroductionMarginTop = IntroductionMarginTopValue.BIG;
    } else if (currentPageWidth <= ResolutionWidth.BIG && currentPageWidth > ResolutionWidth.SMALL) {
      currentIntroductionMarginTop = IntroductionMarginTopValue.MIDDLE;
    } else if (currentPageWidth <= ResolutionWidth.SMALL && currentPageWidth > ResolutionWidth.MOBILE) {
      currentIntroductionMarginTop = IntroductionMarginTopValue.SMALL;
    } else if (currentPageWidth <= ResolutionWidth.MOBILE) {
      currentIntroductionMarginTop = IntroductionMarginTopValue.MOBILE;
      unlockHeader();
    }

    introduction.style.marginTop = currentIntroductionMarginTop + 'px';
  });


  var lockHeader = function () {
    pageHeader.style.position = 'fixed';
    pageHeader.style.left = '50%';
    pageHeader.style.transform = 'translateX(-50%)';

    headHeightCompensation();
  };


  var headHeightCompensation = function () {
    var headerHeight = pageHeader.offsetHeight;

      introduction.style.marginTop = headerHeight + currentIntroductionMarginTop + 'px';
  };

  var unlockHeader = function () {
    pageHeader.style.position = 'static';
    pageHeader.style.left = '0';
    pageHeader.style.transform = 'translateX(0)';

    introduction.style.marginTop = currentIntroductionMarginTop + 'px';
  };

  var checkWindowPosition = function (callback1, callback2) {
    window.pageYOffset > 1 ? callback1() : callback2();
  };

  window.addEventListener('scroll', function () {

    if (currentPageWidth > ResolutionWidth.MOBILE) {
      console.log(currentPageWidth)
      checkWindowPosition(lockHeader, unlockHeader)
    }
  });
}());