<style>

	
	#UserRegisterForm div.submit input, #frmPaypal input {
	font-weight:700;
	color:#FFF;
	font-size:1.7em;
	text-align:center;
	background:url(<?php echo $appConfigurations['nml_url'];?>/img/btn_register_big_v1.jpg) left top;
	cursor:pointer;
	border:none;
	text-shadow:-1px -1px 0 #9c7934;
	padding:0px 0px 0px 0px;
   *padding:0px 0px 0px 0px;
   width:675px;
   height:49px;
}

</style>
<div class="payment-redirect">
    <h1><?php __('Please wait while we transfering you to the payment gateway.');?></h1>
    <?php echo $paypal->submit(__('Click here if this page appears for more than 5 seconds', true), $paypalData);?>
    <script type="text/javascript">
        document.getElementById('frmPaypal').submit();
    </script>
</div>