<?php
/*
Plugin Name: Yandex.Money form
Plugin URI: https://github.com/casepress-studio/yandex-money-wordpress-shortcode
Version: 1.0.0
Author: CasePress Studio
Author URI: http://casepress.org
Description: Добавляет шорткод, для создания формы оплаты через систему Яндекс.Деньги 
*/


add_shortcode( 'yandex_money_payment_form', 'yandex_money_payment_form' );
function yandex_money_payment_form( $atts ) {
	extract( shortcode_atts( array(
		'scid' => '',
		'shop_id' => '',
		'CustomerNumber' => '',
		'Sum' => '',
		'CustName' => '',
		'CustAddr' => '',
		'CustEMail' => '',
		'OrderDetails' => '',
		'PaymentType' => 'YM',
		
	), $atts ) );
	if ( empty($scid) || empty($shop_id) ) return false;
	
	if ( empty($CustomerNumber) )
		if ( !empty($_GET['CustomerNumber']) ) 	$CustomerNumber = $_GET['CustomerNumber'];
		
	if ( empty($Sum) )
		if ( !empty($_GET['Sum']) )	$Sum = $_GET['Sum'];
			
	if ( empty($CustName) )
		if ( !empty($_GET['CustName']) ) $CustName = $_GET['CustName'];
			
	if ( empty($CustAddr) )
		if ( !empty($_GET['CustAddr']) ) $CustAddr = $_GET['CustAddr'];
			
	if ( empty($CustEMail) )
		if ( !empty($_GET['CustEMail']) ) $CustEMail = $_GET['CustEMail'];
			
	if ( empty($OrderDetails) )
		if ( !empty($_GET['OrderDetails']) ) $OrderDetails = $_GET['OrderDetails'];
		
	if ( !empty($_GET['PaymentType']) ) $PaymentType = $_GET['PaymentType'];
	
	?>
	<div style="border: 1px dotted gray; padding: 15px 15px 0; margin: 10px auto; width: 300px;">
		<form name=ShopForm method="POST" action="https://money.yandex.ru/eshop.xml">
		<font face=tahoma size=2>
		<input type="hidden" name="scid" value="<?php echo $scid; ?>">
		<input type="hidden" name="ShopID" value="<?php echo $shop_id; ?>"> 

		Идентификатор клиента/Номер заказа:<br> 
		<input type="text" name="CustomerNumber" size="43" value="<?php echo $CustomerNumber; ?>"><br><br> 
		Сумма:<br> 
		<input type="text" name="Sum" size="43" value="<?php echo $Sum; ?>"><br><br>   
		Ф.И.О.:<br> 
		<input type="text" name="CustName" size="43" value="<?php echo $CustName; ?>"><br><br>
		Адрес доставки:<br> 
		<input type="text" name="CustAddr" size="43" value="<?php echo $CustAddr; ?>"> <br><br> 
		E-mail:<br> 
		<input type="text" name="CustEMail" size="43" value="<?php echo $CustEMail; ?>"><br><br>  
		Содержание заказа:<br> 
		<textarea rows="10" name="OrderDetails" cols="34"><?php echo $OrderDetails; ?></textarea><br><br> 
		Способ оплаты:<br><br>
		<input name="PaymentType" <?php if ($PaymentType == "YM"){echo'checked="checked"';} ?> value="" type="radio">Со счета в Яндекс.Деньгах<br>
		<input name="PaymentType" <?php if ($PaymentType == "AC"){echo'checked="checked"';} ?> value="AC" type="radio">С банковской карты<br>
		<input name="PaymentType" <?php if ($PaymentType == "GP"){echo'checked="checked"';} ?> value="GP" type="radio">По коду через терминал<br>
		<input name="PaymentType" <?php if ($PaymentType == "WM"){echo'checked="checked"';} ?> value="WM" type="radio">Сo счета WebMoney<br><br>
		<input type=submit value="Оплатить"><br> 
		</font>
		</form>
	</div>
	
	
	<?php

}