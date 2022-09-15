<?php

namespace App\Controller\Api;

use App\Entity\Team;
use App\Repository\TeamRepository;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class TeamController extends AbstractFOSRestController
{
    /**
     *
     * @Rest\Get(path="/api/teams", name="get_teams")
     * @Rest\View(serializerGroups={"team"},serializerEnableMaxDepthChecks=true)
     */
    public function getAll(TeamRepository $repository): array
    {
        return $repository->findAll();
    }

    /**
     *
     * @Rest\Get(path="/api/team/{id}", requirements={"id"="\d+"}, name="get_team")
     * @Rest\View(serializerGroups={"team"},serializerEnableMaxDepthChecks=true)
     */
    public function get(TeamRepository $repository, int $id): View | Team
    {
        $team = $repository->find($id);

        if(!$team) {
            return View::create('Book not found', Response::HTTP_BAD_REQUEST);
        }

        return $team;
    }

    /**
     *
     * @Rest\Post(path="/api/team", name="post_team")
     * @Rest\View(serializerGroups={"team"},serializerEnableMaxDepthChecks=true)
     * @throws FilesystemException
     */
    public function postAction(TeamFormProcessor $teamFormProcessor, Request $request): View
    {
        $team = new Team();

        [$team, $error] = ($teamFormProcessor)($team, $request);

        $statusCode = $team ? Response::HTTP_CREATED : Response::HTTP_BAD_REQUEST;
        $data = $team ?? $error;
        return View::create($data, $statusCode);
    }


}