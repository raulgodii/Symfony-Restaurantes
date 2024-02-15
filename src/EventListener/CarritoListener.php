<?php

namespace App\EventListener;

use App\Repository\ProductoRepository;
use Symfony\Component\HttpKernel\Event\ControllerEvent;

class CarritoListener
{
    private $productoRepository;

    public function __construct(ProductoRepository $productoRepository)
    {
        $this->productoRepository = $productoRepository;
    }

    public function onKernelController(ControllerEvent $event)
    {
        $request = $event->getRequest();
        $carrito = $request->getSession()->get('carrito', []);
        $total = 0;

        $productos = [];
        if ($carrito) {
            foreach ($carrito as $id => $cantidad) {
                $producto = $this->productoRepository->find($id);
                if ($producto) {
                    $productos[] = ['producto' => $producto, 'cantidad' => $cantidad];
                    $total += $producto->getPrecio() * $cantidad;
                }
            }
        }

        $request->attributes->set('productos_carrito', $productos);
        $request->attributes->set('total_carrito', $total);
    }
}
