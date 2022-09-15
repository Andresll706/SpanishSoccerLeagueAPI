<?php

namespace App\Form\Model;

use App\Entity\Position;
use App\Entity\Team;

class PositionDto {
    public $name;
    public $base64Image;

    public static function createFromPosition(Position $position): self
    {
        $dto = new self();
        $dto->name = $position->getName();
        return $dto;
    }
}