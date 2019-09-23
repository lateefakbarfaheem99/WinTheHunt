<?php
$ca = $this->params['action'];
$cc = $this->params['controller'];
$url = $this->params['url']['url'];
$bidbalance = $this->requestAction('/bids/balance/'.$session->read('Auth.User.id'));
if($session->check('Auth.User')){?>
<div class="user-status"><label>Welcome,<span class="side_2px bold" style="margin-left:5px;">
<?php echo $session->read('Auth.User.username'); ?></span></label>
<span class="side_5px bold" style="margin-right:0px;">[<a href="<?php echo $appConfigurations['nml_url'];?>/users/logout/">LogOut</a>]</span>
<?php if($session->read('Auth.User.admin') == 1): ?>
	<span class="side_5px bold" style="margin-right:8px;"><a href="<?php echo $appConfigurations['url'];?>/admin">admin</a></span>
<?php endif; ?>
<br/><span id="bid-balance" class="bid-balance"><?php echo $bidbalance; ?></span> Bids Left
</div>
<?php }else{?>
 <div id="fdsfds" class="top_login">
 <ul>
    <form class="Part1" action="<?php echo $appConfigurations['nml_url'];?>/users/login" method="post">
    
       <li>
          <input type="text"  name="data[User][username]" />
    		 <span>Forgot Password?
            <a href="<?php echo $appConfigurations['nml_url'];?>/users/reset">Click Here</a></span> </li>
   
    
    
   		<li>
          <input type="password"  name="data[User][password]" />
          <span>Not a Member?
            <a href="<?php echo $appConfigurations['nml_url'];?>/users/register">
                Register Now
                <!--<img src="<?php echo $appConfigurations['nml_url'];?>/img/register_now.gif" alt="Register Now"/> -->
            </a>
          </span>
        </li>
          
    <li style="width:50px;"> <input type="image" class="login_btn" src="<?php echo $appConfigurations['nml_url'];?>/img/login-btn.gif" class="Button" /></li>

    
    </form>

    <!-- /Login -->
    </ul>
</div>
<?php }?>

<?php

 if($cc == 'auctions' && $ca == 'home'){$homeClass ='active';}
 if($url == 'page/about' ){$froozleClass ='active';}
 if($cc == 'users' && $ca == 'register'){$registerClass ='active';}
 if($cc == 'users' && $ca == 'index'){$myaccountClass ='active';}
 if($url == 'page/help' ){$helpClass ='active';}

if($cc == 'categories' && $ca == 'view'){
	$selectedCatId = $this->params['pass'][0];
}else if($this->params['controller'] == 'auctions' && $this->params['action'] == 'home'){ 
	$selectedCatId = 'home';
}
?>



<script language="javascript" type="text/javascript">
function catagory() {
	document.getElementById('listbox').style.display = "block";
}
function catagory1() {
	document.getElementById('listbox').style.display = "none";
}
function goCatPage(catId) {
	if(catId == '' ){
		return false;
	}else if(catId == 'all_live' ){
		location.href = '/auctions/' ;
	}else if(catId != 0 ){
		location.href = '/categories/view/'+catId ;
	}
	return true;
}
</script>