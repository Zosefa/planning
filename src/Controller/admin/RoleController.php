<?php
namespace App\Controller\admin;

use App\Entity\Role;
use App\Form\RoleType;
use App\Repository\RoleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted('ROLE_ADMIN')]
#[Route('Admin/role',name: 'app_role')]
class RoleController extends AbstractController{

    #[Route('',name: '')]
    public function find(RoleRepository $RoleRepository, Request $request, EntityManagerInterface $em): Response
    {
        $Role = new Role();
        $form = $this->createForm(RoleType::class, $Role);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $em->persist($Role);
            $em->flush();
            $this->addFlash('success', 'Nouveau role ajouter !');
            return $this->redirectToRoute('app_role');
        }
        $roles = $RoleRepository->findAll();
        return $this->render('admin/Role/Role.html.twig',[
            'roles' => $roles,
            'form' => $form,
            'user' => $this->getUser()
        ]);
    }

    #[Route('/delete/{id}',name: '_delete')]
    public function delete(Role $role,EntityManagerInterface $em)
    {
        $em->remove($role);
        $em->flush();
        $this->addFlash('success', 'Role Supprimer !');
        return $this->redirectToRoute('app_role');
    }

    #[Route('/edit/{id}',name:'_edit')]
    public function update(Role $role,EntityManagerInterface $em,Request $request)
    {
        if($request->isMethod('POST')){
            $role->setRole($request->request->get('role'));

            $em->persist($role);
            $em->flush();
            $this->addFlash('success', 'Role modifier !');
            return $this->redirectToRoute('app_role');
        }
        
    }
}
