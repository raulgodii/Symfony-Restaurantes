<?php

namespace App\Controller;

use App\Entity\Producto;
use App\Form\ProductoType;
use App\Repository\ProductoRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\Filesystem\Filesystem;

#[Route('/producto')]
class ProductoController extends AbstractController
{
    #[Route('/', name: 'app_producto_index', methods: ['GET'])]
    public function index(ProductoRepository $productoRepository): Response
    {
        return $this->render('producto/index.html.twig', [
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

        return $this->render('producto/new.html.twig', [
            'producto' => $producto,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/todos', name: 'app_producto_todos', methods: ['GET'])]
    public function todos(ProductoRepository $productoRepository): Response
    {
        return $this->render('producto/todos.html.twig', [
            'productos' => $productoRepository->findAll(),
        ]);
    }

    #[Route('/{id}', name: 'app_producto_show', methods: ['GET'])]
    public function show(Producto $producto): Response
    {
        return $this->render('producto/show.html.twig', [
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

        return $this->render('producto/edit.html.twig', [
            'producto' => $producto,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/delete/{id}', name: 'app_producto_delete', methods: ['POST'])]
    public function delete(Request $request, Producto $producto, EntityManagerInterface $entityManager, Filesystem $filesystem): Response
    {
        if ($this->isCsrfTokenValid('delete' . $producto->getId(), $request->request->get('_token'))) {
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
