<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use App\Service\Entity\UserService;



class UserController extends AbstractController
{

    /**
     * @Route("/register", name="api_register", methods={"POST"})
     */
    public function register(Request $request, UserService $userService)
    {

        if($userService->create($request->request->all()))
        {
            return $this->json([
                'user' => $userService->getUser()
            ]);
        }


        return $this->json([
            'errors' => $userService->getErrors()
        ], 400);

    }

    /**
     * @Route("/login", name="api_login", methods={"POST"})
     */
    public function login()
    {
        return $this->json(['result' => true]);
    }

    /**
     * @Route("/profile", name="api_profile")
     * @IsGranted("ROLE_USER")
     */
    public function profile()
    {
        return $this->json([
            'user' => $this->getUser()
        ], 200, [], [
            'groups' => ['api']
        ]);
    }


    /**
     * @Route("/", name="api_home")
     */
    public function home()
    {
        return $this->json(['result' => true]);
    }

}
