<?php

require_once('portable-utf8.php');

/**
 * LOW LEVEL functions
 */

// pour afficher un caractère de code donné
// echo utf8_chr('x0041');


/**
 * @param $char one character ex. "A"
 * @param $prefix prefix 
 * @return string code ex. "U+0040"
 */
function uni_ord($char, $prefix='U+') {
	return utf8_int_to_hex(utf8_ord($char, true), $prefix);
}

/**
 * @param $char one character ex. "A"
 * @return string explained code ex. "char = A  code = U+0040"
 */
function unidecode_char($char) {
	echo "char = " . $char . "  code = " . uni_ord($char) . "\n";
}



/**
 * HIGH LEVEL functions
 */

/** 
 * split a character string and returns a formatted html string with explained characters
 * @param $text
 * @return array assoc. ('short' => , 'long' => )
 */
function html_unicode_text($text) {
	$short = "";
	$long = "";
	foreach (utf8_split($text) as $char) {
		$ucode = uni_ord($char, '');
		$uniname = get_unicode_name($ucode);
		$urls = reference_url($ucode);
		$short .= '<a href="' . $urls['fileformat'] . '">' . '<span title="U+' . $ucode . ' ' . $uniname .'">' .
			$char . '</span>' . '</a>';
		$long .= $char . '&nbsp;' . '<a href="' . $urls['fileformat'] . '">' . " U+" . $ucode  . ' ' . $uniname . '</a>'
			. '&nbsp; ' . html_all_references($urls) .  '<br />';
	}
	return array('short' => $short, 'long' => $long);
}

/**
 * 
 * @param type $ucode hexadecimal code, without U+
 * @return string character name
 */
function get_unicode_name($ucode) {
	$output = array();
	$returnval = 0;
	$command = "unicode -x " . $ucode;
	exec ($command, $output, $returnval);
	return substr($output[0], 7);
}

function html_all_references($urls) {
	$res = "";
	foreach ($urls as $name => $url) {
		$res .= '<a href="' . $url . '">' . $name . '</a>' . '&nbsp; ';
	}
	return $res;
}

/**
 * return an array of reference urls for the given character code
 * @param string $ucode hexadecimal code, without prefix U+
 * @return array associative ($urlcode => $url)
 */
function reference_url($ucode) {
	$url = array(
		'fileformat' => "http://www.fileformat.info/info/unicode/char/" . $ucode . "/index.htm",
		'codepoint' => "http://codepoints.net/U+" . $ucode,
		'decodeunicode' => "http://www.decodeunicode.org/U+" . $ucode,
		'charbase' => "http://www.charbase.com/" . $ucode,
	);
	return $url;
}
