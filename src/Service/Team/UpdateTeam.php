<?php

namespace App\Service\Team;

use App\Entity\Team;
use App\Service\FileUploader;
use DomainException;
use League\Flysystem\FilesystemException;

class UpdateTeam {

    private  FileUploader $fileUploader;

    public function __construct( FileUploader $fileUploader)
    {
        $this->fileUploader = $fileUploader;
    }

    /**
     * @throws FilesystemException
     */
    public function __invoke(array $data, Team $team): Team
    {
        if(array_key_exists('name', $data)) {
            if($data['name'] === null){
                throw new DomainException('Name cant be null');
            }
            $team->setName($data['name']);
        }

        if(array_key_exists('base64Image', $data)) {
            if($data['base64Image'] !== null){
                $filename = $this->fileUploader->uploadBase64File($data['base64Image']);
                $team->setShield($filename);
            } else {
                $team->setShield(null);
            }
        }

        return $team;
    }
}