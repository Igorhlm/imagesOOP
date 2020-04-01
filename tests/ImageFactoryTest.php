<?php

declare(strict_types=1);

namespace tests;

use PHPUnit\Framework\TestCase;

use classes\ImageFactory;
use classes\Image;

/**
 * Тесты для ImageFactory
 */
class ImageFactoryTest extends TestCase
{
    const TEST_IMAGE = 'tests/data/Mart_Levitan.jpg';

    public $img;

    public $uploadImage;

    public function setUp(): void
    {
        parent::setUp();

        if (file_exists(self::TEST_IMAGE)) {
            $this->uploadImage['tmp_name'] = self::TEST_IMAGE;

            $fileInfo = pathinfo(self::TEST_IMAGE);
            $this->uploadImage['name'] = $fileInfo['basename'];
        } else {
            echo 'Отсутствует изображение для тестирования' . PHP_EOL . PHP_EOL;
            exit;
        }
    }

    /**
     * Проверка существования нового изображения
     */
    public function testNewImageExists_Success()
    {
        $this->img = ImageFactory::create($this->uploadImage);
        $this->img->saveImage($this->img->getUploadImageName());

        $this->assertFileExists($this->img->getUploadImageName());
    }

    /**
     * Проверка размеров нового изображения
     */
    public function testNewImageSizes_Success()
    {
        $this->img = ImageFactory::create($this->uploadImage);
        $this->img->saveImage($this->img->getUploadImageName());

        list($width, $height, $type) = getimagesize($this->img->getUploadImageName());

        $this->assertLessThanOrEqual(
            Image::HEIGHT_REQ,
            $height,
            'Высота нового изображения больше заданной'
        );
        $this->assertLessThanOrEqual(
            Image::WIDTH_REQ,
            $width,
            'Ширина нового изображения больше заданной'
        );
    }

    public function tearDown(): void
    {
        if (file_exists($this->img->getUploadImageName()))
            unlink($this->img->getUploadImageName());
    }
}
