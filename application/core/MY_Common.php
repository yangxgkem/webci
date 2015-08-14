<?php

if ( ! function_exists('print_stack_trace'))
{
	function print_stack_trace()
	{
		$array = debug_backtrace();
		unset($array[0]);

		$html = '===============================print_stack_trace================================='.'<p>';
		foreach ($array as $row) 
		{
			$html .= $row['file'].':'.$row['line'].'行, 调用方法:'.$row['function'].'<p>';
		}
		$html .= '================================================================'.'<p>';
		echo $html;
	}
}




