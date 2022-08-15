<?php

namespace MyBudget\Tests\Domain\User\UseCases\CreateGroup;

use MyBudget\Domain\Entity\User\Account;
use MyBudget\Domain\Entity\User\UserGroup;
use MyBudget\Domain\Exceptions\HttpMyBudgetException;
use MyBudget\Domain\Shared\Authentication\SecurityAuthInterface;
use MyBudget\Domain\Shared\Database\Ports\Output\CommonDatabaseActionInterface;
use MyBudget\Domain\Shared\Database\Ports\Output\User\UserGroupDALInterface;
use MyBudget\Domain\Shared\Ports\Output\StatusCodePresenterInterface;
use MyBudget\Domain\User\UseCases\CreateGroup\DTO\CreateGroupRequest;
use MyBudget\Domain\User\UseCases\CreateGroup\Ports\Input\UseCaseInterface;
use MyBudget\Domain\User\UseCases\CreateGroup\UseCase;
use MyBudget\UI\Presenters\Shared\StatusCodePresenter;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class UseCaseTest extends KernelTestCase
{
    private StatusCodePresenterInterface $presenter;
    private UseCaseInterface $useCase;
    private UserGroupDALInterface $userGroupDAL;
    private SecurityAuthInterface $securityAuth;

    protected function setUp(): void
    {
        self::bootKernel();
        $container = static::getContainer();
        $this->presenter = new StatusCodePresenter();
        $this->userGroupDAL = $this->createMock(UserGroupDALInterface::class);
        $this->securityAuth = $this->createMock(SecurityAuthInterface::class);
        $this->databaseAction = $this->createMock(CommonDatabaseActionInterface::class);
        $this->validator = $container->get(ValidatorInterface::class);
    }

    /**
     * @return void
     */
    public function testCreateGroupWithInvalidPayload(): void
    {
        $this->useCase = new UseCase(
            $this->userGroupDAL,
            $this->securityAuth,
            $this->databaseAction,
            $this->validator
        );
        $this->expectException(HttpMyBudgetException::class);
        $this->useCase->execute(
            new CreateGroupRequest([]),
            $this->presenter
        );

        $this->expectException(HttpMyBudgetException::class);
        $this->useCase->execute(
            new CreateGroupRequest(['name' => 'Test']),
            $this->presenter
        );

        $this->expectException(HttpMyBudgetException::class);
        $this->useCase->execute(
            new CreateGroupRequest(['name' => 'Test', 'code' => 'Un code']),
            $this->presenter
        );

        $this->expectException(HttpMyBudgetException::class);
        $this->useCase->execute(
            new CreateGroupRequest(['name' => 'Test', 'code' => 'Un code', 'password' => '123456']),
            $this->presenter
        );
    }

    public function testWithGroupAlreadyExist(): void
    {
        $userGroupMock = $this->createMock(UserGroup::class);
        $this->userGroupDAL->method('findByCode')->willReturn($userGroupMock);
        $this->useCase = new UseCase(
            $this->userGroupDAL,
            $this->securityAuth,
            $this->databaseAction,
            $this->validator
        );
        $this->expectException(HttpMyBudgetException::class);
        $this->useCase->execute(
            new CreateGroupRequest(['name' => 'Test', 'code' => 'Un code', 'password' => '12345678']),
            $this->presenter
        );
    }

    public function testWithUserHaveAlreadyGroup()
    {
        $this->useCase = new UseCase(
            $this->userGroupDAL,
            $this->securityAuth,
            $this->databaseAction,
            $this->validator
        );
        $userGroupMock = $this->createMock(UserGroup::class);
        $userMock = $this->createMock(Account::class);
        $userMock->method('getUserGroup')->willReturn($userGroupMock);
        $this->securityAuth->method('getCurrentUser')->willReturn($userMock);
        $this->expectException(HttpMyBudgetException::class);
        $this->useCase->execute(
            new CreateGroupRequest(['name' => 'Test', 'code' => 'Un code', 'password' => '12345678']),
            $this->presenter
        );
    }

    public function testSuccessfulCreate(): void
    {
        $this->userGroupDAL->method('findByCode')->willReturn(null);
        $this->useCase = new UseCase(
            $this->userGroupDAL,
            $this->securityAuth,
            $this->databaseAction,
            $this->validator
        );
        $this->useCase->execute(
            new CreateGroupRequest(['name' => 'Test', 'code' => 'Un code', 'password' => '12345678']),
            $this->presenter
        );
        $this->assertEquals(Response::HTTP_CREATED, $this->presenter->getStatusCode());
    }
}
