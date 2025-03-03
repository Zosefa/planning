<?php
namespace App\Controller\admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted('ROLE_ADMIN')]
#[Route('Admin',name:'app_admin')]
class DashboardController extends AbstractController
{
    #[Route('/', name:'')]
    public function dashboard():Response
    {
        $user = $this->getUser();
        return $this->render('admin/Dashboard/Dashboard.html.twig',[
            'user' => $user
        ]);
    }
}