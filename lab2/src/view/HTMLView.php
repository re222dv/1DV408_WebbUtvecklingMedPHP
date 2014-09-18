<?php

namespace view;

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
	
		$output .= '<p>' . $this->getSwedishTime() . '</p>';

		$output .=	'</body>
					</html>';

		echo $output;
	}

	private function getSwedishTime() {
		setlocale(LC_TIME, 'sv', 'sv_SE');

		return ucfirst(strftime('%A')) . strftime(', den %#d ') . ucfirst(strftime('%B'))
			   . strftime(' år %Y. Klockan är [%H:%M:%S].');
	}
}