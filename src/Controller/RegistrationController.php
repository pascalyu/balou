<?php

namespace App\Controller;

use App\Repository\UserRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use SymfonyCasts\Bundle\VerifyEmail\Exception\VerifyEmailExceptionInterface;
use SymfonyCasts\Bundle\VerifyEmail\VerifyEmailHelperInterface;

class RegistrationController extends AbstractController
{
    private $verifyEmailHelper;

    public function __construct(VerifyEmailHelperInterface $helper)
    {
        $this->verifyEmailHelper = $helper;
    }

    #[Route(path: '/verify', name: 'registration_confirmation_route')]
    public function verifyUserEmail(Request $request, UserRepository $userRepository, EntityManagerInterface $em): Response
    {
        $user = $this->getUser();
        $id = $request->get('id');

        if (null === $id) {
            return $this->redirect('http://stackoverflow.com');
        }

        $user = $userRepository->find($id);

        if (null === $user) {
            return $this->redirect('http://google.com');
        }

        try {
            $this->verifyEmailHelper->validateEmailConfirmation($request->getUri(), $user->getId(), $user->getEmail());
            $user->setIsVerified(true);
            $user->setIsEnabled(true);
            $em->persist($user);
            $em->flush();
        } catch (VerifyEmailExceptionInterface $e) {
            dump($e);
            //todo handle exceltion
        }
        return $this->redirect('http://localhost:3000/login');
    }
}
