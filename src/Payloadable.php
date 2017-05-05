<?php

namespace TimFeid\Slack;

use InvalidArgumentException;
use ArrayAccess;
use JsonSerializable;

abstract class Payloadable implements ArrayAccess, JsonSerializable
{
    public function __construct(array $attributes = [])
    {
        foreach ($attributes as $key => $value) {
            $this[$key] = $value;
        }
    }

    public function __set($key, $value)
    {
        $this[$key] = $value;
    }

    public function offsetExists($offset)
    {
        return property_exists($this, $offset) && !is_object($this->$offset);
    }

    public function offsetGet($offset)
    {
        $offset = Str::camel($offset);

        return $this->$offset;
    }

    public function offsetSet($offset, $value)
    {
        $camel = Str::camel($offset);
        $method = 'set'.ucfirst($camel);
        if (method_exists($this, $method)) {
            return $this->$method($value);
        }

        if (!property_exists($this, $offset)) {
            $offset = $camel;
        }

        if (!property_exists($this, $offset)) {
            throw new InvalidArgumentException("Unknown parameter '{$offset}'");
        }

        if (is_object($this->$offset)) {
            throw new InvalidArgumentException("Unable to set parameter '{$offset}'");
        }

        return $this->$offset = $value;
    }

    public function offsetUnset($offset)
    {
        $this->$offset = '';
    }

    public function jsonSerialize()
    {
        return $this->toArray();
    }

    public function toArray()
    {
        $array = [];
        foreach (get_class_vars(static::class) as $key => $default) {
            if (!is_object($this[$key])) {
                $field = Str::snake($key);
                if (is_array($this[$key])) {
                    $array[$field] = [];
                    foreach ($this[$key] as $subProperty) {
                        $array[$field][] = $subProperty->toArray();
                    }
                } else {
                    $array[$field] = $this[$key];
                }
            }
        }

        return array_filter($array);
    }

    public function toJson(int $options = 0)
    {
        return json_encode($this->jsonSerialize(), $options);
    }
}
