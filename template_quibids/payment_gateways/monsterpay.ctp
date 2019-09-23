<?php //echo "<pre>";print_r($payment_data);echo "</pre>";exit(); ?>
<div class="payment-redirect">
    <script type="text/javascript">
        document.getElementById('frmPaypal').submit();
    </script>
<form id="frmPaypal_____" action="<?php echo $payment_data['URL'];?>" method="post">

<input type="hidden" name="MerchantIdentifier" value="<?php echo $payment_data['id'];?>"/>
<input type="hidden" name="LIDSKU" value="<?php echo $payment_data['item_number'];?>"/> 
<input type="hidden" name="CurrencyAlphaCode" value="<?php echo $payment_data['currency'];?>"/>
<input type="hidden" name="LIDPrice" value="<?php echo $payment_data['amount'];?>"/>
<input type="hidden" name="demo" value="<?php echo $payment_data['demo'];?>" />
<input type="hidden" name="LIDDesc" value="<?php echo $payment_data['item_name'];?>"/>
<input type="hidden" name="card_holder_name" value="<?php echo $payment_data['first_name'];?>"/>
<input type="hidden" name="email" value="<?php echo $payment_data['email'];?>"/>
<input type="hidden" name="phone" value="<?php echo $payment_data['mobile'];?>"/>
<input type="hidden" name="LIDQty__" value="1" />
<input class="submit" type="submit" border="0" value="Click here if you are not redirect to payment page">

</form> 
</div>

