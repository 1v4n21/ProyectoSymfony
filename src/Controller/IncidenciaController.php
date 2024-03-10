<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Entity\Incidencia;
use App\Entity\Cliente;
use App\Form\IncidenciaType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;

class IncidenciaController extends AbstractController
{
    #[Route('/incidencias/{id}', name: 'verIncidencia')]
    public function verIncidencia(Incidencia $incidencia): Response
    {
        return $this->render('incidencia/verIncidencia.html.twig', [
            'incidencia' => $incidencia
        ]);
    }

    #[Route('/incidencias', name: 'verTodosIncidencias')]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $incidencias = $entityManager->getRepository(Incidencia::class)->findAll();

        return $this->render('incidencia/index.html.twig', [
            'incidencias' => $incidencias
        ]);
    }

    #[Route('/incidencias/cliente/{id}', name: 'verIncidenciasPorCliente')]
    public function verIncidenciasPorCategoria(Cliente $cliente): Response
    {
        return $this->render('incidencia/verIncidenciasPorCliente.html.twig', [
            'cliente' => $cliente
        ]);
    }

    #[Route('/incidencia/add/{id}', name: 'addIncidencia')]
    public function addIncidencia(EntityManagerInterface $entityManager, Request $request, int $id): Response
    {
        
        $incidencia =new Incidencia();
        
        $formularioIncidencia = $this->createForm(IncidenciaType::class, $incidencia);

        $formularioIncidencia->handleRequest($request);
        if ($formularioIncidencia->isSubmitted() && $formularioIncidencia->isValid()) {
            
            $incidencia = $formularioIncidencia->getData();

            $usuarioActual = $this->getUser();

            $incidencia->setUsuario($usuarioActual);
   
            $entityManager->persist($incidencia);
            $entityManager->flush();
   
            return $this->redirectToRoute('verIncidenciasPorCliente',['id' => $id]);
           }


        return $this->render('incidencia/addIncidencia.html.twig', ['formularioIncidencia'=>$formularioIncidencia]);

        
    }
}
