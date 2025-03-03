<?php
namespace App\Controller\admin;

use App\Entity\Chauffeur;
use App\Entity\TypeChauffeur;
use App\Form\TypeChauffeurType;
use App\Repository\ChauffeurRepository;
use App\Repository\TypeChauffeurRepository;
use App\Service\ChauffeurService;
use App\Service\PersonneService;
use App\Service\TelephoneService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted('ROLE_ADMIN')]
#[Route('Admin/chauffeur', name: 'app_chauffeur')]
class ChauffeurController extends AbstractController
{

    public function __construct(
        private readonly ChauffeurService $chauffeurService, 
        private readonly PersonneService $personneService, 
        private readonly TelephoneService $telephoneService,
        private readonly RegisterController $registerController,
        private readonly TypeChauffeurRepository $typeChauffeur)
    {}

    #[Route('', name: '')]
    public function find(ChauffeurRepository $chauffeurRepository, Request $request, EntityManagerInterface $em, TypeChauffeurRepository $typeChauffeurRepository): Response
    {
        $user = $this->getUser();
        $TypeChauffeur = new TypeChauffeur();

        $form = $this->createForm(TypeChauffeurType::class, $TypeChauffeur);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $em->persist($TypeChauffeur);
            $em->flush();
            $this->addFlash('success','Type de chauffeur ajouter!');
            return $this->redirectToRoute('app_chauffeur');
        }


        if($request->isMethod('POST')){
            $nom = $request->get('nom');
            $prenom = $request->get('prenom');
            $adresse = $request->get('adresse');
            $type = $request->get('type');
            $tel1 = $request->get('tel1');
            $tel2 = $request->get('tel2');
            $tel3 = $request->get('tel3');
            if($nom != '' && $prenom != '' && $adresse != '' && $tel1 != '' && $type != '' ){
                $data = [
                    'nom' => $nom,
                    'prenom' => $prenom,
                    'adresse' => $adresse,
                    'type' => $type
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
                $this->addFlash('success', 'Chauffeur ajouter !');
                return $this->redirectToRoute('app_chauffeur');
            }
        }
        $chauffeurs = $chauffeurRepository->findAllWithTel();
        return $this->render('admin/Chauffeur/Chauffeur.html.twig',[
            'chauffeurs' => $chauffeurs,
            'user' => $user,
            'form' => $form,
            'types' => $typeChauffeurRepository->findAll()
        ]);
    }


    public function insert($data){
        $personne = $this->personneService->insert($data['nom'], $data['prenom'], $data['adresse']);
        $type = $this->typeChauffeur->find($data['type']);
        $this->chauffeurService->insert($personne, $type);
        $this->telephoneService->insert($data['telephone'], $personne);
        $this->registerController->register($personne, "CHAUFFEUR");
    }

    #[Route('/delete/{id}',name: '_delete')]
    public function delete(Chauffeur $chauffeur, EntityManagerInterface $em){
        $em->remove($chauffeur);
        $em->flush();
        $this->addFlash('success', 'Chauffeur supprimer !');
        return $this->redirectToRoute('app_chauffeur');
    }

}