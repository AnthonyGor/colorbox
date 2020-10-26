$(document).ready(function(){


//alert('qq');
var_img = 1;
var i = 0;
arr = new Array();
$('ul.slide li').each(function ()
{
   i = i+1;
   arr[i]=$(this).find('a').attr('href');
}

)


var_img = 1;
var_count = i; //кол-во фоток в слайдере
//$("#slide").attr('src',arr[var_img]);


    $(".btn_left").click(function(){
    
    //alert('qq');
            
        if (var_img == 1)
          var_img = var_count;
        else
          var_img = var_img - 1;
        //$("#slide").attr('src',arr[var_img]);
        return false;
    });
    $(".btn_right").click(function(){
        
        //alert(var_img);
        if (var_img == var_count)
          var_img = 1;
        else
          var_img = var_img + 1;
          
        $("#slide_cont").html(
            "<img src='" + arr[var_img] + "' id='slide' alt='' border='0'>");

      //  $("#slide").attr('src',arr[var_img]);
        return false;
    });
});
