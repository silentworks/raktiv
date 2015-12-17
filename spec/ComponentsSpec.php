<?php

namespace spec\PeelingPixels\Raktiv;

use PeelingPixels\Raktiv\Raktiv;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ComponentsSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('PeelingPixels\Raktiv\Components');
    }

    public function it_should_be_able_to_add_a_component()
    {
        $basicComponent = (new Raktiv)->extend([
            'template' => '<h1>Hello World</h1>'
        ]);
        $this->addComponent('Basic', $basicComponent);
        $this->count()->shouldBe(1);
    }

    public function it_should_allow_adding_multiple_components()
    {
        $comp1 = (new Raktiv)->extend();
        $comp2 = (new Raktiv)->extend();
        $comp3 = (new Raktiv)->extend();

        $this->addComponents([
            'Basic1' => $comp1,
            'Basic2' => $comp2,
            'Basic3' => $comp3
        ]);
        $this->count()->shouldBe(3);
    }

    public function it_should_have_a_component()
    {
        $basicComponent = (new Raktiv)->extend([
            'template' => '<h1>Hello World</h1>'
        ]);
        $this->addComponent('Basic', $basicComponent);
        $components = $this->findAllComponents();
        $components['Basic']->shouldReturn($basicComponent);
    }

    public function it_should_return_a_string()
    {
        $basicComponent = (new Raktiv)->extend([
            'template' => '<h1>Hello World</h1>'
        ]);
        $this->addComponent('Basic', $basicComponent);
        $this->findComponent('Basic')->render()
            ->shouldReturn('<h1>Hello World</h1>');
    }

    public function it_should_parse_variables_and_return_a_string()
    {
        $basicComponent = (new Raktiv)->extend([
            'template' => '<h1>Hello {{name}}</h1>',
            'data' => [
                'name' => 'Andrew'
            ]
        ]);
        $this->addComponent('Basic', $basicComponent);
        $this->findComponent('Basic')->render()
            ->shouldReturn('<h1>Hello Andrew</h1>');
    }

    public function it_should_parse_components_and_return_a_string()
    {
        $yowComponent = (new Raktiv)->extend([
            'template' => 'Yow'
        ]);
        $talkComponent = (new Raktiv)->extend([
            'template' => '<Yow />, wah gwaan',
            'components' => [
                'Yow' => $yowComponent
            ]
        ]);

        $basicComponent = (new Raktiv)->extend([
            'template' => '<h1><Talk /></h1>',
            'components' => [
                'Talk' => $talkComponent,
            ]
        ]);

        $this->addComponent('Basic', $basicComponent);
        $this->findComponent('Basic')->render()
            ->shouldReturn('<h1>Yow, wah gwaan</h1>');
    }

    public function it_should_parse_components_from_base_component_and_return_a_string()
    {
        $yowComponent = Raktiv::extend([
            'template' => 'Yow'
        ]);

        $raktiv = Raktiv::make();
        $raktiv->addComponent('Yow', $yowComponent);

        $talkComponent = Raktiv::extend([
            'template' => '<Yow />, wah gwaan',
        ]);

        $basicComponent = Raktiv::extend([
            'template' => '<h1><Talk /></h1>',
            'components' => [
                'Talk' => $talkComponent,
            ]
        ]);

        $this->addComponent('Basic', $basicComponent);
        $this->findComponent('Basic')->render()
            ->shouldReturn('<h1>Yow, wah gwaan</h1>');
    }
}
