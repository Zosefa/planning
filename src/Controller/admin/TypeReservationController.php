<?php
namespace App\Controller\admin;

use App\Entity\TypeReservation;
use App\Form\TypeReservationType;
use App\Repository\TypeReservationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted('ROLE_ADMIN')]
#[Route('Admin/type-reservation',name: 'app_type')]
class TypeReservationController extends AbstractController{

    #[Route('',name: '')]
    public function find(TypeReservationRepository $typeReservationRepository, Request $request, EntityManagerInterface $em): Response
    {
        $TypeReservation = new TypeReservation();
        $form = $this->createForm(TypeReservationType::class, $TypeReservation);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $em->persist($TypeReservation);
            $em->flush();
            $this->addFlash('success', 'Nouveau type de reservation ajouter !');
            return $this->redirectToRoute('app_type');
        }
        $types = $typeReservationRepository->findAll();
        return $this->render('admin/Type/Type.html.twig',[
            'types' => $types,
            'form' => $form,
            'user' => $this->getUser()
        ]);
    }

    #[Route('/delete/{id}',name: '_delete')]
    public function delete(TypeReservation $type,EntityManagerInterface $em)
    {
        $em->remove($type);
        $em->flush();
        $this->addFlash('success', 'Type de reservation Supprimer !');
        return $this->redirectToRoute('app_type');
    }

    #[Route('/edit/{id}',name:'_edit')]
    public function update(TypeReservation $type,EntityManagerInterface $em,Request $request)
    {
        if($request->isMethod('POST')){
            $type->setType($request->request->get('type'));

            $em->persist($type);
            $em->flush();
            $this->addFlash('success', 'Type de reservation modifier !');
            return $this->redirectToRoute('app_type');
        }
        
    }
}
