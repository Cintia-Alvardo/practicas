<?php

class Request {

    protected $input;
    protected $query;
    protected $request;

    public function __construct() {
        $this->input = $_POST;
        $this->query = $_GET;
        $this->request = array_merge($this->query, $this->input);
    }

    public function all()
    {
        return $this->request;
    }

    public function input($key, $default = null, $dataType = null)
    {
        $value = $this->get($key, $default);

        if ($dataType !== null) {
            $value = $this->validateDataType($value, $dataType);
        }

        return $value;
    }

    public function post($key, $default = null, $dataType = null)
    {
        $value = $this->getFromInput($key, $default);

        if ($dataType !== null) {
            $value = $this->validateDataType($value, $dataType);
        }

        return $value;
    }

    public function query($key, $default = null, $dataType = null)
    {
        $value = $this->getFromQuery($key, $default);

        if ($dataType !== null) {
            $value = $this->validateDataType($value, $dataType);
        }

        return $value;
    }

    public function has($key)
    {
        return isset($this->request[$key]);
    }

    public function get($key, $default = null)
    {
        return $this->has($key) ? $this->request[$key] : $default;
    }

    public function getFromInput($key, $default = null)
    {
        return isset($this->input[$key]) ? $this->input[$key] : $default;
    }

    public function getFromQuery($key, $default = null)
    {
        return isset($this->query[$key]) ? $this->query[$key] : $default;
    }

    public function validateDataType($value, $dataType)
    {
        switch ($dataType) {
            case 'string':
                return is_string($value) ? $value : null;
            case 'integer':
                return filter_var($value, FILTER_VALIDATE_INT) !== flase ? (int) $value : null;
            case 'float':
                return filter_var($value, FILTER_VALIDATE_FLOAT) !== flase ? (float) $value : null;
            case 'boolean':
                return filter_var($value, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE);
            case 'array':
                return is_array($value) ? $value : null;       
            default:
            return $value;
        }
    }
}