<?php

namespace App\Controller;

use App\Entity\Candidates;
use App\Entity\Offers;
use App\Form\ApplyType;
use App\Repository\CandidatesRepository;
use App\Repository\OffersRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/candidats')]

class CandidatesController extends AbstractController
{
    #[Route('/{id}', name: 'candidates')]
    public function index(CandidatesRepository $candidatesRepository, OffersRepository $offersRepository, Offers $offers, $id): Response
    {


    $offers = $offersRepository->findById($id);
        $candidats = $candidatesRepository->findAll();
        return $this->render('candidates/index.html.twig', [
            'candidats'=>$candidats,
            'offers'=>$offers
        ]);
    }

    #[Route('/{id}/candidat', name: 'show_candidat')]
    public function showCandidat(Candidates $candidates):Response
    {

        return $this->render('candidates/show.html.twig', [
            'candidat'=>$candidates
        ]);
    }


//    #[Route('/postuler/{id}', name: 'apply')]
//    public function apply(CandidatesRepository $candidatesRepository, Request $request, OffersRepository $offersRepository, $id):Response
//    {
//        $candidat = new Candidates();
//        $form = $this->createForm(ApplyType::class, $candidat);
//        $form->handleRequest($request);
//        $offer = $offersRepository->findById($id);
//       //dd($offer[0]->id);
//
//        if ($form->isSubmitted() && $form->isValid())
//        {
//            $candidat = $form->getData();
//            $candidatesRepository->add($candidat, true);
//            $candidat->setOffers([$offer[0]->id]);
////            $candidat->setOffers($this);
//        }
//        return $this->render('candidates/apply.html.twig', [
//            'candidat'=>$candidat,
//            'form'=>$form->createView()
//        ]);
//    }
}
