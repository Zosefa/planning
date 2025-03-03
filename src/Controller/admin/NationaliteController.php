<?php
namespace App\Controller\admin;

use App\Repository\NationaliteRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

    #[IsGranted('ROLE_ADMIN')]
    #[Route('Admin', name: 'app_nationalite')]
    class NationaliteController extends AbstractController{
        
        #[Route('/nationalite', name: '_find', methods: ['GET'])]
        public function find(NationaliteRepository $nationaliteRepository):Response
        {
            $nationalites = $nationaliteRepository->findAll();
            return $this->render('admin/Nationalite/nationalite.html.twig',[
                'nationalites' => $nationalites,
                'user' => $this->getUser()
            ]);
        }

    }