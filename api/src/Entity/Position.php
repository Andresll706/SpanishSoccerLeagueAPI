<?php

namespace App\Entity;

use App\Repository\PositionRepository;
use App\Service\FileUploader;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use DomainException;
use League\Flysystem\FilesystemException;

#[ORM\Entity(repositoryClass: PositionRepository::class)]
class Position
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 512, nullable: true)]
    private ?string $image = null;

    #[ORM\OneToMany(mappedBy: 'position', targetEntity: Player::class)]
    private Collection $players;

    public function __construct()
    {
        $this->players = new ArrayCollection();
    }

    /**
     * @throws FilesystemException
     */
    public function patch(array $data, FileUploader $fileUploader): self
    {
        if(array_key_exists('name', $data)) {
            if($data['name'] === null){
                throw new DomainException('Name cant be null');
            }
            $this->name = $data['name'];
        }

        if(array_key_exists('base64Image', $data)) {
            if($data['base64Image'] !== null){
                $filename = $fileUploader->uploadBase64File($data['base64Image']);
                $this->image = $filename;
            } else {
                $this->image = null;
            }
        }

        return $this;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): self
    {
        $this->image = $image;

        return $this;
    }

    /**
     * @return Collection<int, Player>
     */
    public function getPlayers(): Collection
    {
        return $this->players;
    }

    public function addPlayer(Player $player): self
    {
        if (!$this->players->contains($player)) {
            $this->players->add($player);
            $player->setPosition($this);
        }

        return $this;
    }

    public function removePlayer(Player $player): self
    {
        if ($this->players->removeElement($player)) {
            // set the owning side to null (unless already changed)
            if ($player->getPosition() === $this) {
                $player->setPosition(null);
            }
        }

        return $this;
    }
}
