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
    public function nuevo(Request $request, ProductoRepository $productoRepository, EntityManagerInterface $entityManager, RestauranteRepository $restauranteRepository): Response
    {
        $productosEnCarrito = $request->getSession()->get('carrito', []);

        if (empty($productosEnCarrito)) {
            return $this->render('carrito/index.html.twig', [
                'error' => 'No puedes completar un pedido sin productos en el carrito.',
                'productos' => []
            ]);
        }
    
        // Obtener o crear un PedidoRestaurante
        $restaurante = $restauranteRepository->findOneBy([]); // Esto es un ejemplo, debes obtener el restaurante adecuado según tu lógica de negocio
        
        if (!$restaurante) {
            throw $this->createNotFoundException('No se pudo encontrar un restaurante válido.');
        }
    
        // Crear un nuevo PedidoRestaurante
        $pedidoRestaurante = new PedidoRestaurante();
        $pedidoRestaurante->setFecha(new \DateTime());
        $pedidoRestaurante->setEnviado(false);
        $pedidoRestaurante->setRestaurante($restaurante);
    
        $entityManager->persist($pedidoRestaurante);
    
        foreach ($productosEnCarrito as $productoId => $cantidad) {
            $producto = $productoRepository->find($productoId);
    
            if (!$producto) {
                throw $this->createNotFoundException('El producto no existe');
            }
    
            $pedido = new PedidoProducto();
            $pedido->setPedido($pedidoRestaurante); // Asociar el PedidoProducto con el PedidoRestaurante
            $pedido->setProducto($producto);
            $pedido->setUnidades($cantidad);
    
            $entityManager->persist($pedido);
        }
    
        $entityManager->flush();
    
        // Limpia el carrito después de crear el pedido
        $request->getSession()->set('carrito', []);
    
        return $this->redirectToRoute('app_pedido_ver');
    }


    #[Route('/pedido/ver', name: 'app_pedido_ver')]
    public function misPedidos(Request $request, ProductoRepository $productoRepository, EntityManagerInterface $entityManager): Response
    {
        $usuario = $this->getUser();
        $pedidos = $usuario->getPedidos();
        
        $pedidosConProductos = [];
        foreach ($pedidos as $pedido) {
            $pedidoArray = [];
            $pedidoArray['pedido'] = $pedido; // Detalles del pedido
    
            $pedidoProductos = $pedido->getPedido();
            $productosEnPedido = [];
            foreach ($pedidoProductos as $pedidoProducto) {
                $producto = $pedidoProducto->getProducto();
                // Obtener detalles del producto
                $productoArray = [
                    'nombre' => $producto->getNombre(),
                    'precio' => $producto->getPrecio(), // Suponiendo que tengas un método getPrecio en tu entidad Producto
                    // Puedes agregar más detalles aquí según sea necesario
                ];
                $productosEnPedido[] = $productoArray;
            }
    
            $pedidoArray['productos'] = $productosEnPedido;
            $pedidosConProductos[] = $pedidoArray;
        }
    
        return $this->render('pedido/index.html.twig', [
            'pedidosConProductos' => $pedidosConProductos,
        ]);
    }
}
