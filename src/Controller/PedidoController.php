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
use Symfony\Bridge\Twig\Mime\TemplatedEmail;




#[Route('/pedido')]
class PedidoController extends AbstractController
{

    #[Route('/', name: 'app_pedido_ver')]
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

    #[Route('/gestionar', name: 'app_pedido_verTodos')]
    public function verTodos(Request $request, ProductoRepository $productoRepository, EntityManagerInterface $entityManager): Response
    {
        $pedidos = $entityManager->getRepository(PedidoRestaurante::class)->findAll();
    
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
    
        return $this->render('pedido/manage.html', [
            'pedidosConProductos' => $pedidosConProductos,
        ]);
    }


    #[Route('/nuevo', name: 'app_pedido_nuevo')]
    public function nuevo(Request $request, ProductoRepository $productoRepository, EntityManagerInterface $entityManager, RestauranteRepository $restauranteRepository, MailerInterface $mailer): Response
    {
        $productosEnCarrito = $request->getSession()->get('carrito', []);
        $usuario = $this->getUser();
        if (!$usuario) {
            return $this->redirectToRoute('app_login');
        }

        if (empty($productosEnCarrito)) {
            return $this->render('carrito/index.html', [
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

        // Crear un array para almacenar los objetos PedidoProducto
        $pedidosProducto = [];

        // Inicializar el total del pedido
        $totalPedido = 0;

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

            // Agregar el pedido a la lista de pedidosProducto
            $pedidosProducto[] = $pedido;

            // Calcular el total del producto y agregarlo al total del pedido
            $totalProducto = $producto->getPrecio() * $cantidad;
            $totalPedido += $totalProducto;

        }
        
        $entityManager->flush();
        $fechaPedido = $pedidoRestaurante->getFecha();

        // Obtén el nombre del restaurante directamente de la entidad Restaurante
        $restauranteNombre = $restaurante->getNombre();

        $email = (new TemplatedEmail())
        ->from(new Address('mailer@mailer.com', 'Tienda Restaurantes'))
        ->addto($usuario->getEmail())
        ->addto('plopezlozano12@gmail.com') // ESTE SERÍA EL EMAIL DEL DEPARTAMENTO DE PEDIDOS
        ->subject('Confirmación de pedido')
        ->htmlTemplate('confirmarpedido/confirmation_pedido.html.twig')
        ->context([
            'pedido' => $pedido,
            'pedidosProducto' => $pedidosProducto, 
            'restauranteNombre' => $restauranteNombre, 
            'totalPedido' => $totalPedido, 
            'fechaPedido' => $fechaPedido, 

        ]);

        $mailer->send($email);

        $request->getSession()->set('carrito', []);

        return $this->redirectToRoute('app_pedido_ver');
    }


    #[Route('/eliminar/{id}', name: 'app_pedido_eliminar')]
    public function eliminar(int $id, EntityManagerInterface $entityManager): Response
    {
        $pedido = $entityManager->getRepository(PedidoRestaurante::class)->find($id);
    
        if (!$pedido) {
            throw $this->createNotFoundException('No se pudo encontrar el pedido');
        }
    
        $entityManager->remove($pedido);
        $entityManager->flush();
    
        return $this->redirectToRoute('app_pedido_verTodos');
    }

    #[Route('/enviar/{id}', name: 'app_pedido_enviar')]
    public function enviar(int $id, EntityManagerInterface $entityManager): Response
    {
        $pedido = $entityManager->getRepository(PedidoRestaurante::class)->find($id);
    
        if (!$pedido) {
            throw $this->createNotFoundException('No se pudo encontrar el pedido');
        }
    
        $pedido->setEnviado(true);
        $entityManager->flush();
    
        return $this->redirectToRoute('app_pedido_verTodos');
    }
    

}
