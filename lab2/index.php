<?php

require_once('src/LoginController.php');
require_once('src/HTMLView.php');

session_start();

$loginC = new LoginController();
$html = new HTMLView();

$html->echoHTML($loginC->doLogin());