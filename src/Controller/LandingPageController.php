<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\CategoriaRepository;

use App\Entity\Categoria;

class LandingPageController extends AbstractController
{

    #[Route('/', name: 'home')]
    public function index(CategoriaRepository $categoriaRepository): Response
    {
        $categorias = $categoriaRepository->getCategorias();

        return $this->render('home.html', [
            'categorias' => $categorias,
        ]);
    }
}
