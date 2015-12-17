<?php

namespace PeelingPixels\Raktiv;

class Raktiv
{
    const VERSION = '0.1.0';

    /**
     * @var Item
     */
    protected static $instance = null;

    public static function make(array $options = [])
    {
        if (!static::$instance instanceof Item) {
            static::$instance = static::makeNew($options);
        }
        return static::$instance;
    }

    public static function makeNew(array $options = [])
    {
        return new Item($options);
    }

    public static function extend(array $options = [])
    {
        return static::make()->extend($options);
    }
}