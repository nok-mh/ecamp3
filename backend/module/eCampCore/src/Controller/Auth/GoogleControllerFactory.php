<?php

namespace eCamp\Core\Controller\Auth;

use Doctrine\ORM\EntityManager;
use eCamp\Core\EntityService\UserIdentityService;
use eCamp\Core\EntityService\UserService;
use Interop\Container\ContainerInterface;
use Laminas\Authentication\AuthenticationService;
use Laminas\ServiceManager\Factory\FactoryInterface;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

class GoogleControllerFactory implements FactoryInterface {
    /**
     * @param string $requestedName
     *
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     *
     * @return GoogleController
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null) {
        /** @var EntityManager $entityManager */
        $entityManager = $container->get('doctrine.entitymanager.orm_default');

        /** @var UserIdentityService $userIdentityService */
        $userIdentityService = $container->get(UserIdentityService::class);

        /** @var UserService $userService */
        $userService = $container->get(UserService::class);

        /** @var AuthenticationService $authenticationService */
        $authenticationService = $container->get(AuthenticationService::class);

        $hybridAuthConfig = $container->get('config')['hybridauth'];

        return new GoogleController(
            $entityManager,
            $userIdentityService,
            $userService,
            $authenticationService,
            $hybridAuthConfig
        );
    }
}
