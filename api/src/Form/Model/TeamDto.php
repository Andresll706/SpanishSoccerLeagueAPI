<?php

namespace App\Form\Model;

use App\Entity\Team;

class TeamDto {
    public string | null $name;
    public string | null $base64Image;
    public array | null $players;

    public function __construct()
    {
        $this->players = [];
    }

    public static function createFromTeam(Team $team): self
    {
        $dto = new self();
        $dto->name = $team->getName();
        return $dto;
    }
}