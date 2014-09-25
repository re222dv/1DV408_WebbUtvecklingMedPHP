<?php

namespace view;

class UrlView {
    private $routes;

    public function __construct() {
        $this->routes = [
            'login' => '/',
            'register' => '/register',
        ];
    }

    private function getCurrentPath() {
        return isset($_GET['path'])? $_GET['path'] : '/';
    }

    private function getCurrentRoute() {
        $currentPath = $this->getCurrentPath();
        foreach ($this->routes as $route => $path) {
            if ($path === $currentPath) {
                return $route;
            }
        }
    }

    private function getUrl($routeName) {
        $path = urlencode($this->routes[$routeName]);
        return "?path=$path";
    }

    public function getLoginUrl() {
        return $this->getUrl('login');
    }

    public function getRegisterUrl() {
        return $this->getUrl('register');
    }

    public function isLogin() {
        return $this->getCurrentRoute() === 'login';
    }

    public function isRegister() {
        return $this->getCurrentRoute() === 'register';
    }
}
