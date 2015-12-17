<?php

namespace PeelingPixels\Raktiv;

class Components implements \Countable
{
    /**
     * @var ComponentInterface[]
     */
    protected $components = [];

    public function addComponents(array $components = [])
    {
        foreach ($components as $name => $component) {
            $this->addComponent($name, $component);
        }
    }

    public function addComponent($name, ComponentInterface $component)
    {
        $this->components[$name] = $component;
    }

    public function count()
    {
        return count($this->components);
    }

    public function hasComponent($name)
    {
        if (!array_key_exists($name, $this->components)) {
            return false;
        }
        return true;
    }

    public function findComponent($name)
    {
        if (!array_key_exists($name, $this->components)) {
            return null;
        }
        return $this->components[$name];
    }

    /**
     * @return ComponentInterface[]
     */
    public function findAllComponents()
    {
        return $this->components;
    }
}
