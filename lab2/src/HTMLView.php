<?php

class HTMLView {

	public function echoHTML($content) {

		$output = '<!doctype html>

			<html lang="sv">
			<head>
				<meta charset="utf-8"/>
			</head>
				<body>
					<h1>Laborationkod no222bd</h1>
					' . $content;

		setlocale(LC_TIME, 'sv_SE');
		$output .= '<p>' . ucfirst(strftime('%A')) . strftime(', den %e %B år %Y. Klockan är %T.') . '</p>';

		$output .=	'</body>
					</html>';

		echo $output;
	}
}