<?php

namespace spec\Slinp\Component\AdminBuilder\Form;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use PHPCR\PropertyInterface;
use PHPCR\PropertyType;

class PhpcrTypeGuesserSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Slinp\Component\AdminBuilder\Form\PhpcrTypeGuesser');
    }

    function it_should_guess_a_string_property(
        PropertyInterface $property
    )
    {
        $tests = array(
            PropertyType::STRING => 'text',
            PropertyType::BOOLEAN => 'checkbox',
            PropertyType::LONG => 'integer',
            PropertyType::DECIMAL => 'integer',
            PropertyType::DOUBLE => 'number',
            PropertyType::DATE => 'datetime',
        );

        foreach ($tests as $type => $formType) {
            $property->getType()->willReturn($type);
            $property->isMultiple()->willReturn(false);
            $typeGuess =$this->guessType($property);
            $typeGuess->getType()->shouldReturn($formType);
        }
    }

    function it_should_wrap_multiple_values_in_collection_type(
        PropertyInterface $property
    )
    {
        $property->getType()->willReturn(PropertyType::STRING);
        $property->isMultiple()->willReturn(true);
        $typeGuess = $this->guessType($property);
        $typeGuess->getType()->shouldReturn('collection');
        $typeGuess->getOptions()->shouldReturn(array('type' => 'text'));
    }
}
