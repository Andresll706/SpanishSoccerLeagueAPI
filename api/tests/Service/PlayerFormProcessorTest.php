<?php

namespace App\Tests\Service;

use App\Entity\Player;
use App\Form\Model\PlayerDto;
use App\Form\Type\PlayerFormType;
use App\Repository\PositionRepository;
use App\Repository\TeamRepository;
use App\Service\FileUploader;
use App\Service\PlayerFormProcessor;
use Doctrine\ORM\EntityManagerInterface;
use League\Flysystem\FilesystemOperator;
use Monolog\Test\TestCase;
use PHPUnit\Framework\MockObject\MockObject;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;

class PlayerFormProcessorTest  extends TestCase {

    public function testShouldReturnErroWhenIsNotSubmitted(){
        $player = new Player();
        $requestMock = $this->newRequestMock();

        $fileUploaderMock = $this->newFileUploaderMock();
        $formFactoryInterfaceMock = $this->newFormFactoryInterfaceMock();
        $entityManagerMock = $this->newEntityManagerInterfaceMock();
        $positionRepositoryMock = $this->newPositionRepositoryMock();
        $teamRepositoryMock = $this->newTeamRepositoryMock();
        $formInterfaceMock = $this->newFormInterfaceMock();

        $formFactoryInterfaceMock
            ->expects(self::exactly(1))
            ->method('create')
            ->with(PlayerFormType::class, self::anything())
            ->willReturn($formInterfaceMock);

        $formInterfaceMock
            ->expects(self::exactly(1))
            ->method('handleRequest')
            ->with($requestMock);

        $formInterfaceMock
            ->expects(self::exactly(1))
            ->method('isSubmitted')
            ->willReturn(false);

        $playerFormProcessor = new PlayerFormProcessor($fileUploaderMock, $formFactoryInterfaceMock, $entityManagerMock, $positionRepositoryMock, $teamRepositoryMock);

        [$playerReturn, $error] = ($playerFormProcessor)($player, $requestMock);

        $this->assertEquals(null, $playerReturn);
        $this->assertEquals('Form is not submitted',$error);
    }

    public function testShouldReturnErroWhenIsNotValid(){
        $player = new Player();
        $requestMock = $this->newRequestMock();

        $fileUploaderMock = $this->newFileUploaderMock();
        $formFactoryInterfaceMock = $this->newFormFactoryInterfaceMock();
        $entityManagerMock = $this->newEntityManagerInterfaceMock();
        $positionRepositoryMock = $this->newPositionRepositoryMock();
        $teamRepositoryMock = $this->newTeamRepositoryMock();
        $formInterfaceMock = $this->newFormInterfaceMock();

        $formFactoryInterfaceMock
            ->expects(self::exactly(1))
            ->method('create')
            ->with(PlayerFormType::class, self::anything())
            ->willReturn($formInterfaceMock);

        $formInterfaceMock
            ->expects(self::exactly(1))
            ->method('handleRequest')
            ->with($requestMock);

        $formInterfaceMock
            ->expects(self::exactly(1))
            ->method('isSubmitted')
            ->willReturn(true);

        $formInterfaceMock
            ->expects(self::exactly(1))
            ->method('isValid')
            ->willReturn(false);

        $playerFormProcessor = new PlayerFormProcessor($fileUploaderMock, $formFactoryInterfaceMock, $entityManagerMock, $positionRepositoryMock, $teamRepositoryMock);

        [$playerReturn, $error] = ($playerFormProcessor)($player, $requestMock);

        $this->assertNull($playerReturn);
        $this->assertNotNull($error);
        $this->assertEquals($formInterfaceMock, $error);
    }


    public function testShouldReturnErroWhenTeamNotFound(){
        $player = new Player();
        $requestMock = $this->newRequestMock();

        $fileUploaderMock = $this->newFileUploaderMock();
        $formFactoryInterfaceMock = $this->newFormFactoryInterfaceMock();
        $entityManagerMock = $this->newEntityManagerInterfaceMock();
        $positionRepositoryMock = $this->newPositionRepositoryMock();
        $teamRepositoryMock = $this->newTeamRepositoryMock();
        $formInterfaceMock = $this->newFormInterfaceMock();

        $formFactoryInterfaceMock
            ->expects(self::exactly(1))
            ->method('create')
            ->with(PlayerFormType::class, self::anything())
            ->willReturn($formInterfaceMock);

        $formInterfaceMock
            ->expects(self::exactly(1))
            ->method('handleRequest')
            ->with($requestMock);

        $formInterfaceMock
            ->expects(self::exactly(1))
            ->method('isSubmitted')
            ->willReturn(true);

        $formInterfaceMock
            ->expects(self::exactly(1))
            ->method('isValid')
            ->willReturn(false);

        $teamRepositoryMock
            ->expects(self::exactly(1))
            ->method('find')
            ->with(self::anything())
            ->willReturn(null);

        $playerFormProcessor = new PlayerFormProcessor($fileUploaderMock, $formFactoryInterfaceMock, $entityManagerMock, $positionRepositoryMock, $teamRepositoryMock);

        [$playerReturn, $error] = ($playerFormProcessor)($player, $requestMock);

        $this->assertNull($playerReturn);
        $this->assertNotNull($error);
        $this->assertEquals('Team not found', $error);
    }

    /**
     * @return FileUploader&MockObject
     */
    private function newFileUploaderMock()
    {
        /**
         * @var FileUploader&MockObject $fileUploaderMock
         */
        $fileUploaderMock = $this->getMockBuilder(FileUploader::class)
            ->disableOriginalConstructor()
            ->getMock();
        return $fileUploaderMock;
    }


    /**
     * @return FormFactoryInterface&MockObject
     */
    private function newFormFactoryInterfaceMock()
    {
        /**
         * @var FormFactoryInterface&MockObject $formFactoryInterfaceMock
         */
        $formFactoryInterfaceMock = $this->getMockBuilder(FormFactoryInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        return $formFactoryInterfaceMock;
    }

    /**
     * @return FormInterface&MockObject
     */
    private function newFormInterfaceMock()
    {
        /**
         * @var FormInterface&MockObject $formInterfaceMock
         */
        $formInterfaceMock = $this->getMockBuilder(FormInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        return $formInterfaceMock;
    }


    /**
     * @return EntityManagerInterface&MockObject
     */
    private function newEntityManagerInterfaceMock()
    {
        /**
         * @var EntityManagerInterface&MockObject $entityManagerInterfaceMock
         */
        $entityManagerInterfaceMock = $this->getMockBuilder(EntityManagerInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        return $entityManagerInterfaceMock;
    }

    /**
     * @return PositionRepository&MockObject
     */
    private function newPositionRepositoryMock()
    {
        /**
         * @var PositionRepository&MockObject $positionRepositoryMock
         */
        $positionRepositoryMock = $this->getMockBuilder(PositionRepository::class)
            ->disableOriginalConstructor()
            ->getMock();
        return $positionRepositoryMock;
    }

    /**
     * @return TeamRepository&MockObject
     */
    private function newTeamRepositoryMock()
    {
        /**
         * @var TeamRepository&MockObject $teamRepositoryMock
         */
        $teamRepositoryMock = $this->getMockBuilder(TeamRepository::class)
            ->disableOriginalConstructor()
            ->getMock();
        return $teamRepositoryMock;
    }


    /**
     * @return Request&MockObject
     */
    private function newRequestMock()
    {
        /**
         * @var Request&MockObject $requestMock
         */
        $requestMock = $this->getMockBuilder(Request::class)
            ->disableOriginalConstructor()
            ->getMock();
        return $requestMock;
    }



}