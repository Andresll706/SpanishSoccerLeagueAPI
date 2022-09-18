<?php

namespace App\Tests\Service;

use App\Service\FileUploader;
use League\Flysystem\FilesystemOperator;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class FileUploaderTest extends TestCase
{
    public function testSuccess()
    {
        $base64Image = "data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAABxIAAAIPCAYAAABXIpu4AAAAAXNSR0IArs4c6QAAAARnQU1BAACxjwv8YQUAAAAJcEhZcwAAEnQAABJ";

        $data = explode(',', $base64Image);

        /**
         * @var FilesystemOperator&MockObject $filesystemOperator
         */
        $filesystemOperator = $this->getMockBuilder(FilesystemOperator::class)
            ->disableOriginalConstructor()
            ->getMock();

        $filesystemOperator
            ->expects(self::exactly(1))
            ->method('write')
            ->with($this->isType('string'), base64_decode($data[1]));


        $sut = new FileUploader($filesystemOperator);

        $result = $sut->uploadBase64File($base64Image);

        $this->assertNotEmpty($result);
        $this->assertStringContainsString('.png', $result);
    }

}