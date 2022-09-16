<?php

namespace App\Service;

use App\Entity\Player;
use App\Entity\Position;
use App\Form\Model\PlayerDto;
use App\Form\Model\PositionDto;
use App\Form\Type\PlayerFormType;
use App\Form\Type\PositionFormType;
use App\Repository\PositionRepository;
use App\Repository\TeamRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManagerInterface;
use League\Flysystem\FilesystemException;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class PlayerFormProcessor
{
    private FileUploader $fileUploader;
    private FormFactoryInterface $formFactory;
    private EntityManagerInterface $entityManager;
    private PositionRepository $positionRepository;
    private TeamRepository $teamRepository;
    public function __construct(
        FileUploader $fileUploader,
        FormFactoryInterface $formFactory,
        EntityManagerInterface $entityManager,
        PositionRepository $positionRepository,
        TeamRepository $teamRepository
    )
    {
        $this->fileUploader = $fileUploader;
        $this->formFactory = $formFactory;
        $this->entityManager = $entityManager;
        $this->positionRepository = $positionRepository;
        $this->teamRepository = $teamRepository;
    }

    /**
     * @throws FilesystemException
     */
    public function __invoke(Player $player, Request $request): array
    {
        $playerDto = PlayerDto::createFromPlayer($player);

        $form = $this->formFactory->create(PlayerFormType::class, $playerDto);
        $form->handleRequest($request);
        if(!$form->isSubmitted()){
            return [null, 'Form is not submitted'];
        }

        if($form->isValid()) {
            $player->setName($playerDto->name);
            $player->setAge($playerDto->age);
            $team = $this->teamRepository->find($playerDto->teamId);
            if(!$team) {
                return [null, 'Team not found'];
            }
            $player->setTeam($team);
            if($playerDto->base64Image) {
                $filename = $this->fileUploader->uploadBase64File($playerDto->base64Image);
                $player->setImage($filename);
            }
            if($playerDto->position !== null) {
                $position = $this->positionRepository->find($playerDto->position[0]->id ?? 0);
                if (!$position) {
                    $position = new Position();
                    $position->setName($playerDto->position[0]->name);
                    if($playerDto->position[0]->base64Image) {
                        $filename = $this->fileUploader->uploadBase64File($playerDto->position[0]->base64Image);
                        $position->setImage($filename);
                    }
                    $this->entityManager->persist($position);
                }
                $player->setPosition($position);
            } else {
                $player->setPosition(null);
            }
            $this->entityManager->persist($player);
            $this->entityManager->flush();
            $this->entityManager->refresh($player);
            return [$player, null];
        }
        return [null, $form];
    }
}