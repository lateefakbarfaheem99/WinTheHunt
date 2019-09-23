<div class="top-menu">
<?php if($session->check('Auth.User')):?>
    <ul>
        <?php if($session->read('Auth.User.admin') == 1): ?>
        <li class="menu_admin"><a href="<?php echo $appConfigurations['url'];?>/admin">Admin</a></li>
        <?php endif; ?>
        <li class="menu_account"><a href="<?php echo $appConfigurations['ref_url']; ?>/users">Users</a></li>
        <li class="menu_pot"><a href="<?php echo $appConfigurations['ref_url']; ?>/packages">Bid Packages</a></li>
        <li class="menu_logout"><a href="<?php echo $appConfigurations['ref_url']; ?>/users/logout">Logout</a></li>
&nbsp; <?php echo sprintf(__('%s bids left', true), '<strong id="mybids">'.$bidBalance.'</strong>');?>
    </ul>
<?php else:?>
    <ul>
        <li class="regist"><a href="<?php echo $appConfigurations['ref_url']; ?>/users/register">Register</a></li>
        <li class="menu_login"><a href="<?php echo $appConfigurations['ref_url']; ?>/users/login">Login</a></li>
    </ul>
<div class="user-status"><span class="side_5px bold" style="margin-right:8px;"><img src="/img/parts/guide_head_icon.png" width="21" height="21" border="0" alt="" style="margin-right:4px; margin-top:-2px;" align="middle"><a href="<?php echo $appConfigurations['nml_url']; ?>/page/about" style="color:#FFF;">About Us</a></span><span class="head_help"><a href="<?php echo $appConfigurations['nml_url']; ?>/page/help" style="font-weight:normal; color: #FFF;">Help</a></span></div>
<?php endif;?>
</div>