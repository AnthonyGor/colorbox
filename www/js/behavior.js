$(function() {

/* modal windows */
var modalLink = $('a.call-back'),
    modalWindow = $('.modal'),
    cross = $('.cross');
 
modalLink.click(function(){
  modalWindow.toggleClass('active');

    cross.click(function(){
      modalWindow.removeClass('active');
    });

  return false;
});

});