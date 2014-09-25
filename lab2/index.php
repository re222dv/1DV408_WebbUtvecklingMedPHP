<?php

require_once('src/controller/MasterController.php');
require_once('src/view/HTMLView.php');

session_start();

$login = new \controller\MasterController();
$html = new \view\HTMLView();

$html->getHTML($login->render());
