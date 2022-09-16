<?php

namespace App\Service;


use App\Entity\Player;
use App\Entity\Position;
use App\Entity\Team;
use App\Form\Model\PlayerDto;
use App\Form\Model\TeamDto;
use App\Form\Type\TeamFormType;
use App\Repository\PlayerRepository;
use App\Repository\PositionRepository;
use App\Repository\TeamRepository;
use App\Service\Player\UpdatePlayer;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManagerInterface;
use League\Flysystem\FilesystemException;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class TeamFormProcessor
{
    private PlayerRepository $playerRepository;
    private FileUploader $fileUploader;
    private FormFactoryInterface $formFactory;
    private EntityManagerInterface $entityManager;
    private PositionRepository $positionRepository;

    public function __construct(
        PlayerRepository $playerRepository,
        FileUploader $fileUploader,
        FormFactoryInterface $formFactory,
        EntityManagerInterface $entityManager,
        PositionRepository $positionRepository
    )
    {
        $this->playerRepository = $playerRepository;
        $this->fileUploader = $fileUploader;
        $this->formFactory = $formFactory;
        $this->entityManager = $entityManager;
        $this->positionRepository = $positionRepository;
    }

    /**
     * @throws FilesystemException
     */
    public function __invoke(Team $team, Request $request): array
    {
        $teamDto = TeamDto::createFromTeam($team);

        $form = $this->formFactory->create(TeamFormType::class, $teamDto);
        $form->handleRequest($request);
        if(!$form->isSubmitted()){
            return [null, 'Form is not submitted'];
        }

        if($form->isValid()){
            /* @var $newPlayer PlayerDto */
            foreach ($teamDto->players as $newPlayer) {
                $player = $this->playerRepository->find($newPlayer->id ?? 0);
                if(!$player){
                    $player = new Player();
                    $player->setName($newPlayer->name);
                    $player->setAge($newPlayer->age);
                    $player->setTeam($team);
                    $base64ImagePlayer = $newPlayer->base64Image ?? null;
                    if($base64ImagePlayer) {
                        $filenamePlayer = $this->fileUploader->uploadBase64File($newPlayer->base64Image);
                        $player->setImage($filenamePlayer);
                    }
                    /* @var $positions array */
                    $positions = $newPlayer->position;

                    if(!empty($positions)) {
                        $position = $this->positionRepository->find($positions[0]->id ?? 0);
                        if ($position === null) {
                            $position = new Position();
                            $position->setName($positions[0]->name);
                            if($positions[0]->base64Image) {
                                $filename = $this->fileUploader->uploadBase64File($positions[0]->base64Image);
                                $position->setImage($filename);
                            }
                            $this->entityManager->persist($position);
                        }
                        $player->setPosition($position);
                    } else {
                        $player->setPosition(null);
                    }
                    $this->entityManager->persist($player);
                }
                if($player->getTeam() != null) {
                    $player->setTeam($team);
                }
            }

            $team->setName($teamDto->name);
            $base64ImageTeam = $teamDto->base64Image ?? null;
            if($base64ImageTeam) {
                $filename = $this->fileUploader->uploadBase64File($teamDto->base64Image);
                $team->setShield($filename);
            }
            $this->entityManager->persist($team);
            $this->entityManager->flush();
            $this->entityManager->refresh($team);
            return [$team, null];
        }
        return [null, $form];
    }
}