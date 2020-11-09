(function () {
  var pageHeader = document.querySelector('.page__header');
  var introduction = document.querySelector('.introduction');
  var currentIntroductionMarginTop = parseInt(getComputedStyle(introduction).marginTop, 10);
  var currentPageWidth = document.documentElement.clientWidth;

  var ResolutionWidth = {
    'BIG': 2099,
    'SMALL': 1400,
    'MOBILE': 1080,
    'TABLET': 1020,
    'BIG_PHONE': 767,
    'SMALL_PHONE': 374
  };
  var IntroductionMarginTopValue = {
    'BIG': 82,
    'MIDDLE': 55.6,
    'SMALL': 49,
    'MOBILE': 142.5,
    'TABLET': 99.75,
    'BIG_PHONE': 48.8,
    'SMALL_PHONE': 41.48
  };

  window.addEventListener('resize', function () {
    currentPageWidth = document.documentElement.clientWidth;

    if (currentPageWidth > ResolutionWidth.BIG) {
      currentIntroductionMarginTop = IntroductionMarginTopValue.BIG;
    } else if (currentPageWidth <= ResolutionWidth.BIG && currentPageWidth > ResolutionWidth.SMALL) {
      currentIntroductionMarginTop = IntroductionMarginTopValue.MIDDLE;
    } else if (currentPageWidth <= ResolutionWidth.SMALL && currentPageWidth > ResolutionWidth.MOBILE) {
      currentIntroductionMarginTop = IntroductionMarginTopValue.SMALL;
    } else if (currentPageWidth <= ResolutionWidth.MOBILE && currentPageWidth > ResolutionWidth.TABLET) {
      currentIntroductionMarginTop = IntroductionMarginTopValue.MOBILE;
      unlockHeader();
    } else if (currentPageWidth <= ResolutionWidth.TABLET && currentPageWidth > ResolutionWidth.BIG_PHONE) {
      currentIntroductionMarginTop = IntroductionMarginTopValue.TABLET;
      unlockHeader();
    } else if (currentPageWidth <= ResolutionWidth.BIG_PHONE && currentPageWidth > ResolutionWidth.SMALL_PHONE) {
      currentIntroductionMarginTop = IntroductionMarginTopValue.BIG_PHONE;
      unlockHeader();
    } else if (currentPageWidth <= ResolutionWidth.SMALL_PHONE) {
      currentIntroductionMarginTop = IntroductionMarginTopValue.SMALL_PHONE;
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
      checkWindowPosition(lockHeader, unlockHeader)
    }
  });
}());