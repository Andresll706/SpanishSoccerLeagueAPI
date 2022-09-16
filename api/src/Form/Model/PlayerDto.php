<?php

namespace App\Form\Model;

use App\Entity\Player;
use App\Entity\Position;

class PlayerDto {
    public int | null $id;
    public string | null $name;
    public int | null $age;
    public string | null $base64Image;
    public array | null $position;
    public int | null $teamId;

    public static function createFromPlayer(Player $player): self
    {
        $dto = new self();
        $dto->name = $player->getName();
        $dto->age = $player->getAge();
        $dto->base64Image = null;
        return $dto;
    }
}