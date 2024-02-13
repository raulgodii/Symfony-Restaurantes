<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use App\Entity\Restaurante;
use App\Entity\Producto;
use App\Entity\PedidoProducto;
use App\Entity\PedidoRestaurante;
use App\Repository\ProductoRepository;
use App\Repository\RestauranteRepository;
use Doctrine\ORM\EntityManagerInterface;



class PedidoController extends AbstractController
{
    #[Route('/pedido', name: 'app_pedido')]
    public function index(): Response
    {
        return $this->render('pedido/index.html.twig', [
            'controller_name' => 'PedidoController',
        ]);
    }

    #[Route('/pedido/nuevo', name: 'app_pedido_nuevo')]
    public function nuevo(Request $request, ProductoRepository $productoRepository, EntityManagerInterface $entityManager): Response
    {
        $productosEnCarrito = $request->getSession()->get('carrito', []);

        foreach ($productosEnCarrito as $productoId => $cantidad) {
            $producto = $productoRepository->find($productoId);
    
            if (!$producto) {
                throw $this->createNotFoundException('El producto no existe');
            }
    
            $pedido = new PedidoProducto();
            $pedido->setProducto($producto);
            $pedido->setUnidades($cantidad);

            $entityManager->persist($pedido);
        }
    
        $entityManager->flush();
    

        return $this->render('pedido/index.html.twig', [
            'pedido' => $pedidoRestaurante,
        ]);
    }
}
