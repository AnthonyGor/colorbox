<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <META HTTP-EQUIV="Refresh" CONTENT="3; URL=http://scbprint.ru/">
<style>
    body {
        margin: 0;
    }
</style>
</head>
<body>
<div style="width:100vw;margin: 0 auto;">

<?php
    // email address here
	$myaddr = 'goraynov@mail.ru';
    $senddate = date("d.m.Y H:i:s");

	$headers  = "From: ColorBox.ru \r\n";
	$headers .= "MIME-Version: 1.0\r\n";
    $headers .= "Content-Type: text/html;charset=utf-8 \r\n";
	
	if (isset($_POST['name'])) {
	    $name 	= $_POST['name'];
	    $text .= '<p><strong>Имя</strong> ' . $name . '</p>';
	}
	if (isset($_POST['number'])) {
	    $number 	= $_POST['number'];
	    $text .= '<p><strong>Телефон</strong> ' . $number . '</p>';
	}
	if (isset($_POST['message'])) {
	    $message 	= $_POST['message'];
	    $text .= '<p><strong>Сообщение</strong> ' . $message . '</p>';
	}

	$subj = "ColorBox обратный звонок:";

    $senderror = "error";
	
	mail($myaddr, $subj, $text, $headers);
	echo "<div style=\"background-position:top;margin-top:40px;\"></div><div style=\"width: 100vw; height: 100%; color: #111111; font-family: 'PT Sans Narrow';
 font-size: 18px; line-height: 18px;\"><div style=\"margin: 20px;border:1px dashed #282828;text-align:center;font-weight:bold;border-radius:8px;padding:10px;margin-left: auto;margin-right: auto;width: 280px;background:#fff;color:#849c0c;line-height:26px;\"><img src='./img/logo.png' alt='' style='max-width: 100%;'><br><p>Ваша заявка принята, Спасибо!</p></div></div>";

	?>
</div>
</body></html>