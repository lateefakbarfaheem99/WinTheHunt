<?
#################################################################
## PHP Pro Bid v6.10															##
##-------------------------------------------------------------##
## Copyright ©2010 PHP Pro Software LTD. All rights reserved.	##
##-------------------------------------------------------------##
#################################################################

class Module_Exception 
{
	var $exceptions = array();
	
	function setException($value)
	{
		$this->exceptions[] = $value;
	}
	
	function resetExceptions()
	{
		$this->exceptions = null;
	}
	
	function getExceptions()
	{
		return $this->exceptions;
	}
	
	function isExceptions()
	{
		return count($this->exceptions) ? true : false;
	}
}

?>