<?php

namespace view;

// HTML5 document
class HTMLView {

    // Echos a HTML5 document with supplied content
    public function getHTML($content) {
        $output = '<!doctype html>

			<html lang="sv">
			<head>
				<meta charset="utf-8"/>
				<title>Laborationskod no222bd</title>
			</head>
				<body>
					<h1>Laborationskod no222bd</h1>
					'.$content;

        $output .= '<p>'.$this->getSwedishTime().'</p>';

        $output .= '</body>
					</html>';

        echo $output;
    }

    // Return the date and time in Swedish
    private function getSwedishTime() {
        $days = [
            'Söndag', 'Måndag', 'Tisdag', 'Onsdag', 'Torsdag', 'Fredag', 'Lördag'
        ];
        $months = [
            'Januari', 'Februari', 'Mars', 'April', 'Maj', 'Juni', 'Juli',
            'Augusti', 'September', 'Oktober', 'November', 'December'
        ];

        date_default_timezone_set('Europe/Stockholm');

        return $days[date('w')].', den '.date('j').' '.$months[date('n') - 1]
            .strftime(' år %Y. Klockan är [%H:%M:%S].');
    }
}
