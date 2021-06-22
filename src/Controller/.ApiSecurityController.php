<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ApiSecurityController extends AbstractController
{
    /**
     * @Route("/api/login", name="api_security", methods={"POST"})
     */
    public function login(
        EntityManagerInterface $entityManager
    ): Response
    {
        $user = $this->getUser();

        $token = sha1(random_bytes(32));
        $now = new \DateTime();
        $tokenExpiration = $now->add(new \DateInterval('PT1H'));

        $user->setToken($token);
        $user->setTokenExpiration($tokenExpiration);

        $entityManager->flush();

        return $this->json([
            'username' => $user->getUserIdentifier(),
            'roles' => $user->getRoles(),
            'token' => $user->getToken(),
            'token_expiration' => $user->getTokenExpiration(),
        ]);
    }
}
