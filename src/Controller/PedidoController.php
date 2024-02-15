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
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Mime\Address;




class PedidoController extends AbstractController
{

    #[Route('/pedido', name: 'app_pedido_ver')]
    public function misPedidos(Request $request, ProductoRepository $productoRepository, EntityManagerInterface $entityManager): Response
    {
        $usuario = $this->getUser();
        if (!$usuario) {
            return $this->redirectToRoute('app_login');
        }
        $pedidos = $usuario->getPedidos();
        
        $pedidosConProductos = [];
        foreach ($pedidos as $pedido) {
            $pedidoArray = [];
            $pedidoArray['pedido'] = $pedido; 
    
            $pedidoProductos = $pedido->getPedido();
            $productosEnPedido = [];
            foreach ($pedidoProductos as $pedidoProducto) {
                $producto = $pedidoProducto->getProducto();

                $productoArray = [
                    'nombre' => $producto->getNombre(),
                    'precio' => $producto->getPrecio(),
                    'unidades' => $pedidoProducto->getUnidades(),
                ];
                $productosEnPedido[] = $productoArray;
            }
    
            $pedidoArray['productos'] = $productosEnPedido;
            $pedidosConProductos[] = $pedidoArray;
        }
    
        return $this->render('pedido/index.html', [
            'pedidosConProductos' => $pedidosConProductos,
        ]);
    }


    #[Route('/pedido/nuevo', name: 'app_pedido_nuevo')]
    public function nuevo(Request $request, ProductoRepository $productoRepository, EntityManagerInterface $entityManager, RestauranteRepository $restauranteRepository, MailerInterface $mailer): Response
    {
        $productosEnCarrito = $request->getSession()->get('carrito', []);
        $usuario = $this->getUser();
        if (!$usuario) {
            return $this->redirectToRoute('app_login');
        }

        if (empty($productosEnCarrito)) {
            return $this->render('carrito/index.html.twig', [
                'error' => 'No puedes completar un pedido sin productos en el carrito.',
                'productos' => [],
                'total' => 0,
            ]);
        }

        $restauranteID = $usuario->getId();
        $restaurante = $restauranteRepository->find($restauranteID);
        
        if (!$restaurante) {
            throw $this->createNotFoundException('No se pudo encontrar un restaurante válido.');
        }
    
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

            if ($producto->getStock() < $cantidad) {
                throw new \Exception('No hay suficiente stock para el producto: ' . $producto->getNombre());
            }
            $producto->setStock($producto->getStock() - $cantidad);
            $entityManager->persist($producto);

            $pedido = new PedidoProducto();
            $pedido->setPedido($pedidoRestaurante);
            $pedido->setProducto($producto);
            $pedido->setUnidades($cantidad);
    
            $entityManager->persist($pedido);
        }
    
        $entityManager->flush();

        $email = (new Email())
        ->from(new Address('mailer@mailer.com', 'Tienda Restaurantes'))
            ->addto($usuario->getEmail())
            ->subject('Confirmación de pedido')
            ->text('Detalles del pedido: ' . $pedido->getId());
        $mailer->send($email);

        $request->getSession()->set('carrito', []);
    
        return $this->redirectToRoute('app_pedido_ver');
    }


    #[Route('/pedido/eliminar/{id}', name: 'app_pedido_eliminar')]
    public function eliminar(int $id, EntityManagerInterface $entityManager): Response
    {
        $pedido = $entityManager->getRepository(PedidoRestaurante::class)->find($id);
    
        if (!$pedido) {
            throw $this->createNotFoundException('No se pudo encontrar el pedido');
        }
    
        $entityManager->remove($pedido);
        $entityManager->flush();
    
        return $this->redirectToRoute('app_pedido_ver');
    }

    #[Route('/pedido/enviar/{id}', name: 'app_pedido_enviar')]
    public function enviar(int $id, EntityManagerInterface $entityManager): Response
    {
        $pedido = $entityManager->getRepository(PedidoRestaurante::class)->find($id);
    
        if (!$pedido) {
            throw $this->createNotFoundException('No se pudo encontrar el pedido');
        }
    
        $pedido->setEnviado(true);
        $entityManager->flush();
    
        return $this->redirectToRoute('app_pedido_ver');
    }
    

}
