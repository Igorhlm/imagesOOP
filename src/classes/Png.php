<?php

namespace classes;

use interfaces\SaveInterface;

/**
 * Класс для обработки png изображений
 */
class Png extends Image implements SaveInterface
{
    /**
     * Степень сжатия png изображения
     *
     * @var int
     */
    const PNG_QUALITY = 0;

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
        $srcImage = imagecreatefrompng($this->tmpImageFilename);

        $transfromNewImage = $this->getResizedImage($srcImage, $this->widthNew, $this->heightNew);

        $resNew = imagepng($transfromNewImage, $this->getUploadImageName(), self::PNG_QUALITY);

        return $resNew;
    }
}
