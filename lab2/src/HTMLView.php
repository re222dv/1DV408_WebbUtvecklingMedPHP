<?php

class HTMLView {

	public function getHTML($content) {

		$output = '<!doctype html>

			<html lang="sv">
			<head>
				<meta charset="utf-8"/>
				<title>Laborationskod no222bd</title>
			</head>
				<body>
					<h1>Laborationskod no222bd</h1>
					' . $content;
	
		$output .= '<p>' . $this->getSwedishTimeHTML() . '</p>';

		$output .=	'</body>
					</html>';

		echo $output;
	}

	private function getSwedishTimeHTML() {
		setlocale(LC_TIME, 'sv', 'sv_SE');

		return '<p>' . ucfirst(strftime('%A')) . strftime(', den %#d ') . ucfirst(strftime('%B'))
					 . strftime(' år %Y. Klockan är [%H:%M:%S].') . '</p>';
	}
}