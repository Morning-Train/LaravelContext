<?php

namespace MorningTrain\LaravelContext\Plugins\Meta;

class Registrar
{

    protected $data = [];

    public function get(string $key = null)
    {
        if ($key == null) {
            return $this->data;
        }

        return isset($this->data[$key]) ? $this->data[$key] : '';
    }

    public function set($key, $value = null)
    {
        if (is_array($key)) {
            $this->data = array_merge($this->data, $key);
            return $this;
        }

        $this->data[$key] = $value;
        return $this;
    }

    public function __get($name)
    {
        return $this->get($name);
    }

    public function __set($name, $value)
    {
        return $this->set($name, $value);
    }

}