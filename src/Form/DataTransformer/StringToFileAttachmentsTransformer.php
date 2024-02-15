<?php

namespace App\Form\DataTransformer;

use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\HttpFoundation\File\File;

class StringToFileAttachmentsTransformer implements DataTransformerInterface
{
    /**
     * @inheritDoc
     */
    public function transform(mixed $value)
    {
        if (is_file($value)) {
            return $value;
        }
        if ($value === null) {
            return null;
        }
        return new File($_SERVER['DOCUMENT_ROOT'] . 'images\tricks\attachments\\' . $value);
    }

    /**
     * @inheritDoc
     */
    public function reverseTransform(mixed $value)
    {
        if (count($value) === 0) {
            return null;
        }
        if (is_file($value)) {
            return $value;
        }
        return new File($_SERVER['DOCUMENT_ROOT'] . 'images\tricks\attachments\\' . $value);
    }
}
