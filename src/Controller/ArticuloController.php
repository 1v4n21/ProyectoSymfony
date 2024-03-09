<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Entity\Articulo;
use App\Entity\Categoria;
use App\Form\ArticuloType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;

class ArticuloController extends AbstractController
{
    #[Route('/articulos/{id}', name: 'verArticulo')]
    public function verArticulo(Articulo $articulo): Response
    {
        return $this->render('articulo/verArticulo.html.twig', [
            'articulo' => $articulo
        ]);
    }

    #[Route('/articulos', name: 'verTodosArticulos')]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $articulos = $entityManager->getRepository(Articulo::class)->findAll();

        return $this->render('articulo/index.html.twig', [
            'articulos' => $articulos
        ]);
    }

    #[Route('/articulos/categoria/{id}', name: 'verArticulosPorCategoria')]
    public function verArticulosPorCategoria(Categoria $categoria): Response
    {
        return $this->render('articulo/verArticulosPorCategoria.html.twig', [
            'categoria' => $categoria
        ]);
    }

    #[Route('/articulo/add/{id}', name: 'addArticulo')]
    public function addArticulo(EntityManagerInterface $entityManager, Request $request, int $id): Response
    {
        
        $articulo =new Articulo();
        
        $formularioArticulo = $this->createForm(ArticuloType::class, $articulo);

        $formularioArticulo->handleRequest($request);
        if ($formularioArticulo->isSubmitted() && $formularioArticulo->isValid()) {
            
            $articulo = $formularioArticulo->getData();
   
            $entityManager->persist($articulo);
            $entityManager->flush();
   
            return $this->redirectToRoute('verArticulosPorCategoria',['id' => $id]);
           }


        return $this->render('articulo/addArticulo.html.twig', ['formularioArticulo'=>$formularioArticulo]);

        
    }
}
