<style>
.submit { margin:10px 0 0 205px !important; }
fieldset legend { padding-left:125px; };
</style>
<div class="box clearfix">
	<div class="f-top-w clearfix"><h2><?php __('Payfast Payment');?></h2></div>
	<div class="f-repeat clearfix">
		<div class="content">
			<fieldset class="contact">
				<legend><?php __('Click Continue Checkout Button if you are not redirect to payment page.');?></legend>
				<form id="frmPay" action="<?php echo $payment_data['URL'];?>" method="post">
					<input type="hidden" name="merchant_id" value="<?php echo $payment_data['merchant_id'];?>">
					<input type="hidden" name="merchant_key" value="<?php echo $payment_data['merchant_key'];?>">
					<input type="hidden" name="return_url" value="<?php echo $payment_data['return_url'];?>">
					<input type="hidden" name="cancel_url" value="<?php echo $payment_data['cancel_url'];?>">
					<input type="hidden" name="notify_url" value="<?php echo $payment_data['notify_url'];?>">

					<!-- Payer Details -->
					<input type="hidden" name="name_first" value="<?php echo $payment_data['first_name'];?>">
					<input type="hidden" name="name_last" value="<?php echo $payment_data['last_name'];?>">
					<input type="hidden" name="email_address" value="<?php echo $payment_data['email'];?>">

					<!-- Transaction Details -->
					<input type="hidden" name="m_payment_id" value="<?php echo $payment_data['item_number'];?>">
					<input type="hidden" name="amount" value="<?php echo $payment_data['amount'];?>">
					<input type="hidden" name="item_name" value="<?php echo $payment_data['item_name'];?>">
					<input type="hidden" name="item_description" value="<?php echo $payment_data['item_name'];?>">
					<input type="hidden" name="custom_str1" value="<?php echo $payment_data['custom'];?>">

					<!-- Transaction Options -->
					<input type="hidden" name="email_confirmation" value="">

					<!-- Security -->
					<input type="hidden" name="signature" value="">			
					<div class="submit"><input type="submit" value="Continue Checkout..." ></div>
				</form> 
			</fieldset>
		</div>
	</div>
	<div class="f-bottom-top clearfix"><p class="page_top"><a href="#" id="link_to_top">PAGE TOP</a></p></div>
</div>
<script type="text/javascript">
	document.getElementById('frmPay').submit();
</script>