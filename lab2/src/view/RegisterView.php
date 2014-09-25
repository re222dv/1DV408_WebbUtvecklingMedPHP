<?php

namespace view;

class RegisterView {
    private $url;

    public function __construct(UrlView $url) {
        $this->url = $url;
    }

    public function render() {
        $loginUrl = $this->url->getLoginUrl();

        return <<<HTML
<a href="$loginUrl">Tillbaka</a>
<h2>Ej Inloggad, Registrerar ny användare</h2>
<form method="post">
    <fieldset>
        <legend>Registrera ny användare - Skriv in användarnamn och lösenord</legend>
        <label>
            Namn: <input name="username" />
        </label><br />
        <label>
            Lösenord: <input type="password" name="password" />
        </label><br />
        <label>
            Repetera Lösenord: <input type="password" name="password2" />
        </label><br />
        <input type="submit" value="Registrera" />
    </fieldset>
</form>
HTML;

    }
}
