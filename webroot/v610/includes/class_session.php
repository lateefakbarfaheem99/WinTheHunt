<?
#################################################################
## PHP Pro Bid v6.10															##
##-------------------------------------------------------------##
## Copyright ©2007 PHP Pro Software LTD. All rights reserved.	##
##-------------------------------------------------------------##
#################################################################

class session
{

	var $vars = array (NULL);

	function set($variable, $value)
	{
		$_SESSION[SESSION_PREFIX.$variable] = $value;
		$this->vars[$variable] = $value;
	}

	function unregister($variable)
	{
		if (isset($_SESSION[SESSION_PREFIX.$variable]))
		{
			unset($_SESSION[SESSION_PREFIX.$variable]);
			$this->vars[$variable] = NULL;
		}
	}

	function destroy()
	{
		session_destroy();
	}

	function value($variable)
	{
		return $_SESSION[SESSION_PREFIX.$variable];
	}

	function is_set($variable)
	{
		return (!empty($_SESSION[SESSION_PREFIX.$variable])) ? TRUE : FALSE;
	}

	function cookie_name($input)
	{
		return SESSION_PREFIX.$input;
	}
	
	function set_cookie_value($input)
	{
		return urlencode(base64_encode($input . COOKIE_SECRET_KEY));
	}
	
	function set_cookie($variable, $value)
	{
		$exp_date = 30 * 24 * 60 * 60; // 30 days
		
		$cookie_name = $this->cookie_name($variable);
		$cookie_value = $this->set_cookie_value($value);
		
		setcookie($cookie_name, $cookie_value, time() + $exp_date);
	}
	
	function unset_cookie($variable)
	{		
		setcookie($this->cookie_name($variable), '');		
	}
	
	function cookie_value($variable)
	{
		$cookie_value = $_COOKIE[SESSION_PREFIX.$variable];
		$cookie_value = urldecode($cookie_value);
		$cookie_value = base64_decode($cookie_value);
		
		$secret_key_length = strlen(COOKIE_SECRET_KEY);
		$cookie_value = substr($cookie_value, 0, (-1) * $secret_key_length);
		
		return $cookie_value;
	}
}
?>