

$(function() {


  var white = false;
  
  


 setInterval(function countDown()
  {
    if (white)
      $('a.blinked').css({color:'#0041aa'});
    else
      $('a.blinked').css({color:'white'});
    
    white = !white;
  }, 1000);
  
  
      if ($('#slider1').length > 0)
          $('#slider1').s3Slider({
            timeOut: 6000
        });


  function mycarousel_initCallback(carousel) {
    
    jQuery('.photos_1').bind('click', function() {
        
        var id = $(this).attr("id");
        id = (id.substring(3)) - 0;
        //alert(id);
        
        carousel.scroll(id, false);
        return false;
    });
      
  }

  if ($('.mycarousel').length > 0)
	{
    $('.mycarousel').jcarousel({
		  scroll:1
		  ,	  	initCallback: mycarousel_initCallback
	   });
	}


});




 
 
 
