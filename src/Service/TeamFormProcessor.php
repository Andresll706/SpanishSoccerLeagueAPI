<?php

namespace App\Service;


use App\Entity\Player;
use App\Entity\Team;
use App\Form\Model\PlayerDto;
use App\Form\Model\TeamDto;
use App\Repository\PlayerRepository;
use App\Repository\TeamRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManagerInterface;
use League\Flysystem\FilesystemException;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class TeamFormProcessor
{

    private TeamRepository $teamRepository;
    private PlayerRepository $playerRepository;
    private FileUploader $fileUploader;
    private FormFactoryInterface $formFactory;
    private EntityManagerInterface $entityManager;

    public function __construct(
        TeamRepository $teamRepository,
        PlayerRepository $playerRepository,
        FileUploader $fileUploader,
        FormFactoryInterface $formFactory,
        EntityManagerInterface $entityManager
    )
    {
        $this->teamRepository = $teamRepository;
        $this->playerRepository = $playerRepository;
        $this->fileUploader = $fileUploader;
        $this->formFactory = $formFactory;
        $this->entityManager = $entityManager;
    }

    /**
     * @throws FilesystemException
     */
    public function __invoke(Team $team, Request $request): array
    {
        $teamDto = TeamDto::createFromTeam($team);

        $actualPlayersDto = new ArrayCollection();
        foreach ($team->getPlayers() as $player){
            $playerDto = PlayerDto::createFromPlayer($player);
            $teamDto->players[] = $playerDto;
            $actualPlayersDto->add($playerDto);
        }

        $form = $this->formFactory->create(TeamFormType::class, $teamDto);
        $form->handleRequest($request);
        if(!$form->isSubmitted()){
            return [null, 'Form is not submitted'];
        }

        if($form->isValid()){
            foreach ($actualPlayersDto as $originalPlayerDto){
                if(!in_array($originalPlayerDto, $teamDto->players)){
                    $player = $this->playerRepository->find($originalPlayerDto->id);
                    $team->removePlayer($player);
                }
            }

            foreach ($teamDto->players as $newPlayer) {
                if(!$actualPlayersDto->contains($newPlayer)){
                    $player = $this->playerRepository->find($newPlayer->id ?? 0);
                    if(!$player){
                        $player = new Player();
                        $player->setName($newPlayer->name);
                        $this->entityManager->persist($player);
                    }
                    $team->addPlayer($player);
                }
            }

            $team->setName($teamDto->name);
            if($teamDto->base64Image) {
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