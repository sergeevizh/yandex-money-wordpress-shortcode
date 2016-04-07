<?php
/*
Plugin Name: Яндекс.Деньги - Форма оплаты
Description: Добавляет шорткод, для создания формы оплаты через систему Яндекс.Деньги. Шорткод вида [yandex_money_payment_form scid=xxx shop_id=xxx]
Plugin URI: https://github.com/systemo-biz/yandex-money-wordpress-shortcode
Author: Systemo
Author URI: http://systemo.biz

//Support https://github.com/afragen/github-updater
GitHub Plugin URI: https://github.com/systemo-biz/yandex-money-wordpress-shortcode
GitHub Branch: master

Version: 20160406

*/


add_shortcode( 'yandex_money_payment_form', function( $atts ) {
	extract( shortcode_atts( array(
	'scid' => '', //ИД Яндекс.Кассы
	'shop_id' => '', //ИД магазина для Яндекс.Кассы
	'customer_number' => '', //Номер заказа или клиента
	'Sum' => '', //Сумма оплаты
	'CustName' => '', //Наименование клиента
	'CustAddr' => '', //Адрес доставки
	'CustEMail' => '', // Электропочта
	'OrderDetails' => '', //Комментарий или описание заказа
	'PaymentType' => 'YM', //Тип оплаты
	'cn_input' => false, //Нужно ли выводить поле номера заказа/клиента
	'ca_input' => false, //Нужно ли выводить поле деталей заказа
	), $atts ) );
  
  
	if ( empty($scid) || empty($shop_id) ) return 'Нужно указать в шорткоде параметры scid & shop_id';
	
	if ( empty($CustomerNumber) )
		if ( isset($_GET['customer_number']) ) 	$customer_number = $_GET['customer_number'];
	
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
	
	ob_start();
	?>
	<div class="form-pay-ya-money et_pb_contact">
	    	<form role="form" class="et_pb_contact_form clearfix" name="ShopForm" method="POST" action="https://money.yandex.ru/eshop.xml">
	          	<fieldset>
	              <legend>Обязательные данные</legend>
	              <div class="sum_div">
	                <label for="form-order-sum">Сумма</label>
	                <small>(в рублях)</small>
	                <input id="form-order-sum" class="form-control input" type="text" name="Sum" value="<?php echo $Sum; ?>">  
	
	
	              </div>
	              <div class="cp-form-order-email">
	              	<label for="form-order-email">Электронная почта</label>
	              	<input id="form-order-email" class="form-control" type="email" name="CustEMail" value="<?php echo $CustEMail; ?>" placeholder="example@mail.to">
	              </div>
	          	</fieldset>
	          	<hr>
	          	<fieldset>
	              <legend>Дополнительные данные</legend>  
	              <div class="cp-form-order-name">
	                <label for="form-order-name">Имя</label> 
	                <small>(Ф.И.О. или название организации)</small>
	              	<input id="form-order-name" class="form-control" type="text" name="CustName" value="<?php echo $CustName; ?>">
	              </div>
	              <?php if($cn_input): ?>
	                <div class="order_number">
	                    <label for="form-order-id">Номер заказа</label>
	                    <small>(Если есть, может быть номер клиента, счета, заказа)</small>
	                    <input id="form-order-id" class="form-control" name="CustomerNumber" type="text" value="<?php echo $customer_number; ?>">
	                </div>
	              <?php endif;?>
	              <?php if($ca_input): ?>
	                <div class="cp-form-order-address">
	                  <label for="form-order-address">Адрес</label> 
	                  <small>(Город, улица, дом для доставки или место жительства плательщица)</small>
	                  <input id="form-order-address" class="form-control" type="text" name="CustAddr" value="<?php echo $CustAddr; ?>">
	                </div>
	              <?php endif;?>
	              <div class="cp-form-order-description">
	                <label for="form-order-description">Комментарий к оплате</label>
	                <textarea id="form-order-description" class="form-control" rows="5" name="OrderDetails"><?php echo $OrderDetails; ?></textarea>
	              </div>
	          	</fieldset>
	          	<hr>
	          	<fieldset>
	              <legend>Способы оплаты</legend>
	              <div class="cp-form-order-ym">
	              	<label for="form-order-ym">
	                  <input id="form-order-ym" name="PaymentType" <?php if ($PaymentType == "YM"){echo'checked="checked"';} ?> value="" type="radio"> Со счета в Яндекс.Деньгах
	                </label>
	              </div>
	              <div class="cp-form-order-ac">
	              	<label for="form-order-ac">
	                  <input id="form-order-ac" name="PaymentType" <?php if ($PaymentType == "AC"){echo'checked="checked"';} ?> value="AC" type="radio"> С банковской карты
	                </label>
	              </div>
	              <div class="cp-form-order-gp">
	              	<label for="form-order-gp">
	                  <input id="form-order-gp" name="PaymentType" <?php if ($PaymentType == "GP"){echo'checked="checked"';} ?> value="GP" type="radio"> По коду через терминал
	                </label>
	              </div>
	              <div class="cp-form-order-wm">
	              	<label for="form-order-wm">
	                  <input id="form-order-wm" name="PaymentType" <?php if ($PaymentType == "WM"){echo'checked="checked"';} ?> value="WM" type="radio"> Сo счета WebMoney
	                </label>
	              </div>
	              <div class="cp-form-order-ab list-pay-item">
	              	<label for="form-order-ab">
	                  <input id="form-order-ab" name="PaymentType" <?php if ($PaymentType == "AB"){echo'checked="checked"';} ?> value="AB" type="radio"> Через АльфаБанк
	                </label>
	              </div>
	              
	  	</fieldset>
	  	<input class="btn" type=submit value="Оплатить">
	  	<input type="hidden" name="scid" value="<?php echo $scid; ?>">
	  	<input type="hidden" name="ShopID" value="<?php echo $shop_id; ?>"> 
		</form>
	</div>
	<?php
	$data = ob_get_contents();
	ob_end_clean();
	return $data;
}


add_action('wp_head', 'add_cp_yamoney_form_style');
 
function add_cp_yamoney_form_style() { 
global $post;
  if(isset($post->post_content) AND has_shortcode( $post->post_content, 'yandex_money_payment_form')){
	?>
	<style type="text/css" id="yandex_money_payment_form_style">
      .form-pay-ya-money {
      	!border-width: 1px;
		!border-color: black;
      }
      .form-pay-ya-money input[type="text"] {
        !width: 100%;
      }
      .form-pay-ya-money textarea {
        !width: 100%;
      }
      
	</style>
	<?php  
  }
}


