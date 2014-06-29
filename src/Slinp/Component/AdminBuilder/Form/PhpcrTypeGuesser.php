<?php

namespace Slinp\Component\AdminBuilder\Form;

use PHPCR\PropertyInterface;
use PHPCR\PropertyType;
use Symfony\Component\Form\Guess\TypeGuess;
use Symfony\Component\Form\Guess\Guess;

/**
 * Note this is the same idea as the form components type guessers
 * except that we accept an actual object (the PHPCR node) rather
 * than the class.
 *
 * @author Daniel Leech <daniel@dantleech.com>
 */
class PhpcrTypeGuesser
{
    public function guessType(PropertyInterface $property)
    {
        $value = $property->getType();

        switch (intval($value)) {
            case PropertyType::UNDEFINED :
            case PropertyType::STRING :
                $typeGuess = new TypeGuess('text', array(), Guess::MEDIUM_CONFIDENCE);
                break;
            case PropertyType::BOOLEAN :
                $typeGuess = new TypeGuess('checkbox', array(), Guess::HIGH_CONFIDENCE);
                break;
            case PropertyType::DOUBLE :
                $typeGuess = new TypeGuess('number', array(), Guess::MEDIUM_CONFIDENCE);
                break;
            case PropertyType::LONG :
            case PropertyType::DECIMAL :
                $typeGuess = new TypeGuess('integer', array(), Guess::MEDIUM_CONFIDENCE);
                break;
            case PropertyType::DATE :
                $typeGuess = new TypeGuess('datetime', array(), Guess::HIGH_CONFIDENCE);
                break;
            case PropertyType::NAME :
            case PropertyType::PATH :
            case PropertyType::REFERENCE :
            case PropertyType::WEAKREFERENCE :
            case PropertyType::URI :
                $typeGuess = new TypeGuess('text', array(), Guess::MEDIUM_CONFIDENCE);
                break;
            case PropertyType::BINARY :
                $typeGuess = null;
                break;
            default:
                throw new \InvalidArgumentException('Unknown PHPCR property type (' . $value. ') given.');
        }

        if ($property->isMultiple()) {
            $typeGuess = new TypeGuess('collection', array('type' => $typeGuess->getType()), $typeGuess->getConfidence());
        }

        return $typeGuess;
    }
}
