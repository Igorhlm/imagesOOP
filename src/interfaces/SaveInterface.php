<?php

namespace interfaces;

/**
 * Интерфейс для сохранения изображений
 */
interface SaveInterface
{
    /**
     * Сохранение изображений
     *
     * @return bool
     */
    public function saveImage():bool;
}
