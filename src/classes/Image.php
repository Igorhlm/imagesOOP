<?php

declare(strict_types=1);

namespace classes;

/**
 * Абстрактный класс изображений
 */
abstract class Image
{
    /**
     * @var string Сообщение, если размеры не подходят для загрузки
     */
    const TOO_SMAL_IMAGE = 'Размеры изображения не подходят для загрузки';

    /**
     * @var string сообщение, если не удалось создать каталог для новых изображений
     */
    const NOT_DIRECTORY_UPLOADS_CREATED = 'Не удалось создать каталог для новых изображений';

    /**
     * @var string каталог для новых изображений
     */
    const UPLOADS_DIR = 'uploads';

    /**
     * @var int ширина нового изображения
     */
    const WIDTH_REQ = 640;

    /**
     * @var int высота нового изображения
     */
    const HEIGHT_REQ = 480;

    /**
     * Оригинальное имя файла-изображения
     *
     * @var string
     */
    protected $originalImageFilename;

    /**
     * Полное имя файла изображения во временной папке
     *
     * @var string
     */
    protected $tmpImageFullname;

    /**
     * Ширина исходного изображения
     *
     * @var int
     */
    protected $width;

    /**
     * Высота исходного изображения
     *
     * @var int
     */
    protected $height;

    /**
     * Рассчитанная ширина нового изображения
     *
     * @var int
     */
    protected $widthNew;

    /**
     * Рассчитанная высота нового изображения
     *
     * @var int
     */
    protected $heightNew;

    /**
     * @param int $width
     * @param int $height
     * @param array $uploadImage
     */
    public function __construct(int $width, int $height, array $uploadImage)
    {
        $this->originalImageFilename = $uploadImage['name'];
        $this->tmpImageFilename = $uploadImage['tmp_name'];

        $this->width = $width;
        $this->height = $height;

        if (!file_exists('uploads')) {
            $resCreateUploads = mkdir('uploads');
            if (!$resCreateUploads)
                throw new \RuntimeException(self::NOT_DIRECTORY_UPLOADS_CREATED);
        }

        $newSizes = $this->calcNewSizes();
        list($this->widthNew, $this->heightNew) = $newSizes;

        if ($this->width < self::WIDTH_REQ || $this->height < self::HEIGHT_REQ) {
            throw new \DomainException(self::TOO_SMAL_IMAGE);
        }
    }

    /**
     * Вычисление размеров для измененного изображений
     *
     * @return array
     */
    protected function calcNewSizes(): array
    {
        $ratioByWidth = self::WIDTH_REQ / $this->width;
        $widthNew = self::WIDTH_REQ;
        $heightNew = floor($this->height * $ratioByWidth);

        if ($heightNew > self::HEIGHT_REQ) {
            $ratioByHeight = self::HEIGHT_REQ / $heightNew;
            $heightNew = self::HEIGHT_REQ;
            $widthNew = floor($widthNew * $ratioByHeight);
        }

        //
        return [$widthNew, $heightNew];
    }

    /**
     * Получение полного имени нового изображения
     *
     * @return String
     */
    public function getUploadImageName(): string
    {
        return self::UPLOADS_DIR.DIRECTORY_SEPARATOR.$this->originalImageFilename;
    }

    /**
     * Получение преобразованного рисунка
     *
     * "So far, every PHP type is supported by both parameter
     * typehints and return types, except resources."
     * https://wiki.php.net/rfc/resource_typehint
     *
     * @param $srcImage
     * @param int $widthTransform
     * @param int $heightTransform
     *
     * @return
     */
    protected function getResizedImage($srcImage, int $widthTransform, int $heightTransform)
    {
        $newImageCanvas = imagecreatetruecolor($widthTransform, $heightTransform);

        imagecopyresampled(
            $newImageCanvas,
            $srcImage, 0, 0, 0, 0,
            $widthTransform, $heightTransform,
            $this->width, $this->height
        );

        return $newImageCanvas;
    }
}
