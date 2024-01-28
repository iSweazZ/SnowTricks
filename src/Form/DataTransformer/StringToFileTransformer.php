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
        $fileDir = $_SERVER['DOCUMENT_ROOT'] . 'images/tricks/';
        //dd($value);
    }

    /**
     * @inheritDoc
     */
    public function reverseTransform(mixed $value)
    {
        // TODO: Implement reverseTransform() method.
    }
}