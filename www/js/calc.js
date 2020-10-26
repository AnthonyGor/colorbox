$(document).ready(function(){
/*$.ajax({
	url: "/calc/calc_broshura.htm",
	cache: false,
	success: function(html){
     	$("#content").html(html);
	}
});*/

			$('#select_calc').change(function(){
                  $.ajax({
						url: "/calc/calc_"+$('#select_calc').val()+".htm",
						cache: false,
						success: function(html){
							$("#content").html(html);
							$('#otvet #val').html('&nbsp;');
						}
					});
               });

$('.calc_price').click(
  function()
  {
    var type = $('select[@name=calc] option:selected').val();
    
    //alert(type);
    
    if ('presentation' == type)
    {
      $('.warn').text('');
      
      var sides = $('input[@name=sides]').val();
      //alert(sides);
      //alert(isNaN(sides));
      
      
      if (isNaN(sides) || '' == sides)
      {
        $('.warn').text('Число полос должно быть числом');
        return false;
      }
      
      var count = $('input[@name=count]').val();
      if (isNaN(count) || '' == count)
      {
        $('.warn').text('Тираж должен быть числом');
        return false;
      }
    
    }  


   $('#form').ajaxSubmit(function(data) {
	   //alert(data);
	    //alert($('#otvet #val').text());
      $('#otvet #val').text(data);
	     return false;
	   });
	  
	 return false;
	});

});