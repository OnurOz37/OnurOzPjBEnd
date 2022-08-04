<?php

namespace App\Controller;

use App\Entity\Company;
use App\Entity\Offers;
use App\Entity\User;
use App\Form\CompanyEditType;
use App\Form\CompanyType;
use App\Repository\CompanyRepository;
use App\Repository\OffersRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CompanyController extends AbstractController
{
    #[Route('/entreprise/{id}', name: 'company', methods: ['GET', 'POST'])]
    public function index(Request $request, CompanyRepository $companyRepository): Response
    {
        $company = new Company();
        $form = $this->createForm(CompanyType::class, $company);
        $form->handleRequest($request);
        $user = $this->getUser();


        if ($form->isSubmitted() && $form->isValid()){
            $company = $form->getData();

            $image = $form->get('logo')->getData();
            $fichier = md5(uniqid()) . '.' . $image->guessExtension();
            $image->move($this->getParameter('images_directory'), $fichier);
            $company->setLogo($fichier);
            $company->setFkUser($this->getUser());





            $companyRepository->add($company, true);
            return $this->redirectToRoute('account');
        }
        return $this->render('company/index.html.twig', [
            'form'=>$form->createView(),
            'user'=>$user
        ]);
    }

    #[Route('/mes-entreprises', name:'show_companies')]
    public function showCompanies(CompanyRepository $companyRepository):Response
    {

        $company = $companyRepository->findAll();


        return $this->render('company/allCompanies.html.twig', [
            'company'=>$company
        ]);
    }

    #[Route('/mon-entreprise/{id}', name:'show_company', methods: ['GET','POST'])]
    public function showCompany(Company $company, OffersRepository $offersRepository):Response
    {

        $offers = $offersRepository->findAll();
        return $this->render('company/showCompany.html.twig', [
            'company'=>$company,
            'offers'=>$offers
        ]);
    }

    #[Route('/modifier-entreprise/{id}', name:'edit_company', methods: ['GET', 'POST'])]
    public function editCompany(Company $company, Request $request, CompanyRepository $companyRepository):Response
    {
        $form = $this->createForm(CompanyEditType::class, $company);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
//
//            $company = $form->getData();
//
//            $image = $form->get('logo')->getData();
//            $fichier = md5(uniqid()) . '.' . $image->guessExtension();
//            $image->move($this->getParameter('images_directory'), $fichier);
//            $company->setLogo($fichier);
            $companyRepository->add($company, true);
            $this->addFlash('success', 'Les modifications ont bien été enregistrées.');
            return $this->redirectToRoute('show_companies');
        }
        return $this->render('company/editCompany.html.twig', [
            'form'=>$form->createView(),
            'company'=>$company
        ]);
    }


}
