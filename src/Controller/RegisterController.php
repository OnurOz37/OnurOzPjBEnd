<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegisterType;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class RegisterController extends AbstractController
{
    #[Route('/inscription', name: 'inscription')]
    public function index(Request $request, UserPasswordEncoderInterface $encoder, UserRepository $userRepository): Response
    {
        $user = new User();
        $form = $this->createForm(RegisterType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $company = $form->getData();

            $image = $form->get('company')->get('logo')->getData();
            $fichier = md5(uniqid()) . '.' . $image->guessExtension();
            $image->move($this->getParameter('images_directory'), $fichier);

            $user = $form->getData();
            $password= $encoder->encodePassword($user, $user->getPassword());
            $user->setPassword($password);
            $company->getCompany()->setLogo($fichier);




            $userRepository->add($user, true);


            return $this->redirectToRoute('app_login');

//            dd($user);


        }

        return $this->render('register/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
