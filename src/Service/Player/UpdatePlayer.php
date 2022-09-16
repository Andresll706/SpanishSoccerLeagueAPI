<?php

namespace App\Service\Player;

use App\Entity\Player;
use App\Entity\Position;
use App\Repository\PositionRepository;
use App\Repository\TeamRepository;
use App\Service\FileUploader;
use Doctrine\ORM\EntityManagerInterface;
use DomainException;
use League\Flysystem\FilesystemException;

class UpdatePlayer {
    private FileUploader $fileUploader;
    private TeamRepository $teamRepository;
    private PositionRepository $positionRepository;
    private EntityManagerInterface $entityManager;

    public function __construct(
        FileUploader $fileUploader,
        TeamRepository $teamRepository,
        PositionRepository $positionRepository,
        EntityManagerInterface $entityManager
    )
    {
        $this->fileUploader = $fileUploader;
        $this->teamRepository = $teamRepository;
        $this->positionRepository = $positionRepository;
        $this->entityManager = $entityManager;
    }
    /**
     * @throws FilesystemException
     */
    public function __invoke(Player $player, array $data): Player
    {
        $player = $this->updateName($data, $player);

        $player = $this->updateAge($data, $player);

        $player = $this->updateImage($data, $player);

        $player = $this->updateTeam($data, $player);

        return $this->updatePosition($data, $player);
    }

    /**
     * @param array $data
     * @param Player $player
     * @return Player
     */
    public function updateName(array $data, Player $player): Player
    {
        if (array_key_exists('name', $data)) {
            if ($data['name'] === null) {
                throw new DomainException('Name cant be null');
            }
            $player->setName($data['name']);
        }
        return $player;
    }

    /**
     * @param array $data
     * @param Player $player
     * @return Player
     */
    public function updateAge(array $data, Player $player): Player
    {
        if (array_key_exists('age', $data)) {
            if ($data['age'] === null) {
                throw new DomainException('Age cant be null');
            }
            $player->setAge($data['age']);
        }
        return $player;
    }

    /**
     * @param array $data
     * @param Player $player
     * @return Player
     * @throws FilesystemException
     */
    public function updateImage(array $data, Player $player): Player
    {
        if (array_key_exists('base64Image', $data)) {
            if ($data['base64Image'] !== null) {
                $filename = $this->fileUploader->uploadBase64File($data['base64Image']);
                $player->setImage($filename);
            } else {
                $player->setImage(null);
            }
        }
        return $player;
    }

    /**
     * @param array $data
     * @param Player $player
     * @return Player
     */
    public function updateTeam(array $data, Player $player): Player
    {
        if (array_key_exists('teamId', $data)) {
            if ($data['teamId'] === null) {
                throw new DomainException('TeamId cant be null');
            }
            $teamInRepository = $this->teamRepository->find($data['teamId']);
            $player->setTeam($teamInRepository);
        }

        return $player;
    }

    /**
     * @param array $data
     * @param Player $player
     * @return Player
     * @throws FilesystemException
     */
    public function updatePosition(array $data, Player $player): Player
    {
        if (array_key_exists('position', $data)) {
            if ($data['position'] === null) {
                $player->setPosition(null);
            } else {
                $positionInRepository = $this->positionRepository->find($data['position']['0']['id'] ?? 0);
                if (!$positionInRepository) {
                    $newPosition = new Position();
                    $newPosition->setName($data['position']['0']['name']);
                    $base64Image = $data['position']['0']['base64Image'] ?? null;
                    if ($base64Image) {
                        $filename = $this->fileUploader->uploadBase64File($data['position']['0']['base64Image']);
                        $newPosition->setImage($filename);
                    }
                    $this->entityManager->persist($newPosition);
                    $this->entityManager->flush();
                    $player->setPosition($newPosition);
                }
            }
        }

        return $player;
    }


}