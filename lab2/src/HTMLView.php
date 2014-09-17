<?php

class HTMLView {

	public function echoHTML($content) {

		$output = '<!doctype html>

			<html lang="sv">
			<head>
				<meta charset="utf-8"/>
				<title>Laborationkod no222bd</title>
			</head>
				<body>
					<h1>Laborationkod no222bd</h1>
					' . $content;
	
		$output .= '<p>' . $this->getSwedishTimestamp() . '</p>';

		$output .=	'</body>
					</html>';

		echo $output;
	}

	private function getSwedishTimestamp() {
		setlocale(LC_TIME, 'sv', 'sv_SE');

		return '<p>' . ucfirst(strftime('%A')) . strftime(', den %#d ') . ucfirst(strftime('%B'))
					 . strftime(' år %Y. Klockan är [%H:%M:%S].') . '</p>';
	}
}