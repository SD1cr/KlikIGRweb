<?php  
	if (!empty($_SERVER['HTTPS']) && ('on' == $_SERVER['HTTPS'])) {
		$uri = 'http://';
	} else {
		$uri = 'http://';                                                  
	}   
	$uri .= $_SERVER['HTTP_HOST'];
	header('Location: '.$uri.'/public');         
	exit;
?>
Something is wrong with the XAMPP installation :-(
