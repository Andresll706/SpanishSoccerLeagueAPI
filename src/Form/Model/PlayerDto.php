<?php

namespace App\Form\Model;

use App\Entity\Player;
use App\Entity\Team;

class PlayerDto {
    public $name;
    public $base64Image;
    public $team;
    private $age;
    public $position;

    public static function createFromPlayer(Player $player): self
    {
        $dto = new self();
        $dto->name = $player->getName();
        $dto->age = $player->getAge();
        return $dto;
    }
}