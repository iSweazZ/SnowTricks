<?php

namespace App\Form\DataTransformer;

use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\HttpFoundation\File\File;

class StringToFileTransformer implements DataTransformerInterface
{

    /**
     * @inheritDoc
     */
    public function transform(mixed $value)
    {
        if(is_file($value))
        {
            return $value;
        }
        if($value === null)
        {
            return null;
        }
        return new File($_SERVER['DOCUMENT_ROOT'] . 'images\tricks\\' . $value);
    }

    /**
     * @inheritDoc
     */
    public function reverseTransform(mixed $value)
    {
        if(is_file($value))
        {
            return $value;
        }
        if($value === null)
        {
            return null;
        }
        return new File($_SERVER['DOCUMENT_ROOT'] . 'images\tricks\\' . $value);
    }
}