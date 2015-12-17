<?php

namespace PeelingPixels\Raktiv;

abstract class BaseComponent extends Components implements ComponentInterface
{
    use CompilerTrait;

    private $template;
    private $data = [];

    public function __construct(array $options = [])
    {
        if (isset($options['components'])) {
            $this->addComponents($options['components']);
        }

        foreach ($options as $key => $value) {
            if (property_exists($this, $key)) {
                $this->$key = $value;
            }
        }
    }

    /**
     * @return string
     */
    public function getTemplate()
    {
        return $this->template;
    }

    /**
     * @return array
     */
    public function getData()
    {
        return $this->data;
    }

    public function render()
    {
        $template = $this->getTemplate();
        foreach ($this->findAllComponents() as $name => $component) {
            $template = $this->parseComponent(
                $name,
                $component,
                $template
            );
//            var_dump($name, $template);
        }
        return $this->compileRender($template, $this->getData());
    }
}