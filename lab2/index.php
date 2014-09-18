<?php

require_once('src/controller/LoginController.php');
require_once('src/view/HTMLView.php');

session_start();

$login = new \controller\LoginController();
$html = new \view\HTMLView();

$html->getHTML($login->doLogin());