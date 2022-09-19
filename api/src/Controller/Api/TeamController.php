<?php

namespace App\Controller\Api;

use App\Entity\Team;
use App\Repository\TeamRepository;
use App\Service\FileUploader;
use App\Service\Team\UpdateTeam;
use App\Service\TeamFormProcessor;
use Doctrine\ORM\EntityManagerInterface;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\View\View;
use League\Flysystem\FilesystemException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class TeamController extends AbstractFOSRestController
{
    const TEAM_NOT_FOUND = 'Team not found';
    const TEAM_DELETED = 'Team deleted';

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
            return View::create(self::TEAM_NOT_FOUND, Response::HTTP_BAD_REQUEST);
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

    /**
     *
     * @Rest\Patch(path="/api/team/{id}", requirements={"id"="\d+"} , name="patch_team")
     * @Rest\View(serializerGroups={"team"},serializerEnableMaxDepthChecks=true)
     * @throws FilesystemException
     */
    public function patch(
        int $id,
        TeamRepository $teamRepository,
        Request $request,
        UpdateTeam $updateTeam): View
    {
        $team = $teamRepository->find($id);

        if(!$team) {
            return View::create(self::TEAM_NOT_FOUND, Response::HTTP_BAD_REQUEST);
        }

        $data = json_decode($request->getContent(), true);
        $team = ($updateTeam)($data, $team);

        return View::create($team, Response::HTTP_OK);
    }



    /**
     *
     * @Rest\Delete(path="/api/team/{id}", requirements={"id"="\d+"}, name="delete_team")
     * @Rest\View(serializerGroups={"team"},serializerEnableMaxDepthChecks=true)
     */
    public function delete(
        int $id,
        TeamRepository $teamRepository,
        EntityManagerInterface $entityManager
    ): View
    {
        $team = $teamRepository->find($id);

        if(!$team) {
            return View::create(self::TEAM_NOT_FOUND, Response::HTTP_BAD_REQUEST);
        }

        $entityManager->remove($team);
        $entityManager->flush();

        return View::create(self::TEAM_DELETED, Response::HTTP_NO_CONTENT);
    }
}