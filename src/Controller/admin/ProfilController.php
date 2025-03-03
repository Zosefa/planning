<?php
namespace App\Controller\admin;

use App\DTO\ProfilDTO;
use App\Form\ProfilDtoType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\ExpressionLanguage\Expression;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted(new Expression('is_granted("ROLE_ADMIN") or is_granted("ROLE_RESPONSABLE") or is_granted("ROLE_CHAUFFEUR")'))]
#[Route('profil',name: 'app_profil')]
class ProfilController extends AbstractController
{
    #[Route('/',name: '')]
    public function profil(Request $request,EntityManagerInterface $em, UserPasswordHasherInterface $passwordHasher,UserRepository $userRepository): Response
    {
        $user = $this->getUser();
        $UserConnected = $userRepository->findByUsername($user->getUserIdentifier())[0];
        $profilDTO = new ProfilDTO();
        $profilDTO->setUsername($user->getUserIdentifier());
        $form = $this->createForm(ProfilDtoType::class,$profilDTO);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $data = $form->getData();
        
        if (!$passwordHasher->isPasswordValid($UserConnected, $data->getPassword())) {
            $this->addFlash('error', 'Mot de passe actuel incorrect.');
            return $this->redirectToRoute('app_profil');
        }
        
        if ($data->getNewPassword() !== $data->getConfirm()) {
            $this->addFlash('error', 'Les nouveaux mots de passe ne correspondent pas.');
            return $this->redirectToRoute('app_profil');
        }
        
        $UserConnected->setUsername($data->getUsername());
        
        if (!empty($data->getNewPassword())) {
            $hashedPassword = $passwordHasher->hashPassword($UserConnected, $data->getNewPassword());
            $UserConnected->setPassword($hashedPassword);
        }
        
        $em->persist($UserConnected);
        $em->flush();
        
        $this->addFlash('success', 'Profil mis à jour avec succès !');
        
        return $this->redirectToRoute('app_profil');
        }
        return $this->render('admin/Profil/Profil.html.twig',[
            'form' => $form,
            'user' => $user
        ]);
    }
}