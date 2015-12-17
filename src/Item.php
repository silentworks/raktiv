<?php

namespace PeelingPixels\Raktiv;

class Item extends BaseComponent
{
    public function __construct(array $options = [])
    {
        parent::__construct($options);
    }

    public function extend(array $options = [])
    {
        $components = isset($options['components']) ? $options['components'] : [];
        $options['components'] = array_merge(
            $this->findAllComponents(),
            $components
        );
        return new DefaultComponent($options);
    }
}