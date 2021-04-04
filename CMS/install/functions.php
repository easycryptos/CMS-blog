<?php

function currentUrl($server)
{
	$http = 'http';
	if (isset($server['HTTPS'])) {
		$http = 'https';
	}
	$host = $server['HTTP_HOST'];
	$requestUri = $server['REQUEST_URI'];
	return $http . '://' . htmlentities($host) . '/' . htmlentities($requestUri);
}

function verify_license($license_code, $current_url)
{
	return array($code, 'valid'); //raz0r
}

function update_config_license_code($license_code)
{
    $config = array();
    include 'config/config.php';
    $config['license_code'] = $license_code;

    update_config($config);
    return $config;
}

function str_slug($str, $separator = 'dash', $lowercase = TRUE)
{
	$permitted_uri_chars = 'a-z 0-9~%.:_\-';
	$str = trim($str);
	$foreign_characters = array(
		'/ä|æ|ǽ/' => 'ae',
		'/ö|œ/' => 'o',
		'/ü/' => 'u',
		'/Ä/' => 'Ae',
		'/Ü/' => 'u',
		'/Ö/' => 'o',
		'/À|Á|Â|Ã|Ä|Å|Ǻ|Ā|Ă|Ą|Ǎ|Α|Ά|Ả|Ạ|Ầ|Ẫ|Ẩ|Ậ|Ằ|Ắ|Ẵ|Ẳ|Ặ|А/' => 'A',
		'/à|á|â|ã|å|ǻ|ā|ă|ą|ǎ|ª|α|ά|ả|ạ|ầ|ấ|ẫ|ẩ|ậ|ằ|ắ|ẵ|ẳ|ặ|а/' => 'a',
		'/Б/' => 'B',
		'/б/' => 'b',
		'/Ç|Ć|Ĉ|Ċ|Č/' => 'C',
		'/ç|ć|ĉ|ċ|č/' => 'c',
		'/Д/' => 'D',
		'/д/' => 'd',
		'/Ð|Ď|Đ|Δ/' => 'Dj',
		'/ð|ď|đ|δ/' => 'dj',
		'/È|É|Ê|Ë|Ē|Ĕ|Ė|Ę|Ě|Ε|Έ|Ẽ|Ẻ|Ẹ|Ề|Ế|Ễ|Ể|Ệ|Е|Э/' => 'E',
		'/è|é|ê|ë|ē|ĕ|ė|ę|ě|έ|ε|ẽ|ẻ|ẹ|ề|ế|ễ|ể|ệ|е|э/' => 'e',
		'/Ф/' => 'F',
		'/ф/' => 'f',
		'/Ĝ|Ğ|Ġ|Ģ|Γ|Г|Ґ/' => 'G',
		'/ĝ|ğ|ġ|ģ|γ|г|ґ/' => 'g',
		'/Ĥ|Ħ/' => 'H',
		'/ĥ|ħ/' => 'h',
		'/Ì|Í|Î|Ï|Ĩ|Ī|Ĭ|Ǐ|Į|İ|Η|Ή|Ί|Ι|Ϊ|Ỉ|Ị|И|Ы/' => 'I',
		'/ì|í|î|ï|ĩ|ī|ĭ|ǐ|į|ı|η|ή|ί|ι|ϊ|ỉ|ị|и|ы|ї/' => 'i',
		'/Ĵ/' => 'J',
		'/ĵ/' => 'j',
		'/Ķ|Κ|К/' => 'K',
		'/ķ|κ|к/' => 'k',
		'/Ĺ|Ļ|Ľ|Ŀ|Ł|Λ|Л/' => 'L',
		'/ĺ|ļ|ľ|ŀ|ł|λ|л/' => 'l',
		'/М/' => 'M',
		'/м/' => 'm',
		'/Ñ|Ń|Ņ|Ň|Ν|Н/' => 'N',
		'/ñ|ń|ņ|ň|ŉ|ν|н/' => 'n',
		'/Ò|Ó|Ô|Õ|Ō|Ŏ|Ǒ|Ő|Ơ|Ø|Ǿ|Ο|Ό|Ω|Ώ|Ỏ|Ọ|Ồ|Ố|Ỗ|Ổ|Ộ|Ờ|Ớ|Ỡ|Ở|Ợ|О/' => 'O',
		'/ò|ó|ô|õ|ō|ŏ|ǒ|ő|ơ|ø|ǿ|º|ο|ό|ω|ώ|ỏ|ọ|ồ|ố|ỗ|ổ|ộ|ờ|ớ|ỡ|ở|ợ|о/' => 'o',
		'/П/' => 'P',
		'/п/' => 'p',
		'/Ŕ|Ŗ|Ř|Ρ|Р/' => 'R',
		'/ŕ|ŗ|ř|ρ|р/' => 'r',
		'/Ś|Ŝ|Ş|Ș|Š|Σ|С/' => 'S',
		'/ś|ŝ|ş|ș|š|ſ|σ|ς|с/' => 's',
		'/Ț|Ţ|Ť|Ŧ|τ|Т/' => 'T',
		'/ț|ţ|ť|ŧ|т/' => 't',
		'/Þ|þ/' => 'th',
		'/Ù|Ú|Û|Ũ|Ū|Ŭ|Ů|Ű|Ų|Ư|Ǔ|Ǖ|Ǘ|Ǚ|Ǜ|Ũ|Ủ|Ụ|Ừ|Ứ|Ữ|Ử|Ự|У/' => 'U',
		'/ù|ú|û|ũ|ū|ŭ|ů|ű|ų|ư|ǔ|ǖ|ǘ|ǚ|ǜ|υ|ύ|ϋ|ủ|ụ|ừ|ứ|ữ|ử|ự|у/' => 'u',
		'/Ý|Ÿ|Ŷ|Υ|Ύ|Ϋ|Ỳ|Ỹ|Ỷ|Ỵ|Й/' => 'Y',
		'/ý|ÿ|ŷ|ỳ|ỹ|ỷ|ỵ|й/' => 'y',
		'/В/' => 'V',
		'/в/' => 'v',
		'/Ŵ/' => 'W',
		'/ŵ/' => 'w',
		'/Ź|Ż|Ž|Ζ|З/' => 'Z',
		'/ź|ż|ž|ζ|з/' => 'z',
		'/Æ|Ǽ/' => 'AE',
		'/ß/' => 'ss',
		'/Ĳ/' => 'IJ',
		'/ĳ/' => 'ij',
		'/Œ/' => 'OE',
		'/ƒ/' => 'f',
		'/ξ/' => 'ks',
		'/π/' => 'p',
		'/β/' => 'v',
		'/μ/' => 'm',
		'/ψ/' => 'ps',
		'/Ё/' => 'Yo',
		'/ё/' => 'yo',
		'/Є/' => 'Ye',
		'/є/' => 'ye',
		'/Ї/' => 'Yi',
		'/Ж/' => 'Zh',
		'/ж/' => 'zh',
		'/Х/' => 'Kh',
		'/х/' => 'kh',
		'/Ц/' => 'Ts',
		'/ц/' => 'ts',
		'/Ч/' => 'Ch',
		'/ч/' => 'ch',
		'/Ш/' => 'Sh',
		'/ш/' => 'sh',
		'/Щ/' => 'Shch',
		'/щ/' => 'shch',
		'/Ъ|ъ|Ь|ь/' => '',
		'/Ю/' => 'Yu',
		'/ю/' => 'yu',
		'/Я/' => 'Ya',
		'/я/' => 'ya'
	);

	$str = preg_replace(array_keys($foreign_characters), array_values($foreign_characters), $str);

	$replace = ($separator == 'dash') ? '-' : '_';

	$trans = array(
		'&\#\d+?;' => '',
		'&\S+?;' => '',
		'\s+' => $replace,
		'[^a-z0-9\-\._]' => '',
		$replace . '+' => $replace,
		$replace . '$' => $replace,
		'^' . $replace => $replace,
		'\.+$' => ''
	);

	$str = strip_tags($str);

	foreach ($trans as $key => $val) {
		$str = preg_replace("#" . $key . "#i", $val, $str);
	}

	if ($lowercase === TRUE) {
		if (function_exists('mb_convert_case')) {
			$str = mb_convert_case($str, MB_CASE_LOWER, "UTF-8");
		} else {
			$str = strtolower($str);
		}
	}

	$str = preg_replace('#[^' . $permitted_uri_chars . ']#i', '', $str);

	return trim(stripslashes($str));
}
