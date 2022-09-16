<?php

namespace App\Service;

use App\Entity\Position;
use App\Form\Model\PositionDto;
use App\Form\Type\PositionFormType;
use Doctrine\ORM\EntityManagerInterface;
use League\Flysystem\FilesystemException;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class PositionFormProcessor
{
    private FileUploader $fileUploader;
    private FormFactoryInterface $formFactory;
    private EntityManagerInterface $entityManager;
    public function __construct(
        FileUploader $fileUploader,
        FormFactoryInterface $formFactory,
        EntityManagerInterface $entityManager
    )
    {
        $this->fileUploader = $fileUploader;
        $this->formFactory = $formFactory;
        $this->entityManager = $entityManager;
    }

    /**
     * @throws FilesystemException
     */
    public function __invoke(Position $position, Request $request): array
    {
        $positionDto = PositionDto::createFromPosition($position);

        $form = $this->formFactory->create(PositionFormType::class, $positionDto);
        $form->handleRequest($request);
        if(!$form->isSubmitted()){
            return [null, 'Form is not submitted'];
        }

        if($form->isValid()) {
            $position->setName($positionDto->name);
            if($positionDto->base64Image) {
                $filename = $this->fileUploader->uploadBase64File($positionDto->base64Image);
                $position->setImage($filename);
            }
            $this->entityManager->persist($position);
            $this->entityManager->flush();
            $this->entityManager->refresh($position);
            return [$position, null];
        }
        return [null, $form];
    }
}