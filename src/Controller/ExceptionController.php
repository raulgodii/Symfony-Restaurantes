<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ExceptionController extends AbstractController
{

    #[Route('/error404', name: 'error404')]
    public function show404(): Response
    {
        return $this->render('error/error404.html');

    }
}