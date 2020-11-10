(function () {

  const allFrameItem = document.querySelectorAll('.cases__item');

  const getSide = (event, elem) => {

    const elemBounding = elem.getBoundingClientRect();
    const elementLeftEdge = elemBounding.left;
    const elementTopEdge = elemBounding.top;
    const elementRightEdge = elemBounding.right;
    const elementBottomEdge = elemBounding.bottom;

    const mouseX = event.clientX;
    const mouseY = event.clientY;

    const topEdgeDist = Math.abs(elementTopEdge - mouseY);
    const bottomEdgeDist = Math.abs(elementBottomEdge - mouseY);
    const leftEdgeDist = Math.abs(elementLeftEdge - mouseX);
    const rightEdgeDist = Math.abs(elementRightEdge - mouseX);

    const min = Math.min(topEdgeDist, bottomEdgeDist, leftEdgeDist, rightEdgeDist);

    switch (min) {
      case topEdgeDist:
        return 'top';
      case leftEdgeDist:
        return 'left';
      case rightEdgeDist:
        return 'right';
      case bottomEdgeDist:
        return 'bottom';
    }
  }

  const takeRequiredPosition = (element, side, flag) => {
    const frameDescription = element.querySelector('.cases-frame__description');

    switch (side) {
      case 'top':
        frameDescription.style.right = 'auto';
        frameDescription.style.left = '0';
        frameDescription.style.top = '-100%';
        frameDescription.style.bottom = 'auto';
        break
      case 'bottom':
        frameDescription.style.right = 'auto';
        frameDescription.style.left = '0';
        frameDescription.style.top = 'auto';
        frameDescription.style.bottom = '-100%';
        break
      case 'left':
        frameDescription.style.right = 'auto';
        frameDescription.style.left = '-100%';
        frameDescription.style.top = '0';
        frameDescription.style.bottom = 'auto';
        break
      case 'right':
        frameDescription.style.right = '-100%';
        frameDescription.style.left = 'auto';
        frameDescription.style.top = '0';
        frameDescription.style.bottom = 'auto';
        break
    }
  }

  const takePositionOnAnElement  = element => {
    const frameDescription = element.querySelector('.cases-frame__description');
    if (parseInt(frameDescription.style.left) < 0) {
      frameDescription.style.left = '0';
    } else if (parseInt(frameDescription.style.right) < 0) {
      frameDescription.style.right = '0';
    } else if (parseInt(frameDescription.style.top) < 0) {
      frameDescription.style.top = '0';
    } else if (parseInt(frameDescription.style.bottom) < 0) {
      frameDescription.style.bottom = '0';
    }
  }

  const frameItemMouseEnterHandler = element => {
    element.addEventListener('mouseenter', event => {
      takeRequiredPosition(element, getSide(event, element));
      setTimeout(takePositionOnAnElement, 0, element)
    })
  }

  const frameItemMouseLeaveHandler = element => {
    element.addEventListener('mouseleave', event => {
      takeRequiredPosition(element, getSide(event, element));
    })
  }


  allFrameItem.forEach(element => frameItemMouseEnterHandler(element));
  allFrameItem.forEach(element => frameItemMouseLeaveHandler(element));

}());

































