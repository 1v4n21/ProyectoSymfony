<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Categoria;
use App\Entity\Articulo;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Http\Attribute\IsGranted;


class CategoriaController extends AbstractController
{
    #[Route('/', name: 'categorias')]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $categorias = $entityManager->getRepository(Categoria::class)->findAll();
        return $this->render('categoria/index.html.twig', [
            'categorias' => $categorias,
        ]);
    }

    #[IsGranted('ROLE_USER', message: 'You are not allowed to access the admin dashboard.')]
    #[Route('/categoria/add', name: 'addCategoria')]
    public function addCategoria(EntityManagerInterface $entityManager, Request $request): Response
    {
        
        $categoria =new Categoria();
        $formularioCategoria = $this->createFormBuilder($categoria)
           ->add('nombre',TextType::class)
           ->add('descripcion',TextareaType::class)
           ->add('Insertar',SubmitType::class, ['label'=>'Insertar'])
           ->getForm();


        $formularioCategoria->handleRequest($request);
        if ($formularioCategoria->isSubmitted() && $formularioCategoria->isValid()) {
            
            $categoria = $formularioCategoria->getData();
   
            $entityManager->persist($categoria);
            $entityManager->flush();
   
            return $this->redirectToRoute('categorias');
           }


        return $this->render('categoria/addCategoria.html.twig', ['formularioCategoria'=>$formularioCategoria]);

        
    }

    #[Route('/categoria/delete/{id}', name: 'deleteCategoria')]
    public function deleteCategoria(Categoria $categoria, EntityManagerInterface $entityManager): Response
    {
        $entityManager->remove($categoria);
        $entityManager->flush();

        return $this->redirectToRoute('categorias');
        
    }
 
}
