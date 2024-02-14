<?php

namespace App\EventListener;

use App\Repository\CategoriaRepository;
use Symfony\Component\HttpKernel\Event\ControllerEvent;

class CategoriasListener
{
    private $categoriaRepository;

    public function __construct(CategoriaRepository $categoriaRepository)
    {
        $this->categoriaRepository = $categoriaRepository;
    }

    public function onKernelController(ControllerEvent $event)
    {
        // Obtener las categorías y pasarlas al Request
        $categorias = $this->categoriaRepository->getCategorias();
        $event->getRequest()->attributes->set('categorias', $categorias);
    }
}
