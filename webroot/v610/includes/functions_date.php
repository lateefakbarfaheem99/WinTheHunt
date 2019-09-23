<?
#################################################################
## PHP Pro Bid v6.10 														##
##-------------------------------------------------------------##
## Copyright ©2007 PHP Pro Software LTD. All rights reserved.	##
##-------------------------------------------------------------##
#################################################################

function show_date ($timestamp, $show_time = true)
{
	(string) $display_output = null;

	if ($timestamp)
	{
		$date_format = ($show_time) ? DATETIME_FORMAT : DATE_FORMAT;

		$offset_time = $timestamp + (TIME_OFFSET * 60 * 60);

		$display_output = date($date_format, $offset_time);
	}
	else
	{
		$display_output = GMSG_NA;
	}
	return $display_output;
}

function time_difference ($end_date, $start_date = CURRENT_TIME)
{
	return ($end_date - $start_date);
}

function time_left($end_date, $start_date = CURRENT_TIME, $show_close_date = false, $display_seconds = false)
{
	(string)	$display_output = null;
	(string) $minute = 60;
	(string) $hour = 60 * $minute;
	(string) $day = 24 * $hour;

	$time_left = $end_date - $start_date;

	$days_left = floor($time_left/$day);

	$hours = $time_left - ($days_left * $day);
	$hours_left = floor($hours/$hour);

	$minutes = $hours - ($hours_left * $hour);
	$minutes_left = floor($minutes/$minute);

	$seconds = $minutes - ($minutes_left * $minute);
	$seconds_left = floor($seconds);
	
	if ($time_left > 0)
	{
		$display_output = (($days_left>0) ? $days_left . ' ' . (($days_left==1) ? GMSG_DAY : GMSG_DAYS) . ', ' : '') .
			(($hours_left>0 || $days_left>0) ? $hours_left . GMSG_H : '') . ' ' . $minutes_left . GMSG_M;
			
		if ($display_seconds)
		{
			$display_output .= ' ' . $seconds_left . GMSG_S;
		}
	}
	else if (!$end_date)
	{
		$display_output = GMSG_NA;
	}
	else
	{
		$display_output = '<span class="redfont">' . GMSG_CLOSED . '</span>';
		
		if ($show_close_date)
		{
			$display_output .= '<br><b>' . MSG_ON . '</b> ' . show_date($end_date);
		}
	}

	return $display_output;
}

function date_form_field($current_timestamp = 0, $box_number = 1, $form_name = null, $display_time = true)
{
	global $setts;

	(string) $display_output = null;
	(array) $current_date = null;

	$years_array = array('2010', '2011', '2012', '2013', '2014', '2015');

	$months_array = array('01' => GMSG_MTH_JANUARY, '02' => GMSG_MTH_FEBRUARY, '03' => GMSG_MTH_MARCH, '04' => GMSG_MTH_APRIL,
		'05' => GMSG_MTH_MAY, '06' => GMSG_MTH_JUNE, '07' => GMSG_MTH_JULY, '08' => GMSG_MTH_AUGUST,
		'09' => GMSG_MTH_SEPTEMBER, '10' => GMSG_MTH_OCTOBER, '11' => GMSG_MTH_NOVEMBER, '12' => GMSG_MTH_DECEMBER);

	$days_array = array('01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12',
		'13', '14', '15', '16', '17', '18', '19', '20', '21', '22', '23', '24',
		'25', '26', '27', '28', '29', '30', '31');

	$hours_array = array('00', '01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12',
		'13', '14', '15', '16', '17', '18', '19', '20', '21', '22', '23');

	$minutes_array = array('00', '15', '30', '45');

	if ($current_timestamp>0)
	{
		$current_timestamp += $setts['time_offset'] * 3600;
		
		list ($current_date['year'], $current_date['month'], $current_date['day'],
		$current_date['hour'], $current_date['minute'], $current_date['second']) = explode('|', date('Y|m|d|H|i|s', $current_timestamp));		
	}

	$form_name = ($form_name) ? $form_name : 'forms';

	$display_output = "<SCRIPT LANGUAGE=\"JavaScript\" ID=\"js" . $box_number . "\"> \n".
		"	var cal" . $box_number . " = new CalendarPopup(); \n".
		"	cal" . $box_number . ".setReturnFunction(\"setMultipleValues" . $box_number . "\"); \n".
		"	function setMultipleValues" . $box_number . "(y,m,d) { \n".
		"		document." . $form_name . ".date" . $box_number . "_year.value=y; \n".
		"		document." . $form_name . ".date" . $box_number . "_month.selectedIndex=m; \n".
		"		for (var i=0; i<document." . $form_name . ".date" . $box_number . "_day.options.length; i++) { \n".
		"			if (document." . $form_name . ".date" . $box_number . "_day.options[i].value==d) { \n".
		"				document." . $form_name . ".date" . $box_number . "_day.selectedIndex=i; \n".
		"			} \n".
		"		} \n".
		"	} \n".
		"	function getDateString(y_obj,m_obj,d_obj) { \n".
		"		var y = y_obj.options[y_obj.selectedIndex].value; \n".
		"		var m = m_obj.options[m_obj.selectedIndex].value; \n".
		"		var d = d_obj.options[d_obj.selectedIndex].value; \n".
		"		if (y==\"\" || m==\"\") { return null; } \n".
		"		if (d==\"\") { d=1; } \n".
		"		return str= y+'-'+m+'-'+d; \n".
		"	} \n".
		"</SCRIPT> \n";

	/* create the months drop down menu */

	$display_output .= '<select name="date' . $box_number . '_month" id="date' . $box_number . '_month" class="contentfont"> '.
		'<option> </option> ';
	foreach ($months_array as $key => $value)
	{
		$display_output .= '<option value="' . $key . '" ' . (($key == $current_date['month']) ? 'selected' : '') . '>' . $value . '</option> ';
	}
	$display_output .= '</select> ';

	$display_output .= '<select name="date' . $box_number . '_day" id="date' . $box_number . '_day" class="contentfont"> '.
		'<option> </option> ';
	foreach ($days_array as $value)
	{
		$display_output .= '<option value="' . $value . '" ' . (($value == $current_date['day']) ? 'selected' : '') . '>' . $value . '</option> ';
	}
	$display_output .= '</select> ';

	$display_output .= '<select name="date' . $box_number . '_year" id="date' . $box_number . '_year" class="contentfont"> '.
		'<option> </option> ';
	foreach ($years_array as $value)
	{
		$display_output .= '<option value="' . $value . '" ' . (($value == $current_date['year']) ? 'selected' : '') . '>' . $value . '</option> ';
	}
	$display_output .= '</select> ';

	$display_output .= '<a href="#" onclick="cal' . $box_number . '.showCalendar(\'anchor' . $box_number . '\',getDateString(document.' . $form_name . '.date' . $box_number . '_year,document.' . $form_name . '.date' . $box_number . '_month,document.' . $form_name . '.date' . $box_number . '_day)); return false;" '.
		'title="cal' . $box_number . '.showCalendar(\'anchor' . $box_number . '\',getDateString(document.' . $form_name . '.date' . $box_number . '_year,document.' . $form_name . '.date' . $box_number . '_month,document.' . $form_name . '.date' . $box_number . '_date)); return false;" name="anchor' . $box_number . '" id="anchor' . $box_number . '">'.
		'<img src="' . SITE_PATH . 'themes/' . $setts['default_theme'] . '/img/system/calendar_b2u.gif" border="0" align="absmiddle" /></a> ';

	if ($display_time)
	{

		$display_output .= '<select name="date' . $box_number . '_hour" id="date' . $box_number . '_hour" class="contentfont"> '.
			'<option> </option> ';

		foreach ($hours_array as $value)
		{
			$display_output .= '<option value="' . $value . '" ' . (($value == $current_date['hour']) ? 'selected' : '') . '>' . $value . '</option> ';
		}
		$display_output .= '</select> : ';

		$display_output .= '<select name="date' . $box_number . '_minute" id="date' . $box_number . '_minute" class="contentfont"> '.
			'<option> </option> ';
		foreach ($minutes_array as $value)
		{
			$display_output .= '<option value="' . $value . '" ' . (($value == $current_date['minute']) ? 'selected' : '') . '>' . $value . '</option> ';
		}
	}
	$display_output .= '</select> ';

	return $display_output;
}

function get_box_timestamp($values_array, $time_box_id) /* this function converts the date selected in a date/time field into a timestamp */
{
	global $setts;

	$timestamp = @mktime($values_array['date' . $time_box_id . '_hour'] - $setts['time_offset'],
		$values_array['date' . $time_box_id . '_minute'], 0, $values_array['date' . $time_box_id . '_month'],
		$values_array['date' . $time_box_id . '_day'], $values_array['date' . $time_box_id . '_year']);

	return $timestamp;
}

?>