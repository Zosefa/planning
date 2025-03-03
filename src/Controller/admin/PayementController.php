<?php

namespace App\Controller\admin;

use App\Entity\ModePayement;
use App\Form\PayementType;
use App\Repository\ModePayementRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted('ROLE_ADMIN')]
#[Route('Admin/payement', name: 'app_payement')]
class PayementController extends AbstractController
{

    #[Route('', name: '')]
    public function insert(EntityManagerInterface $em,ModePayementRepository $modePayementRepository,Request $request): Response
    {
        $ModePayement = new ModePayement();
        $form = $this->createForm(PayementType::class, $ModePayement);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $em->persist($ModePayement);
            $em->flush();
            $this->addFlash('success', 'Nouveau payement ajouter !');
            return $this->redirectToRoute('app_payement');
        }

        $payements = $modePayementRepository->findAll();
        // dd($payements);
        
        return $this->render('admin/Payement/payement.html.twig',[
            'payements' => $payements,
            'form' => $form,
            'user' => $this->getUser() 
        ]);
    }

    #[Route('/delete/{id}',name: '_delete')]
    public function delete(ModePayement $payement,EntityManagerInterface $em)
    {
        $em->remove($payement);
        $em->flush();
        $this->addFlash('success', 'Payement Supprimer !');
        return $this->redirectToRoute('app_payement');
    }

    #[Route('/edit/{id}',name:'_edit')]
    public function update(ModePayement $payement,EntityManagerInterface $em,Request $request)
    {
        if($request->isMethod('POST')){
            $payement->setPayement($request->request->get('payement'));

            $em->persist($payement);
            $em->flush();
            $this->addFlash('success', 'Payement modifier !');
            return $this->redirectToRoute('app_payement');
        }
        
    }
}