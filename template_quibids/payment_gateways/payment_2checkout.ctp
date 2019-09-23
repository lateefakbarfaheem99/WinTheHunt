<style>
.submit { margin:10px 0 0 205px !important; }
fieldset legend { padding-left:125px; };
</style>
<div class="box clearfix">
	<div class="f-top-w clearfix"><h2><?php __('2Checkout Payment');?></h2></div>
	<div class="f-repeat clearfix">
		<div class="content">
			<fieldset class="contact">
				<legend><?php __('Click Continue Checkout Button if you are not redirect to payment page.');?></legend>
				<form id="frmPaypal_1" action="<?php echo $payment_data['URL'];?>" method="post">
					<input type="hidden" name="sid" value="<?php echo $payment_data['id'];?>"/>
					<input type="hidden" name="cart_order_id" value="<?php echo $payment_data['item_number'];?>"/> 
					<input type="hidden" name="currency" value="<?php echo $payment_data['currency'];?>"/>
					<input type="hidden" name="total" value="<?php echo $payment_data['amount'];?>"/>
					<input type="hidden" name="demo" value="<?php echo $payment_data['demo'];?>" />
					
					<input type="hidden" name="merchant_order_id" value="<?php echo $payment_data['item_number'];?>"/>
					<input type="hidden" name="card_holder_name" value="<?php echo $payment_data['first_name'];?>"/>
					<input type="hidden" name="email" value="<?php echo $payment_data['email'];?>"/>
					<input type="hidden" name="phone" value="<?php echo $payment_data['mobile'];?>"/>
					<input type="hidden" name="id_type" value="1" />					
					<input type="hidden" name="Country" value="South Africa" />					

					<div class="submit"><input type="submit" value="Continue Checkout..." ></div>
				</form> 
			</fieldset>
		</div>
	</div>
	<div class="f-bottom-top clearfix"><p class="page_top"><a href="#" id="link_to_top">PAGE TOP</a></p></div>
</div>