<?php

function print_header()
{
  $out = "
  
  <div id='flash_content' align=center>

</div>
<script type=text/javascript>
   var so = new SWFObject('/images/flash2.swf', 'movie', '980', '157', '8', '#FFFFFF');
   so.addVariable('variable', 'value');
   so.addParam('wmode', 'transparent');
   so.write('flash_content');
</script>

<div class = 'to_main'>
<A href = '/'> </A>
<div class = 'bg_flash'> </div>
</div>";
/*
<!-- style = 'background-image: url(/images/pic2.jpg); '
<table cellpadding='0' cellspacing='0'><tr><td align='left' valign='top'>
<a href='/'><img src='/images/pic2_01.jpg' height = '37px' border='0' /></a>
</td><td align='left' valign='top'>
<img src='/images/pic2_02.jpg' border='0' />
</td></tr>
</table>-->

*/  
  return $out;

}

function link_skidki()
{
  return "?skidki=1#r2"; 
}

function browse_tabs_row2()
{
  $r2_data = array();
  
  $r2_data_el[name] = 'О нас';
  $r2_data_el[link] = '?onas=1';
  $r2_data_el[sub] = '93';
  $r2_data[] = $r2_data_el;
   
  $r2_data_el[name] = 'Оборудование';
  $r2_data_el[link] = '?oborud=1';
  $r2_data_el[sub] = '94';
  $r2_data[] = $r2_data_el;

  $r2_data_el[name] = 'Техпомощь';
  $r2_data_el[link] = '?tech=1';
  $r2_data_el[sub] = '95';
  $r2_data[] = $r2_data_el;

  $out = "<table style = 'margin-left: 22px;' width='720' border='0' 
cellpadding='0' cellspacing='0' class='td_works'><tr>";
 

  $els_out = array(); 
  foreach ($r2_data as $el) 
  {
    $sub_e = get_row("SELECT * FROM Subdivision 
                            WHERE Subdivision_ID = '$el[sub]'");
    
  	$els_out[] = "<td align='left' width='234'><a href='$el[link]#r2' 
                        class='menu2'>$el[name]</a>".opt(!have_param_sub(), "
<p>$sub_e[Description] <a class = 'more' href='$sub_e[Hidden_URL]'>
            <img src='/images/btn_next.jpg' alt='' border='0'></a></p>")."
            </td>";
  }
  
  $out .= implode("<td align='left' width='11' height='67'><img src='/images/nbsp.gif' width='11' height='1' border='0' hspace='0' vspace='0'></td>", 
            $els_out);
  
  $out .= "</tr></table>";  
  return $out;
}


function have_param_sub()
{
  $pars = array('skidki' => 181, 
            'oborud' => 182, 'tech' => '183', 'onas' => '180');
   
  $load_sub = 0;
  foreach ($pars as $k =>$v) 
  {
     if ($_REQUEST[$k])
       $load_sub = $v; 	
  }
  
  return $load_sub;         
}


function process_param_down()
{
  $load_sub = have_param_sub();
  
  if (!$load_sub)
    return '';
    
  $current_sub = get_row("SELECT * FROM Subdivision 
                            WHERE Subdivision_ID = '$load_sub'");
                            
  $out = "<div class ='text_tubs ".$current_sub[EnglishName]."_page'>";
  
  $out .= "<A name = 'r2'></A>";
  
  
  $out .= get_var("SELECT TextContent FROM Message91
                      WHERE Subdivision_ID = '$load_sub'");
  
  if ($load_sub == 181)
    $out .= s_list_class(181, 353, '');
  
  $out .= "</div>";
  
  return $out;

}


function make_title()
{
  global $sub, $action, $tag;
  global $f_Name;
  global $f_ForTitle;
  global $f_title;
  global $browse_path;
  global $current_sub;
  global $f_Model, $f_Users;
  
  if (($action == 'full') && ($f_Name != ''))
    return $f_Name;
  else
  {
    if ($current_sub[inSEO])
    {
      return $current_sub[SEOTitle];
    }
    else
      return $current_sub[Subdivision_Name];   
  }
  
  /*if ($current_sub[myTitle] && ($action != 'full'))
    return $current_sub[myTitle];
  
  if (80 == $sub)
    return "Карта сайта";
    
  
  
  if ((127 == $sub) && ($action == 'full'))
    return $f_Name;

  if ((101 == $sub) && ($action == 'full'))
  {
    if ($f_Users < 8)
      return "Станция $f_Model для дачной канализации";

    if ($f_Users < 50)
      return "Станция $f_Model для канализации в частном доме";

    return "Станция $f_Model для канализации в коттеджном поселке";

    
  }


  if ((111 == $sub) && ($action == 'full'))
    return $f_Name;


    
  if ((127 == $sub) && ($action != 'full'))
  {
    if ($tag)
      return "Статьи по теме: ".get_var("SELECT Tag_Text FROM Tags_Data WHERE Tag_ID = '$tag'");
    else
      return "Информация по выбору очистных сооружений ТополВатер для автономной канализации в частном доме";
  }
    
    /*.
opt($action == 'full', " | ")."Очистные сооружения Топас для автономной канализации частного дома"*/;
  /*if (127 != $sub)
    return opt($f_ForTitle, "$f_ForTitle - ")."".$current_sub[Subdivision_Name];

*/
}



function ImplodeMask($format, $arr)
{
  $out = '';
  
  if ($arr)
    foreach ($arr as $k => $v) 
    {
      $tmp = $format;
      $tmp = str_replace('%ID', $k, $tmp);
      $tmp = str_replace('%DATA', $v, $tmp);
      
      $out .= $tmp;
      
    }
  
  return $out;
}


function PrintCalc()
{
  return "	        <div class='calc'>
               <div class='calccontent' style='text-align: left;'>
                    <h1 style = 'font-weight: bold'>Калькулятор для срочных тиражей типовой продукции <br>(цифровая печать)</h1>
					<form id='form' action = '/calc/calc.php' method = 'get'>
                        <SELECT id='select_calc' class='fnt' name='calc'>
						    <OPTION value='vizitka' selected>визитки</OPTION>
							<OPTION value='broshura'>брошюры</OPTION>
							<OPTION value='buklet'>буклеты</OPTION>
							<OPTION value='convert'>конверты</OPTION>
							<OPTION value='calendar'>календари карманные</OPTION>
							<OPTION value='presentation'>презентация</OPTION>
					    </select>
					    <div id='content'>

".file_get_contents($_SERVER['DOCUMENT_ROOT'].'/calc/calc_vizitka.htm')."
</div>
					    <br />
					    <div align='right'><a href='' 
class='calc_price'>Рассчитать</a></div>
					    <p class='calc_price' style = 'min-height: 20px;' id='otvet'><span id ='val'>&nbsp;</span> 
</p> 
					    <div align='right'>
<A href = '/zakaz'><img border  ='0' alt='Cделать заказ' src='/images/btn_grey_small.jpg'/></A>
</div>

<!-- <button 
style='border: none; margin: 0px; padding: 0px;
background: none; text-align:left;' type='submit' >
</button> -->

					</form>

               </div>
<p style = 'text-align: left; font-size: 10px; margin: 5px;'>* Пожалуйста, позвоните и уточните <br>у наших
специалистов окончательную цену.</p>
	        </div>";

}

function BrowseHoverSubs($fromSub, $colNums)
{
  $out = "<table width='100%' valign='top' style='margin-top:0px;margin-bottom:0px; padding-right: 4px;' cellpadding=0 cellspacing=0><tr>";
  

  $sql = "SELECT * FROM Subdivision WHERE Parent_Sub_ID = '$fromSub' 
                                      AND ShowMainIcon
                                      AND Checked
                                      ORDER BY Priority";
  $q = mysql_query($sql);
  
  //$colNums = 5;
  $f_RowNum = 0;
  
  while ($sub = mysql_fetch_array($q))
  {
    if (!($f_RowNum%$colNums) && $f_RowNum)
          $out .= '</tr><tr>';
          
    $img = nc_file_path('Subdivision', $sub[Subdivision_ID], 'ImgMain');
    $imgHover = nc_file_path('Subdivision', $sub[Subdivision_ID], 'ImgMainHover');
    
    $out .= "
        
        <td width='28'></td>
        <td width='124' valign=top align='left' style='padding-bottom:13px;'>
          <table cellpadding=0 cellspacing=0 align='left'>
            <tr>
              <td valign='top' align='center' width='124'  height='117'>
                <a href='$sub[Hidden_URL]'>
                <img src = '$img' onmouseover='this.src=\"$imgHover\"' 
                onmouseout='this.src=\"$img\"' align='center' 
                style='border:0px solid #00824C;'></a>
              </td>
            </tr>
            <tr>
              <td valign='top' align='center' 
                  style='padding-bottom:6px;'>
                 <p align='center'>
                  <a class = 'grey_bold_11' href='$sub[Hidden_URL]'>$sub[Subdivision_Name]</a>
                 </p>
              </td>
            </tr>
          </table>
        </td>
        ";
    //padding-top:10px;
    $f_RowNum++;
         
  }
  
  if ($f_RowNum%$colNums)
    $out .= str_repeat('<td>&nbsp;</td>',$colNums-$f_RowNum%$colNums);
    
  $out .= "</table>";
  
  
  return $out;

}



function addjs($file)
{
  if (false)
    return "<script type='text/javascript' language='JavaScript'>".
            file_get_contents($_SERVER['DOCUMENT_ROOT'].$file).
              "</script>";
  else
    return "<script src='$file' type='text/javascript' 
                language='JavaScript'></script>";
}


function ShowSlider($fromSub)
{
  $out = "
    <div id='slider1'>
      <ul id='slider1Content'>";
  
  $sql = "SELECT * FROM Subdivision WHERE Parent_Sub_ID = '$fromSub' 
                                      AND ShowMainSlider
                                      AND Checked
                                      ORDER BY Priority";
  $q = mysql_query($sql);
  
  while ($sub = mysql_fetch_array($q))
  {
    $img = nc_file_path('Subdivision', $sub[Subdivision_ID], 'ImgSlider');
    
    if (1 == $sub[TextPosSlider])
      $class = 'left';
    else
      $class = 'right';
     
       
    $out .= "<li class='slider1Image'>
                    <a href='$sub[Hidden_URL]'>
                    <img src='$img' alt='1' /></a>
                    <span class='$class'>
                    <h1>$sub[Subdivision_Name]</h1>
                    <h7>$sub[TextSlider]</h7></span></li>";
         
  }
 
  $out .= "<div class='clear slider1Image'></div></ul></div>";
   
  return $out;
}


function CheckDiscCart($email)
{
  $email = strval($email);
  $sql = "SELECT DiscNo FROM Message92 WHERE Email = '$email'";
  $cart = get_var($sql);
  
  if (($cart != '') && ($cart != -1))
    return sprintf("%05d", $cart);
  else
    return '';
}

function NewDiscCart($msgID)
{
  $max = get_var("SELECT MAX(DiscNo) FROM Message92");
  
  $cart = $max + 1;
  
  $sql = "UPDATE Message92 SET DiscNo = $cart WHERE Message_ID = $msgID";
  
  mysql_query($sql);
  
  return sprintf("%05d", $cart);
}

function GetCC($type, $sub_use = 0)
{
  global $sub;
  
  if (!$sub_use)
    $sub_use = $sub;
  
  if ($type == 'OfsetTable')
    $class = 90;

  if ($type == 'Portfolio')
    $class = 65;

  if ($type == 'PortfolioList')
    $class = 84;

  if ($type == 'Remark')
    $class = 94;

  if ($type == 'Base')
    $class = 1;
  
  if (1 == $class)
    $sql = "SELECT Sub_Class_ID FROM Sub_Class 
                      WHERE (Class_ID = $class OR Class_ID = 91)
                         AND Subdivision_ID = $sub_use";
  else
    $sql = "SELECT Sub_Class_ID FROM Sub_Class 
                      WHERE Class_ID = $class 
                         AND Subdivision_ID = $sub_use";

  //hr($sql);
  
  return get_var($sql);
}

function contact_block()
{
  return "
  <table width='980' height='82' border='0' cellpadding='0' cellspacing='0'>
      <tr>
        <td align='left' valign='top'>


<table border='0' cellspacing='0' cellpadding='0' width = '525' class = 'cont-info'>
          <tr>
            <td rowspan='2' class = 'i' width ='34'>
<img src='/images/phone.jpg' width='34' height='35'></td>
            <td width='120' class='black_normal_14_font'>8 (925) <strong>508-7240</strong></td>
            
<td width='21'  class ='icq'>
<img height = '18' width = '18' src=http://wwp.icq.com/scripts/online.dll?icq=238972394&img=5>
</td>
            <td width='145'>
<a class=icq href=http://www.icq.com/people/about_me.php?uin=238972394>238972394</a>
</td>          

        <td rowspan = '4' width = '37' class = 'i'><img 
src='/images/i.jpg' width='36' height='35'></td>
  
  <td  width = '110'>
            <b><a href='/contact' class='black_bold_14'>контакты</a></b></td>
 
 
            </tr>
            
            
            
          <tr>
            <td class='black_normal_14_font'>8 (499) <strong>257-1478</strong></td>
            
            
<td class ='icq'>
<img height = '18' width = '18' src=http://wwp.icq.com/scripts/online.dll?icq=393617917&img=5>
</td>
            <td>
<a class=icq href=http://www.icq.com/people/about_me.php?uin=393617917>393617917</a>
</td>


<td>
<b><a href='/map' class='black_bold_14'>карта сайта</a></b></td>

            
            </tr>
          <tr>
<td rowspan ='2'>
<img src='/images/fax.jpg' width='34' height='35' class = 'fax'></td>
          
            <td class='black_normal_14_font'>8 (499) <strong>257-1429</strong></td>

<td class ='icq'>
<img height = '18' width = '18' src=http://wwp.icq.com/scripts/online.dll?icq=67826789&img=5 >
</td>
            <td >
<a class=icq href=http://www.icq.com/people/about_me.php?uin=67826789>67826789</a>
</td>

<td ><b><a href='/price' class='black_bold_14'>прайс-лист</a></b></td>


            </tr>


          <tr class = 'last'>
            <td width='206' class='black_normal_14_font'>8 (499) <strong>257-1478</strong></td>
            
            
<td class ='icq'>
<img height = '18' width = '18' src=http://wwp.icq.com/scripts/online.dll?icq=593731167&img=5 >
</td>
            <td>
<a class=icq href=http://www.icq.com/people/about_me.php?uin=593731167>593731167</a>
</td>            

<td>
<b><a href='/zakaz' class='black_bold_14'>заказ-онлайн</a></b></td>
            
            </tr>
        </table>
        



</td>
      </tr>
    </table>
  ";
  /*return "      
    <table width='980' height='82' border='0' cellpadding='0' cellspacing='0'>
      <tr>
        <td width='216' align='left' valign='top'>


<table width='200' border='0' cellspacing='0' cellpadding='0'>
          <tr>
            <td rowspan='4' valign='top' style='padding-right:7px;'>
<img src='/images/phone.jpg' width='34' height='35'>
<img src='/images/fax.jpg' width='34' height='35' class = 'fax'></td>
            <td width='206' align='left' class='black_normal_14_font' style='padding-bottom:3px;'>8 (495) <strong>508-7240</strong></td>
            </tr>
          <tr>
            <td align='left' class='black_normal_14_font' style='padding-bottom:3px;'>8 (499) <strong>257-1478</strong></td>
            </tr>
          <tr>
            <td align='left' class='black_normal_14_font' style='padding-bottom:3px;'>8 (499) <strong>257-1429</strong></td>
            </tr>

          <tr>
            <td width='206' align='left' class='black_normal_14_font' style='padding-bottom:3px;'>8 (499) <strong>257-1478</strong></td>
            </tr>
        </table>
        
        </td>
        <td width='134' align='left' valign='top'>

<table width='125' border='0' cellspacing='0' cellpadding='0'>
          <tr>
            <td width='19' align='left' class ='icq'>
<img src=http://wwp.icq.com/scripts/online.dll?icq=238972394&img=5 align=left>
</td>
            <td width='106' align='left'>
<a class=icq href=http://www.icq.com/people/about_me.php?uin=238972394>238972394</a>
</td>
            </tr>
          <tr>
            <td align='left' class ='icq'>
<img src=http://wwp.icq.com/scripts/online.dll?icq=393617917&img=5 align=left>
</td>
            <td align='left'>
<a class=icq href=http://www.icq.com/people/about_me.php?uin=393617917>393617917</a>
</td>
            </tr>
          <tr>
            <td align='left' class ='icq'>
<img src=http://wwp.icq.com/scripts/online.dll?icq=67826789&img=5 align=left>
</td>
            <td align='left' >
<a class=icq href=http://www.icq.com/people/about_me.php?uin=67826789>67826789</a>
</td>
            </tr>

          <tr>
            <td align='left' class ='icq'>
<img src=http://wwp.icq.com/scripts/online.dll?icq=593731167&img=5 align=left>
</td>
            <td align='left'>
<a class=icq href=http://www.icq.com/people/about_me.php?uin=593731167>593731167</a>
</td>
            </tr>

        </table>

</td>
        <td align='left' valign='top'><table width='169' border='0' cellspacing='0' cellpadding='0'>
          <tr>
            <td height='43' align='left' valign='top' style='padding-right:7px;'><img 
src='/images/i.jpg' width='36' height='35'></td>
            <td width='126' align='left' valign='top'>
            <b><a href='/contact' class='black_bold_14'
 style='line-height:1.4;'>контакты</a></b><br>
            <b><a href='#' onclick = 'return false;' class='black_bold_14' style='line-height:1.4;'>медиа-кит</a></b><br>
            <b><a href='/price' class='black_bold_14' style='line-height:1.4;'>прайс-лист</a></b><br>
            <b><a href='/zakaz' class='black_bold_14' style='line-height:1.4;'>заказ-онлайн</a></b></td>
          </tr>
        </table></td>
        <td width='433' align='right' valign='top'> </td>
      </tr>
    </table>";*/
}


function FirstImg()
{
  global $sub;
  
  $sql = "SELECT Message_ID FROM Message84
            WHERE Subdivision_ID = $sub
              ORDER BY Priority ASC
              LIMIT 0,1";
  
  $id = mysql_result(mysql_query($sql), 0, 0);
  
  return nc_file_path(84, $id, 'Image', 'h_');
      
}


function BrowseMapMain()
{
  $start = array(96, 80, 81, 92, 93, 94, 95, 98, 100, 101, 123, 169, 170);
  
  $out = '<UL class = "map">';
  
  foreach ($start as $s) 
  {
    $sublink = get_sub_path($s);
    $subname = get_sub_name($s);

    $out .= "<LI><a href='$sublink'>$subname</a>".
            BrowseMap($s).BrowsePubs($s).'</LI>';
  }

  $out .= '</UL>';
  
  return $out;
}

function BrowsePubs($sub)
{
    // check classes
    $out = '';
    $sql_cl = "SELECT Class_ID, Sub_Class_ID 
                    FROM Sub_Class 
                    WHERE Subdivision_ID = $sub
                        AND Checked";
    //hr($sql_cl);
    
    $q_cl = mysql_query($sql_cl);

    $class_extr = array(82 => 'Name', 83 => 'Name',
                   // 65 => 'name', 
                      66 => 'name', 67 => 'name');//,
                    //69 => 'name'); 

    while ($cl = mysql_fetch_array($q_cl))
    {
      if ($class_extr[$cl[Class_ID]] != '')
      {
      //  hr('// have into?');
        
        $q_cnt = get_var("SELECT COUNT(Message_ID) FROM Message$cl[Class_ID]
                                 WHERE Subdivision_ID = $sub");
        if ($q_cnt > 0)
        {
        //  hr('// have into? - OK ');
          
          
          $q_tit = mysql_query("SELECT * FROM Message$cl[Class_ID]
                                 WHERE Subdivision_ID = $sub
                                  ORDER BY Priority, Message_ID");
          
          $out .= '<UL>';
          while ($tit = mysql_fetch_array($q_tit))
          {
            $link = FullLink($tit);
            $title = $tit[$class_extr[$cl[Class_ID]]];
            $out .= "<LI><a href='$link'>$title</a></LI>";
          }
          $out .= '</UL>';
        
        }
      }
      
    }
    
    return $out;
}


function BrowseMap($sub = 0)
{
  //Checked AND
  $sql = "SELECT * FROM Subdivision WHERE  Parent_Sub_ID = $sub 
              ORDER BY Priority";
     
  //hr($sql);
           
  $q = mysql_query($sql);
  
  $out = '<UL>';
  
  while ($s = mysql_fetch_array($q))
  {
    $sublink = get_sub_path($s['Subdivision_ID']);
    $subname = get_sub_name($s['Subdivision_ID']);

    $out .= "<LI><a href='$sublink'>$subname</a>".
            BrowseMap($s['Subdivision_ID']);
    
    $out .= BrowsePubs($s['Subdivision_ID']);
    
    $out .= "</LI>";
  }
    
  $out .= '</UL>';
  
  return $out;

}

/*function get_sub_name($sub)
{
	return get_var('SELECT Subdivision_Name
																FROM Subdivision WHERE Subdivision_ID = '.$sub);

}

function get_sub_path($sub)
{
	return get_var('SELECT Hidden_URL
																FROM Subdivision WHERE Subdivision_ID = '.$sub);

}*/

?>
