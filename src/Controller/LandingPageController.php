<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use App\Repository\ProductoRepository;

class LandingPageController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function index(ProductoRepository $productoRepository): Response
    {
        $productos = $productoRepository->findAll();
    
        $productosConStock = [];
        foreach ($productos as $producto) {
            if ($producto->getStock() >= 1) {
                $productosConStock[] = $producto;
            }
        }
        
        return $this->render('home.html', [
            'productos' => $productosConStock,
        ]);
    }
}

