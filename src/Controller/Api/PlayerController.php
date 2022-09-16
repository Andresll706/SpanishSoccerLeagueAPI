<?php

namespace App\Controller\Api;

use App\Entity\Player;
use App\Repository\PlayerRepository;
use App\Service\FileUploader;
use App\Service\Player\UpdatePlayer;
use App\Service\PlayerFormProcessor;
use Doctrine\ORM\EntityManagerInterface;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\View\View;
use JMS\Serializer\SerializerBuilder;
use League\Flysystem\FilesystemException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class PlayerController extends AbstractFOSRestController
{
    const PLAYER_NOT_FOUND = 'Player not found';
    const PLAYER_DELETED = 'Player deleted';

    /**
     *
     * @Rest\Get(path="/api/players", name="get_players")
     * @Rest\View(serializerGroups={"team"},serializerEnableMaxDepthChecks=true)
     */
    public function getAll(PlayerRepository $repository): string
    {
        return $this->serialize($repository->findAll());
    }

    /**
     *
     * @Rest\Get(path="/api/player/{id}", requirements={"id"="\d+"}, name="get_player")
     * @Rest\View(serializerGroups={"team"},serializerEnableMaxDepthChecks=true)
     */
    public function get(PlayerRepository $repository, int $id): View | string
    {
        $player = $repository->find($id);

        if(!$player) {
            return View::create(self::PLAYER_NOT_FOUND, Response::HTTP_BAD_REQUEST);
        }

        return $this->serialize($player);
    }

    /**
     *
     * @Rest\Post(path="/api/player", name="post_player")
     * @Rest\View(serializerGroups={"team"},serializerEnableMaxDepthChecks=true)
     * @throws FilesystemException
     */
    public function postAction(PlayerFormProcessor $playerFormProcessor, Request $request): View
    {
        $player = new Player();

        [$player, $error] = ($playerFormProcessor)($player, $request);

        $statusCode = $player ? Response::HTTP_CREATED : Response::HTTP_BAD_REQUEST;
        $data = $player ? $this->serialize($player) : $error;
        return View::create($data, $statusCode);
    }


    /**
     *
     * @Rest\Patch(path="/api/player/{id}", requirements={"id"="\d+"} , name="patch_player")
     * @Rest\View(serializerGroups={"team"},serializerEnableMaxDepthChecks=true)
     * @throws FilesystemException
     */
    public function patch(int $id, PlayerRepository $playerRepository, Request $request, UpdatePlayer $updatePlayer): View
    {
        $playerEntity = $playerRepository->find($id);

        if(!$playerEntity) {
            return View::create(self::PLAYER_NOT_FOUND, Response::HTTP_BAD_REQUEST);
        }

        $data = json_decode($request->getContent(), true);
        $player =  ($updatePlayer)($playerEntity, $data);

        return View::create($this->serialize($player), Response::HTTP_OK);
    }


    /**
     *
     * @Rest\Delete(path="/api/player/{id}", requirements={"id"="\d+"}, name="delete_player")
     * @Rest\View(serializerGroups={"team"},serializerEnableMaxDepthChecks=true)
     */
    public function delete(
        int                    $id,
        PlayerRepository       $playerRepository,
        EntityManagerInterface $entityManager
    ): View
    {
        $player = $playerRepository->find($id);

        if(!$player) {
            return View::create(self::PLAYER_NOT_FOUND, Response::HTTP_BAD_REQUEST);
        }

        $entityManager->remove($player);
        $entityManager->flush();

        return View::create(self::PLAYER_DELETED, Response::HTTP_NO_CONTENT);
    }

    private function serialize($data): string
    {
        $serializer = SerializerBuilder::create()->build();
        return $serializer->serialize($data, 'json');
    }

}