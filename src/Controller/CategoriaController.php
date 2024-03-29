<?php

namespace App\Controller;

use App\Entity\Categoria;
use App\Form\CategoriaType;
use App\Repository\CategoriaRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/categoria')]
class CategoriaController extends AbstractController
{
    #[Route('/gestionar', name: 'app_categoria_index', methods: ['GET'])]
    public function index(CategoriaRepository $categoriaRepository): Response
    {
        return $this->render('categoria/index.html', [
            'categorias' => $categoriaRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_categoria_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $categorium = new Categoria();
        $form = $this->createForm(CategoriaType::class, $categorium);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($categorium);
            $entityManager->flush();

            return $this->redirectToRoute('app_categoria_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('categoria/new.html', [
            'categorium' => $categorium,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_categoria_show', methods: ['GET'])]
    public function show(Categoria $categorium): Response
    {
        $productos = $categorium->getProductos();
        return $this->render('categoria/show.html', [
            'categorium' => $categorium,
            'productos' => $productos
        ]);
    }

    #[Route('/edit/{id}', name: 'app_categoria_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Categoria $categorium, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(CategoriaType::class, $categorium);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_categoria_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('categoria/edit.html', [
            'categorium' => $categorium,
            'form' => $form,
        ]);
    }

    #[Route('/delete/{id}', name: 'app_categoria_delete', methods: ['POST'])]
    public function delete(Request $request, Categoria $categorium, EntityManagerInterface $entityManager,CategoriaRepository $categoriaRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$categorium->getId(), $request->request->get('_token'))) {
            // Verificar si la categoría tiene productos
            if (count($categorium->getProductos()) > 0) {
                return $this->render('categoria/index.html', [
                    'error' => 'No se puede eliminar la categoría porque tiene productos asociados',
                    'categorias' => $categoriaRepository->findAll(),
                ]);
            }
    
            $entityManager->remove($categorium);
            $entityManager->flush();
        }
    
        return $this->redirectToRoute('app_categoria_index', [], Response::HTTP_SEE_OTHER);
    }
}
