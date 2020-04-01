<?php

namespace classes;

use classes\Jpg;
use classes\Png;

class ImageFactory
{
    /**
     * @var string сообщение, если тип изображения не обрабатывается
     */
    const NOT_PROCESSING_IMAGE_TYPE = 'Этот тип изображений не обрабатывается';

    /**
     * @var array массив констант, соответствие типов изображений
     */
    const IMAGE_TYPES = [
        IMAGETYPE_JPEG => 'Jpg',
        IMAGETYPE_PNG => 'Png',
    ];

    /**
     * Создание объекта изображения
     * (в зависимости от типа изображения)
     *
     * @param array $uploadImage
     *
     * @return object
     */
    public static function create(array $uploadImage)
    {
        list($width, $height, $type) = getimagesize($uploadImage['tmp_name']);

        if (!in_array($type, array_keys(self::IMAGE_TYPES)))
            throw new \DomainException (self::NOT_PROCESSING_IMAGE_TYPE);

        switch ($type) {
            case IMAGETYPE_JPEG:
                return new Jpg($width, $height, $uploadImage);
                break;

            case IMAGETYPE_PNG:
                return new Png($width, $height, $uploadImage);
                break;
        }
    }
}
