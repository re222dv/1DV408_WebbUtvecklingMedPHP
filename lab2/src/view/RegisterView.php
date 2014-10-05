<?php
namespace view;

use model\User;

class RegisterView {
    private $errors = [];
    private $message;
    private $url;
    /**
     * @var User
     */
    private $user;
    private $username;

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
        $this->user = new User();
        if (!$this->shouldRegister()) {
            return $this->user;
        }

        if ($_POST['password'] !== $_POST['password2']) {
            $this->username = $_POST['username'];
            $this->errors[] = 'Lösenorden matchar inte.';
            return $this->user;
        }

        try {
            $this->user->setUsername($_POST['username']);
        } catch (\Exception $e) {
            $this->username = $_POST['username'];
            if ($e->getCode() === USER::TOO_SHORT) {
                $length = $e->getMessage();
                $this->errors[] = "Användarnamnet har för få tecken. Minst $length tecken";
            } elseif ($e->getCode() === USER::TOO_LONG) {
                $length = $e->getMessage();
                $this->errors[] = "Användarnamnet har för många tecken. Max $length tecken";
            } elseif ($e->getCode() === USER::INVALID_CHARS) {
                $this->username = $e->getMessage();
                $this->errors[] = "Användarnamnet innehåller ogiltiga tecken";
            } else {
                throw $e;
            }
        }

        try {
            $this->user->setPassword($_POST['password']);
        } catch (\Exception $e) {
            if ($e->getCode() === USER::TOO_SHORT) {
                $length = $e->getMessage();
                $this->errors[] = "Lösenordet har för få tecken. Minst $length tecken";
            } else {
                throw $e;
            }
        }

        return $this->user;
    }

    public function setUsernameIsTaken() {
        $this->errors[] = "Användarnamnet är redan upptaget";
    }

    public function render() {
        $errors = $this->renderErrors();
        $loginUrl = $this->url->getLoginUrl();
        $message = $this->message;
        $username = $this->user->getUsername();
        if (!$username) {
            $username = $this->username;
        }

        return <<<HTML
<a href="$loginUrl">Tillbaka</a>
<h2>Ej Inloggad, Registrerar ny användare</h2>
<form method="post">
    <fieldset>
        <legend>Registrera ny användare - Skriv in användarnamn och lösenord</legend>
        <ul>
            $errors
        </ul>
        <p>
            $message
        </p>
        <label>
            Namn: <input name="username" value="$username" />
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
