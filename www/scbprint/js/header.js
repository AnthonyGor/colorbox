(function () {
  var pageHeader = document.querySelector('.page__header');
  var introduction = document.querySelector('.introduction');
  var currentIntroductionMarginTop = parseInt(getComputedStyle(introduction).marginTop, 10);
  var currentWindowWidth = window.screen.width;
  var ResolutionWidth = {
    'MIDDLE': 1850,
    'SMALL': 1400,
    'MOBILE': 1080
  }
  var IntroductionMarginTopValue = {
    'BIG': 82,
    'MIDDLE': 65.6,
    'SMALL': 55.76
  }

  window.addEventListener('resize', function () {
    currentWindowWidth = window.screen.width;

    if (currentWindowWidth > ResolutionWidth.MIDDLE) {
      currentIntroductionMarginTop = IntroductionMarginTopValue.BIG;
    } else if (currentWindowWidth <= ResolutionWidth.MIDDLE && currentWindowWidth > ResolutionWidth.SMALL) {
      currentIntroductionMarginTop = IntroductionMarginTopValue.MIDDLE;
    } else if (currentWindowWidth <= ResolutionWidth.SMALL) {
      currentIntroductionMarginTop = IntroductionMarginTopValue.SMALL;
    } else if (currentWindowWidth <= ResolutionWidth.MOBILE) {
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
    if (currentWindowWidth > ResolutionWidth.MOBILE) {
      checkWindowPosition(lockHeader, unlockHeader)
    }
  });
}());