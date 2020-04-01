<?php

namespace classes;

use interfaces\SaveInterface;

/**
 * Класс для обработки jpg изображений
 */
class Jpg extends Image implements SaveInterface
{
    /*
     * Качество jpg изображения
     *
     * var int
    */
    const JPG_QUALITY = 100;

    /**
     * Inheritdoc
     * @param int $width
     * @param int $height
     * @param array $uploadImage
     */
    public function __construct(int $width, int $height, array $uploadImage)
    {
        parent::__construct($width, $height, $uploadImage);
    }

    /**
     * Преобразование и сохранение изображения
     *
     * @return bool
     */
    public function saveImage(): bool
    {
        $srcImage = imagecreatefromjpeg($this->tmpImageFilename);

        $transfromNewImage = $this->getResizedImage($srcImage, $this->widthNew, $this->heightNew);

        $resNew = imagejpeg($transfromNewImage, $this->getUploadImageName(), self::JPG_QUALITY);

        return $resNew;
    }
}
