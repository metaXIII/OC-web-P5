<?php
/**
 * Created by IntelliJ IDEA.
 * User: MetaXIII
 * Date: 06/11/2018
 * Time: 12:26
 */

namespace metaxiii\sudokuSolver;


class Route
{
    private $path;
    private $callable;
    private $matches = [];
    private $param = [];

    public function __construct($path, $callable)
    {
        $this->path = trim($path, '/');
        $this->callable = $callable;
    }

    public function match($url)
    {
        $url = trim($url, '/');
        $path = preg_replace_callback('#:([\w]+)#', [$this, 'paramMatch'], $this->path);
        $regex = "#^$path$#i";
        if (!preg_match($regex, $url, $matches)) {
            return false;
        }
        array_shift($matches);
        $this->matches = $matches;
        return true;
    }


    public function call()
    {
        if (is_string($this->callable)) {
            $params = explode('#', $this->callable);
            $controller = "\\metaxiii\\blog\\" . $params[0] . "Controller";
            $controller = new $controller();
            return call_user_func_array([$controller, $params[1]], $this->matches);
        } else {
            return call_user_func_array($this->callable, $this->matches);
        }
    }

    private function paramMatch($match)
    {
        if (isset($this->param[$match[1]]))
            return '(' . $this->param[$match[1]] . ')';
        else {
            return '([^/]+)';
        }
    }


    public function with($param, $regex)
    {
        $this->param[$param] = str_replace('(', '(?:', $regex);
        return $this;
    }

    public function getUrl($params)
    {
        $path = $this->path;
        foreach ($params as $k => $v) {
            $path = str_replace(":$k", $v, $path);
        }
        return $path;
    }
}
