<?php

namespace App\Controller;

use App\Entity\Company;
use App\Entity\User;
use App\Form\AccountEditFormType;
use App\Repository\CompanyRepository;
use App\Repository\UserRepository;
use http\Env\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AccountController extends AbstractController
{
    #[Route('/mon-compte', name: 'account')]
    public function index(CompanyRepository $companyRepository): Response
    {

        $user = $this->getUser();
        $companyRepository = $companyRepository->findAll();

//        dd($user);
        return $this->render('account/index.html.twig', [
            'user'=>$user,
            'company'=>$companyRepository
        ]);

    }


    #[Route('/modifier-mon-compte/{id}', name:'edit_account')]
    public function accountEdit(User $user, UserRepository $userRepository, \Symfony\Component\HttpFoundation\Request $request):Response
    {
        $form = $this->createForm(AccountEditFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $userRepository->add($user, true);
            $this->addFlash('success', 'Votre profil a bien été modifié');

            return $this->redirectToRoute('account');
        }
        return $this->render('account/edit.html.twig', [
            'form'=>$form->createView()
        ]);
    }
}
