<?php
/*-------------------------------------------------------+
| PHP-Fusion Content Management System
| Copyright (C) 2002 - 2013 Nick Jones
| http://www.php-fusion.co.uk/
+--------------------------------------------------------+
| Filename: lostpassword.php
| Author: Nick Jones (Digitanium)
+--------------------------------------------------------+
| This program is released as free software under the
| Affero GPL license. You can redistribute it and/or
| modify it under the terms of this license which you
| can read by viewing the included agpl.txt or online
| at www.gnu.org/licenses/agpl.html. Removal of this
| copyright header is strictly prohibited without
| written permission from the original author(s).
+--------------------------------------------------------*/
require_once "maincore.php";
require_once THEMES."templates/header.php";
require_once INCLUDES."sendmail_include.php";
include LOCALE.LOCALESET."lostpassword.php";

if (iMEMBER) redirect("index.php");

function __autoload($class) {
  require CLASSES.$class.".class.php";
  if (!class_exists($class)) { die("Class not found"); }
}

add_to_title($locale['global_200'].$locale['400']);
opentable($locale['400']);

function send_password_token_handler($error) {
	global $locale;

	if ($error) {
		echo "<div style='text-align:center'><br />".$locale['token_error']."<br /><br />\n<a href='".BASEDIR."lostpassword.php'>".$locale['406']."</a> -  <a href='".BASEDIR."index.php'>".$locale['403']."</a></div>\n";	
	}
}

$obj = new LostPassword();
if (isset($_GET['user_email']) && isset($_GET['account'])) {
	$obj->checkPasswordRequest($_GET['user_email'], $_GET['account']);
	$obj->displayOutput();
} elseif (isset($_POST['send_password'])) {
	if (verify_token('send_password', 2, 'send_password_token_handler')) {
		$obj->sendPasswordRequest($_POST['email']);
		$obj->displayOutput();
	}
} else {
	$obj->renderInputForm();
	$obj->displayOutput();
}

closetable();

require_once THEMES."templates/footer.php";
?>