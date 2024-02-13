<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Producto;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;


class CarritoController extends AbstractController
{
    #[Route('/carrito', name: 'app_carrito')]
    public function index(Request $request, EntityManagerInterface $entityManager): Response
    {
        // Obtén el carrito de la sesión
        $carrito = $request->getSession()->get('carrito', []);
        // var_dump($carrito);
        // die ();
        // Obtén los productos del carrito desde la base de datos
        $productos = [];
        if ($carrito) {
            $repository = $entityManager->getRepository(Producto::class);
            foreach ($carrito as $id => $cantidad) {
                $producto = $repository->find($id);
                if ($producto) {
                    $productos[] = ['producto' => $producto, 'cantidad' => $cantidad];
                }
            }
        }
    
        return $this->render('carrito/index.html.twig', [
            'productos' => $productos,
        ]);
    }

    #[Route('/carrito/agregar/{id}', name: 'app_carrito_agregar')]
    public function agregar(int $id, Request $request): Response
    {
        $session = $request->getSession();

        // Inicia la sesión si no está iniciada
        if (!$session->isStarted()) {
            $session->start();
        }
        // Obtén el carrito de la sesión
        $carrito = $session->get('carrito', []);
    
        // Si el producto ya está en el carrito, incrementa la cantidad
        if (isset($carrito[$id])) {
            $carrito[$id]++;
        } else {
            // Si el producto no está en el carrito, añádelo
            $carrito[$id] = 1;
        }
    
        // Guarda el carrito en la sesión
        $request->getSession()->set('carrito', $carrito);
    
        return $this->redirectToRoute('app_carrito');
    }

    #[Route('/carrito/eliminar/{id}', name: 'app_carrito_eliminar')]
    public function eliminar(int $id, SessionInterface $session): Response
    {
        // Obtener el carrito de la sesión
        $carrito = $session->get('carrito', []);
    
        // Verificar si el producto está en el carrito
        if (!array_key_exists($id, $carrito)) {
            // Redirigir con un mensaje de error si el producto no está en el carrito
            $this->addFlash('error', 'El producto no está en el carrito.');
        } else {
            // Eliminar el producto del carrito
            unset($carrito[$id]);
    
            // Guardar el carrito en la sesión
            $session->set('carrito', $carrito);
    
            // Redirigir con un mensaje de éxito
            $this->addFlash('success', 'Producto eliminado del carrito.');
        }
    
        return $this->redirectToRoute('app_carrito');
    }

    #[Route('/carrito/vaciar', name: 'app_carrito_vaciar')]
    public function vaciar(SessionInterface $session): Response
    {
        $session->remove('carrito');

        return $this->redirectToRoute('app_carrito');
    }

    #[Route('/carrito/aumentar/{id}', name: 'app_carrito_aumentar')]
    public function aumentar(int $id, SessionInterface $session): Response
    {
        $carrito = $session->get('carrito', []);
    
        if (!array_key_exists($id, $carrito)) {
            $this->addFlash('error', 'El producto no está en el carrito.');
        } else {
            $carrito[$id]++;
    
            $session->set('carrito', $carrito);
        }
    
        return $this->redirectToRoute('app_carrito');
    }

    #[Route('/carrito/disminuir/{id}', name: 'app_carrito_disminuir')]
    public function disminuir(int $id, SessionInterface $session): Response
    {
        $carrito = $session->get('carrito', []);
    
        if (!array_key_exists($id, $carrito)) {
            $this->addFlash('error', 'El producto no está en el carrito.');
        } else {
            if ($carrito[$id] > 1) {
                $carrito[$id]--;
            } else {
                unset($carrito[$id]);
            }
    
            $session->set('carrito', $carrito);
        }
    
        return $this->redirectToRoute('app_carrito');
    }

}
