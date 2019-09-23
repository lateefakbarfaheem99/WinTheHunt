<?
#################################################################################################################
## Copyright (c) 2003 Brian E. Lozier (brian@massassi.net)																		##
##																																					##
## Permission is hereby granted, free of charge, to any person obtaining a copy of this software 					##
## and associated documentation files (the "Software"), to deal in the Software without restriction, 				##
## including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense, 		##
## and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so, 		##
## subject to the following conditions:																								##
##																																					##
## The above copyright notice and this permission notice shall be included in all copies or substantial 			##
## portions of the Software																												##
#################################################################################################################
#################################################################
## PHP Pro Bid v6.00															##
##-------------------------------------------------------------##
## Copyright ©2007 PHP Pro Software LTD. All rights reserved.	##
##-------------------------------------------------------------##
#################################################################

class template
{

	## constructor, set the home directory for the templates
	function template($path)
	{
		$this->path = $path;
	}

	## change template path if needed
	function change_path($path)
	{
		$this->path = $path;
	}

	## assign variables that will be used in the template used.
	function set($name, $value)
	{
		$this->vars[$name] = $value;
	}

	## process the template file
	function process($file)
	{
		@extract($this->vars);
		ob_start();
		include($this->path . $file);
		$contents = ob_get_contents();
		ob_end_clean();
		return $contents;
	}

	/**
	 * This function will create a table with the specified number of columns which will contain in each box
	 * a field from the $variables_array array
	 * */
	function generate_table ($variables_array, $columns, $cellpadding = 0, $cellspacing = 0, $table_width = null, $table_class = null, $box_class = null, $box_width = null)
	{
		(string) $display_output = null;

		$table_class = ($table_class) ? 'class="' . $table_class . '"' : '';
		$box_class = ($box_class) ? 'class="' . $box_class . '"' : '';

		$nb_variables = count($variables_array);
		$rows = ceil($nb_variables / $columns);

		if ($table_width)
		{
			$table_width = 'width="' . $table_width . '"';
		}
		$box_width = ($box_width) ? 'width="' . $box_width . '"' : 'width="' . (100 / $columns) . '%"';

		$column_start = 0;

		$display_output = '<table cellpadding="' . $cellpadding . '" cellspacing="' . $cellspacing . '" border="0" ' . $table_width . ' ' . $table_class . '> ';

		for ($i=0; $i<$rows; $i++)
		{
			$display_output .= '<tr> ';

			$column_end = (($column_start + $columns) < $nb_variables) ? ($column_start + $columns) : $nb_variables;

			for ($j=$column_start; $j<$column_end; $j++)
			{
				$display_output .= '<td ' . $box_width . ' ' . $box_class . ' valign="top">' . $variables_array[$j] . '</td> ';
			}

			$column_start = $column_end;

			$display_output .= '</tr> ';
		}
		$display_output .= '</table>';

		return $display_output;
	}
}

?>