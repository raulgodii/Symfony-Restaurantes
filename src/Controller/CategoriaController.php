<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\CategoriaRepository;
use App\Form\CategoriaCrearType;
use App\Entity\Categoria;

class CategoriaController extends AbstractController
{
    private $categoriaRepository;

    public function __construct(CategoriaRepository $categoriaRepository)
    {
        $this->categoriaRepository = $categoriaRepository;
    }


    #[Route('/categoria', name: 'app_categoria')]
    public function index(): JsonResponse
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/CategoriaController.php',
        ]);
    }

    #[Route('/categorias', name: 'app_categorias')]
    public function getCategorias(): Response
    {
        $categorias = $this->categoriaRepository->getCategorias();

        return $this->render('categorias/index.html.twig', [
            'categorias' => $categorias,
        ]);
    }

    #[Route('/categoria/add', name: 'app_add_categoria')]
    public function addCategoria(Request $request, EntityManagerInterface $em,): Response
    {
        $categoria = new Categoria();
        $form = $this->createForm(CategoriaCrearType::class, $categoria);
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($categoria);
            $em->flush();
    
            return $this->redirectToRoute('app_categorias');
        }
    
        return $this->render('categorias/crear.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/categoria/edit/{id}', name: 'app_edit_categoria')]
    public function editCategoria(Request $request, EntityManagerInterface $em, int $id): Response
    {
        $categoria = $this->categoriaRepository->find($id);
        $form = $this->createForm(CategoriaCrearType::class, $categoria);
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();
    
            return $this->redirectToRoute('app_categorias');
        }
    
        return $this->render('categorias/edit.html.twig', [
            'categoria' => $categoria,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/categoria/delete/{id}', name: 'app_delete_categoria')]
    public function deleteCategoria(int $id): Response
    {
        $this->categoriaRepository->deleteCategoria($id);

        return $this->redirectToRoute('app_categorias');
    }


}
