<?php

namespace App\Controller\Api;

use App\Entity\Player;
use App\Repository\PlayerRepository;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\View\View;
use League\Flysystem\FilesystemException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class PlayerController extends AbstractFOSRestController
{
    /**
     *
     * @Rest\Get(path="/api/players", name="get_players")
     * @Rest\View(serializerGroups={"team"},serializerEnableMaxDepthChecks=true)
     */
    public function getAll(PlayerRepository $repository): array
    {
        return $repository->findAll();
    }

    /**
     *
     * @Rest\Get(path="/api/player/{id}", requirements={"id"="\d+"}, name="get_player")
     * @Rest\View(serializerGroups={"team"},serializerEnableMaxDepthChecks=true)
     */
    public function get(PlayerRepository $repository, int $id): View | Player
    {
        $player = $repository->find($id);

        if(!$player) {
            return View::create('Player not found', Response::HTTP_BAD_REQUEST);
        }

        return $player;
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
        $data = $player ?? $error;
        return View::create($data, $statusCode);
    }

}