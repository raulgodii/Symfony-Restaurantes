<?php

namespace App\Controller;

use App\Entity\PedidoProducto;
use App\Entity\Producto;
use App\Form\ProductoType;
use App\Repository\ProductoRepository;
use Doctrine\ORM\EntityManagerInterface;
use Repositories\PedidoRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\Filesystem\Filesystem;
use App\Entity\PedidoRestaurante;


#[Route('/producto')]
class ProductoController extends AbstractController
{
    #[Route('/', name: 'app_producto_index', methods: ['GET'])]
    public function index(ProductoRepository $productoRepository): Response
    {
        $productos = $productoRepository->findAll();
    
        $productosConStock = [];
        foreach ($productos as $producto) {
            if ($producto->getStock() >= 1) {
                $productosConStock[] = $producto;
            }
        }
        
        return $this->render('producto/index.html', [
            'productos' => $productosConStock,
        ]);
    }

    #[Route('/gestionar', name: 'app_producto_manage', methods: ['GET'])]
    public function gestionar(ProductoRepository $productoRepository): Response
    {
        return $this->render('producto/manage.html', [
            'productos' => $productoRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_producto_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $producto = new Producto();
        $form = $this->createForm(ProductoType::class, $producto);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Subir archivo de imagen
            $imagenArchivo = $form->get('Imagen')->getData();

            if ($imagenArchivo) {
                $nombreArchivo = uniqid() . '.' . $imagenArchivo->guessExtension();

                try {
                    $imagenArchivo->move(
                        $this->getParameter('kernel.project_dir') . '/public/images',
                        $nombreArchivo
                    );
                } catch (FileException $e) {
                    // Manejar la excepción si hay un problema al mover el archivo
                }

                // Actualizar el nombre de la imagen en el producto
                $producto->setImagen($nombreArchivo);
            }

            $entityManager->persist($producto);
            $entityManager->flush();

            return $this->redirectToRoute('app_producto_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('producto/new.html', [
            'producto' => $producto,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'app_producto_show', methods: ['GET'])]
    public function show(Producto $producto): Response
    {
        return $this->render('producto/show.html', [
            'producto' => $producto,
        ]);
    }

    #[Route('/edit/{id}', name: 'app_producto_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Producto $producto, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ProductoType::class, $producto);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Subir archivo de imagen
            $imagenArchivo = $form->get('Imagen')->getData();

            if ($imagenArchivo) {
                $nombreArchivo = uniqid() . '.' . $imagenArchivo->guessExtension();

                try {
                    $imagenArchivo->move(
                        $this->getParameter('kernel.project_dir') . '/public/images',
                        $nombreArchivo
                    );
                } catch (FileException $e) {
                    // Manejar la excepción si hay un problema al mover el archivo
                }

                // Actualizar el nombre de la imagen en el producto
                $producto->setImagen($nombreArchivo);
            }

            $entityManager->flush();

            return $this->redirectToRoute('app_producto_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('producto/edit.html', [
            'producto' => $producto,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/delete/{id}', name: 'app_producto_delete', methods: ['POST'])]
    public function delete(Request $request, Producto $producto, EntityManagerInterface $entityManager, Filesystem $filesystem): Response
    {
        if ($this->isCsrfTokenValid('delete' . $producto->getId(), $request->request->get('_token'))) {

            // Verificar si el producto tiene pedidos asociados
            $pedidos = $entityManager->getRepository(PedidoProducto::class)->findBy(['Producto' => $producto->getId()]);
            if (count($pedidos) > 0) {
                $this->addFlash('error', 'No puedes eliminar un producto que tiene pedidos asociados.');
                return $this->redirectToRoute('app_producto_manage', [], Response::HTTP_SEE_OTHER);
            }
            // Obtener el nombre del archivo de imagen asociado al producto
            $imagenProducto = $producto->getImagen();

            // Eliminar el archivo de imagen si existe
            if ($imagenProducto) {
                $rutaImagen = $this->getParameter('kernel.project_dir') . '/public/images/' . $imagenProducto;
                if ($filesystem->exists($rutaImagen)) {
                    $filesystem->remove($rutaImagen);
                }
            }



            $entityManager->remove($producto);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_producto_index', [], Response::HTTP_SEE_OTHER);
    }
}
