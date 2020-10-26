
//alert('1111');

$(document).ready(function(){

//alert('222');
//alert('qq');
var_img = 1;
var i = 0;
arr = new Array();
$('#slide_cont img').each(function ()
{
   i = i+1;
   arr[i]=$(this).attr('id');
}

)


var_img = 1;
var_count = i; 

    $(".btn_left").click(function(){
    
    //alert('qq');
       //$('#'+arr[var_img]).hide();
      $('#slide_cont img').hide();
        if (var_img == 1)
          var_img = var_count;
        else
          var_img = var_img - 1;
        
      $('#'+arr[var_img]).show();
      //$("#slide").attr('src',arr[var_img]);
        return false;
    });
    $(".btn_right").click(function(){
        
        //alert(var_img);
        $('#slide_cont img').hide();
        if (var_img == var_count)
          var_img = 1;
        else
          var_img = var_img + 1;
      
      $('#'+arr[var_img]).show();
        //$("#slide_cont").html(
          //  "<img src='" + arr[var_img] + "' id='slide' alt='' border='0'>");

      //  $("#slide").attr('src',arr[var_img]);
        return false;
    });
});
