<?php

namespace spec\PeelingPixels\Raktiv;

use PeelingPixels\Raktiv\Components;
use PeelingPixels\Raktiv\Raktiv;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ItemSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('PeelingPixels\Raktiv\Item');
    }

    public function it_should_take_a_component_loader(Components $components)
    {
        $this->beConstructedWith($components);
    }

    public function it_should_take_a_string_and_parse_it()
    {
        $this->beConstructedWith([
            'template' => '<p>Hello {{name}}</p>',
            'data' => [
                'name' => 'Andrew'
            ]
        ]);

        $this->render()
            ->shouldBe("<p>Hello Andrew</p>");
    }

    public function it_should_take_a_string_with_a_component_and_parse_it()
    {
        $testComponent = Raktiv::extend([
            'template' => '<p>Meet Little Bobby Raktiv</p>'
        ]);

        $this->beConstructedWith([
            'template' => '<p>Hello {{name}},</p><Test/>',
            'components' => [
                'Test' => $testComponent
            ],
            'data' => [
                'name' => 'Andrew'
            ]
        ]);

        $this->render()
            ->shouldBe("<p>Hello Andrew,</p><p>Meet Little Bobby Raktiv</p>");
    }

    public function it_should_take_a_string_with_another_component_and_parse_it()
    {
        $testComponent = Raktiv::extend([
            'template' => '<p>Meet Little Bobby Raktiv</p>'
        ]);

        $this->beConstructedWith([
            'template' => '<p>Hello {{name}},</p><Test/>',
            'data' => [
                'name' => 'Andrew'
            ]
        ]);
        $this->addComponents([
            'Test' => $testComponent
        ]);

        $this->render()
            ->shouldBe("<p>Hello Andrew,</p><p>Meet Little Bobby Raktiv</p>");
    }
}
