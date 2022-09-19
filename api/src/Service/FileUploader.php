<?php

namespace App\Service;

use League\Flysystem\FilesystemException;
use League\Flysystem\FilesystemOperator;

class FileUploader {

    private FilesystemOperator $defaultStorage;
    public function __construct(FilesystemOperator $defaultStorage)
    {
        $this->defaultStorage = $defaultStorage;
    }

    /**
     * @throws FilesystemException
     */
    public function uploadBase64File(string $base64File): string
    {
        $extension = explode('/', mime_content_type($base64File))[1];
        $data = explode(',', $base64File);
        $filename = sprintf('%s.%s', uniqid('image_',true), $extension);
        $this->defaultStorage->write($filename, base64_decode($data[1]));

        return $filename;
    }
}