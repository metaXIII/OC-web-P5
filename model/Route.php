<?php

    namespace metaxiii\sudokuSolver;


    class Route {
        private $path;
        private $callable;
        private $matches = [];
        private $param = [];

        public function __construct($path, $callable) {
            $this->path = trim($path, '/');
            $this->callable = $callable;
        }

        public function match($url) {
            $url = trim($url, '/');
            $this->path = preg_replace_callback('#:([\w]+)#', [$this, 'paramMatch'], $this->path);
            $regex = "#^$this->path$#i";
            if (!preg_match($regex, $url, $matches)) {
                return false;
            }
            array_shift($matches);
            $this->matches = $matches;
            return true;
        }


        public function call() {
            if (is_string($this->callable)) {
                $params = explode('#', $this->callable);
                $controller = "\\metaxiii\\blog\\" . $params[0] . "Controller";
                $controller = new $controller();
                return call_user_func_array([$controller, $params[1]], $this->matches);
            } else {
                return call_user_func_array($this->callable, $this->matches);
            }
        }

        private function paramMatch($match) {
            if (isset($this->param[$match[1]])) {
                return '(' . $this->param[$match[1]] . ')';
            } else {
                return '([^/]+)';
            }
        }


        public function with($param, $regex) {
            $this->param[$param] = str_replace('(', '(?:', $regex);
            return $this;
        }

        public function getUrl($params) {
            $route = $this->path;
            foreach ($params as $k => $v) {
                $route = str_replace(":$k", $v, $route);
            }
            return $route;
        }
    }
