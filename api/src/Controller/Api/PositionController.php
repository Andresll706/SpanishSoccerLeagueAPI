<?php

namespace App\Controller\Api;

use App\Entity\Position;
use App\Repository\PositionRepository;
use App\Service\FileUploader;
use App\Service\PositionFormProcessor;
use Doctrine\ORM\EntityManagerInterface;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\View\View;
use League\Flysystem\FilesystemException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class PositionController extends AbstractFOSRestController
{
    const POSITION_NOT_FOUND = 'Position not found';
    const POSITION_DELETED = 'Position deleted';

    /**
     *
     * @Rest\Get(path="/api/positions", name="get_positions")
     * @Rest\View(serializerGroups={"team"},serializerEnableMaxDepthChecks=true)
     */
    public function getAll(PositionRepository $repository): array
    {
        return $repository->findAll();
    }

    /**
     *
     * @Rest\Get(path="/api/position/{id}", requirements={"id"="\d+"}, name="get_position")
     * @Rest\View(serializerGroups={"team"},serializerEnableMaxDepthChecks=true)
     */
    public function get(PositionRepository $repository, int $id): View | Position
    {
        $position = $repository->find($id);

        if(!$position) {
            return View::create(self::POSITION_NOT_FOUND, Response::HTTP_BAD_REQUEST);
        }

        return $position;
    }


    /**
     *
     * @Rest\Post(path="/api/position", name="post_position")
     * @Rest\View(serializerGroups={"team"},serializerEnableMaxDepthChecks=true)
     * @throws FilesystemException
     */
    public function postAction(PositionFormProcessor $positionFormProcessor, Request $request): View
    {
        $position = new Position();

        [$position, $error] = ($positionFormProcessor)($position, $request);

        $statusCode = $position ? Response::HTTP_CREATED : Response::HTTP_BAD_REQUEST;
        $data = $position ?? $error;
        return View::create($data, $statusCode);
    }

    /**
     *
     * @Rest\Patch(path="/api/positon/{id}", requirements={"id"="\d+"} , name="patch_position")
     * @Rest\View(serializerGroups={"team"},serializerEnableMaxDepthChecks=true)
     * @throws FilesystemException
     */
    public function patch(int $id, PositionRepository $positionRepository, Request $request, FileUploader $fileUploader): View
    {
        $positionEntity = $positionRepository->find($id);

        if(!$positionEntity) {
            return View::create(self::POSITION_NOT_FOUND, Response::HTTP_BAD_REQUEST);
        }

        $data = json_decode($request->getContent(), true);
        $position =  $positionEntity->patch($data, $fileUploader);

        return View::create($position, Response::HTTP_OK);
    }


    /**
     *
     * @Rest\Delete(path="/api/position/{id}", requirements={"id"="\d+"}, name="delete_position")
     * @Rest\View(serializerGroups={"team"},serializerEnableMaxDepthChecks=true)
     */
    public function delete(
        int                    $id,
        PositionRepository     $positionRepository,
        EntityManagerInterface $entityManager
    ): View
    {
        $position = $positionRepository->find($id);

        if(!$position) {
            return View::create(self::POSITION_NOT_FOUND, Response::HTTP_BAD_REQUEST);
        }

        $entityManager->remove($position);
        $entityManager->flush();

        return View::create(self::POSITION_DELETED, Response::HTTP_NO_CONTENT);
    }
}