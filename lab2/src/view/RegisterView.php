<?php
namespace view;

require_once('src/model/User.php');

use model\User;

class RegisterView {
    private $errors = [];
    private $url;

    public function __construct(UrlView $url) {
        $this->url = $url;
    }

    private function renderErrors() {
        $html = '';
        foreach ($this->errors as $error) {
            $html .= "<li>$error</li>";
        }

        return $html;
    }

    public function shouldRegister() {
        return isset($_POST['register']);
    }

    public function getUser() {
        if (!$this->shouldRegister()) {
            return null;
        }

        if ($_POST['password'] !== $_POST['password2']) {
            $this->errors[] = 'Lösenorden matchar inte.';
            return null;
        }

        $user = new User();

        try {
            $user->setUsername($_POST['username']);
        } catch (\Exception $e) {
            if ($e->getCode() === USER::TOO_SHORT) {
                $length = $e->getMessage();
                $this->errors[] = "Användarnamnet har för få tecken. Minst $length tecken";
            } elseif ($e->getCode() === USER::TOO_LONG) {
                $length = $e->getMessage();
                $this->errors[] = "Användarnamnet har för många tecken. Max $length tecken";
            } elseif ($e->getCode() === USER::INVALID_CHARS) {
                $this->errors[] = "Användarnamnet innehåller ogiltiga tecken";
            } else {
                throw $e;
            }
        }

        try {
            $user->setPassword($_POST['password']);
        } catch (\Exception $e) {
            if ($e->getCode() === USER::TOO_SHORT) {
                $length = $e->getMessage();
                $this->errors[] = "Lösenordet har för få tecken. Minst $length tecken";
            } else {
                throw $e;
            }
        }

        return $user;
    }

    public function render() {
        $this->getUser();
        $errors = $this->renderErrors();
        $loginUrl = $this->url->getLoginUrl();

        return <<<HTML
<a href="$loginUrl">Tillbaka</a>
<h2>Ej Inloggad, Registrerar ny användare</h2>
<form method="post">
    <fieldset>
        <legend>Registrera ny användare - Skriv in användarnamn och lösenord</legend>
        <ul>
            $errors
        </ul>
        <label>
            Namn: <input name="username" />
        </label><br />
        <label>
            Lösenord: <input type="password" name="password" />
        </label><br />
        <label>
            Repetera Lösenord: <input type="password" name="password2" />
        </label><br />
        <input type="submit" value="Registrera" name="register" />
    </fieldset>
</form>
HTML;
    }
}
