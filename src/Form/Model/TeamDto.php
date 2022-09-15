<?php

namespace App\Form\Model;

use App\Entity\Team;

class TeamDto {
    public $name;
    public $base64Image;
    public $players;

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