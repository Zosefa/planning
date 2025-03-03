<?php
namespace App\Controller\admin;

use App\Entity\Responsable;
use App\Repository\PersonneRepository;
use App\Repository\ResponsableRepository;
use App\Repository\RoleRepository;
use App\Repository\UserRepository;
use App\Service\PersonneService;
use App\Service\ResponsableService;
use App\Service\TelephoneService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted('ROLE_ADMIN')]
#[Route('Admin/responsable',name: 'app_responsable')]
class ResponsableController extends AbstractController{

    public function __construct(
        private readonly ResponsableService $responsableService, 
        private readonly PersonneService $personneService, 
        private readonly TelephoneService $telephoneService,
        private readonly RegisterController $registerController)
    {}

    #[Route('', name: '')]
    public function find(ResponsableRepository $responsableRepository, Request $request,RoleRepository $roleRepository): Response
    {
        if($request->isMethod('POST')){
            $nom = $request->get('nom');
            $prenom = $request->get('prenom');
            $adresse = $request->get('adresse');
            $tel1 = $request->get('tel1');
            $tel2 = $request->get('tel2');
            $tel3 = $request->get('tel3');
            $role = $request->get('role');
            if($nom != '' && $prenom != '' && $adresse != '' && $tel1 != '' && $role){
                $data = [
                    'nom' => $nom,
                    'prenom' => $prenom,
                    'adresse' => $adresse,
                    'role' => $role
                ];
                $dataTel = [
                    'telephone1' => $tel1
                ];
                if($tel2 != ''){
                    $dataTel += [
                        'telephone2' => $tel2
                    ];
                }
                if($tel3 != ''){
                    $dataTel += [
                        'telephone3' => $tel3
                    ];
                }
                
                $data += [
                    'telephone' => $dataTel
                ];
                $this->insert($data);
                $this->addFlash('success', 'Responsable ajouter avec son utilisateur !');
                return $this->redirectToRoute('app_responsable');
            }
        }
        $responsables = $responsableRepository->findAllWithTel();
        $roles = $roleRepository->findWithoutChauffeur();
        return $this->render('admin/Responsable/Responsable.html.twig',[
            'responsables' => $responsables,
            'roles' => $roles,
            'user' => $this->getUser()
        ]);
    }

    public function insert($data){
        $personne = $this->personneService->insert($data['nom'], $data['prenom'], $data['adresse']);
        $this->responsableService->insert($personne);
        $this->telephoneService->insert($data['telephone'], $personne);
        $this->registerController->register($personne, $data['role']);
    }

    #[Route('/delete/{id}',name: '_delete')]
    public function delete(Responsable $responsable,EntityManagerInterface $em,UserRepository $userRepository)
    {
        $personne = $responsable->getIdPersonne();
        $user = $userRepository->findByPersonne($personne)[0];

        $em->remove($responsable);
        $em->flush();

        $em->remove($personne);
        $em->flush();

        $em->remove($user);
        $em->flush();
        $this->addFlash('success', 'Reponsable supprimer Supprimer !');
        return $this->redirectToRoute('app_responsable');
    }
}