<?php

namespace App\Controller;

use App\Entity\Candidates;
use App\Entity\Company;
use App\Entity\Offers;
use App\Form\ApplyType;
use App\Form\OfferType;
use App\Repository\CandidatesRepository;
use App\Repository\CompanyRepository;
use App\Repository\OffersRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ResponseEvent;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/annonces')]
class OfferController extends AbstractController
{
    #[Route('/ajouter', name: 'add_offer', methods: ['GET', 'POST'])]
    public function index(OffersRepository $offersRepository, Request $request): Response
    {
        $offers = new Offers();
        $form = $this->createForm(OfferType::class, $offers);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $offers->setPostedAt(new \DateTimeImmutable('now'));
            $offers->setFkCompany($this->getUser()->getCompany());
            $offersRepository->add($offers, true);
            $this->addFlash('success', "L'annonce a bien été publié. ");
            return $this->redirectToRoute('home', [], Response::HTTP_SEE_OTHER);
        }
        return $this->render('offer/index.html.twig', [
            'form'=>$form->createView(),
        ]);
    }

    #[Route('/mes-annonces', name: 'my_offers')]
    public function myOffers(OffersRepository $offersRepository, CompanyRepository $companyRepository):Response
    {
        $offers = $offersRepository->findAll();
        $user = $this->getUser();

        $company=$companyRepository->findBy([], ['id' => 'DESC']);


        return $this->render('offer/myOffer.html.twig', [
            'offers'=>$offers,
            'user'=>$user,
            'company'=>$company
        ]);
    }

    #[Route('/{id}/detail', name: 'show_offer', methods: ['GET', 'POST'])]
    public function showOffer(Offers $offer):Response
    {

        return $this->render('offer/show.html.twig', [
        'offer'=>$offer
        ]);
    }

    #[Route('/{id}/modifier', name: 'edit_offer', methods: ['GET', 'POST'])]
    public function editOffer(OffersRepository $offersRepository, Offers $offers, Request $request):Response
    {
        $form = $this->createForm(OfferType::class, $offers);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $offersRepository->add($offers, true);
            $this->addFlash('success', "L'annonce a bien été modifié. ");
            return $this->redirectToRoute('home', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('offer/edit.html.twig', [
            'form'=>$form->createView()
        ]);
    }

    #[Route('/{id}/postuler', name: 'apply')]
    public function apply(CandidatesRepository $candidatesRepository, Request $request, OffersRepository $offersRepository, $id):Response
    {
        $candidat = new Candidates();
        $form = $this->createForm(ApplyType::class, $candidat);
        $form->handleRequest($request);
        //$offer = $offersRepository->findById($id);
        //dd($offer[0]->id);
        $offer = $offersRepository->find($id);
       // dd($offer[0]->getId());

        if ($form->isSubmitted() && $form->isValid())
        {
            $candidat = $form->getData();
            $cvFile = $form->get('cv')->getData();


            $newFilename = uniqid().'.'.$cvFile->guessExtension();
            $cvFile->move($this->getParameter('cv_directory'), $newFilename);


            $candidat->setCv($newFilename);
            $candidat->setOffers($offer);
            $candidatesRepository->add($candidat, true);
            $this->addFlash('success', 'Votre candidature a bien été prise en compte' );

//            $candidat->setOffers($this);
        }
        return $this->render('candidates/apply.html.twig', [
            'candidat'=>$candidat,
            'form'=>$form->createView()
        ]);
    }

//    #[Route('/liste', name:'show_offers', methods: ['GET','POST'])]
//    public function showOffers(OffersRepository $offersRepository):Response
//    {
//        $offers = $offersRepository->findAll();
//        return $this->render('offer/showAllOffers.html.twig', [
//            'offers'=>$offers
//        ]);
//    }

    #[Route('{id}/supprimer', name: 'delete_offer', methods: ['GET', 'POST'])]
    public function deleteOffer(Offers $offers, OffersRepository $offersRepository):Response
    {
        $offersRepository->remove($offers, true);
        $this->addFlash('success', "L'annonce a bien été supprimée. ");
        return $this->redirectToRoute('home', [], Response::HTTP_SEE_OTHER);

    }
}
