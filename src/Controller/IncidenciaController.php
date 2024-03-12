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
use Symfony\Component\Security\Http\Attribute\IsGranted;

class IncidenciaController extends AbstractController
{
    #[IsGranted('ROLE_USER', message: 'No tienes permisos para acceder')]
    #[Route('/incidencias/{id}', name: 'verIncidencia')]
    public function verIncidencia(Incidencia $incidencia): Response
    {
        return $this->render('incidencia/verIncidencia.html.twig', [
            'incidencia' => $incidencia
        ]);
    }

    #[IsGranted('ROLE_USER', message: 'No tienes permisos para acceder')]
    #[Route('/incidencia/delete/{id}', name: 'deleteIncidencia')]
    public function deleteIncidencia(Request $request, Incidencia $incidencia, EntityManagerInterface $entityManager): Response
    {
        $entityManager->remove($incidencia);
        $entityManager->flush();

        $this->addFlash('success', 'Incidencia para ' . $incidencia->getCliente()->getNombre() . ' eliminada con éxito');


        return $this->redirect($request->headers->get('referer'));
    }

    #[IsGranted('ROLE_USER', message: 'No tienes permisos para acceder')]
    #[Route('/incidencias', name: 'verTodosIncidencias')]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $repository = $entityManager->getRepository(Incidencia::class);

        // Utiliza QueryBuilder para ordenar por fecha en orden inverso
        $incidencias = $repository->createQueryBuilder('i')
            ->orderBy('i.fechaCreacion', 'DESC')
            ->getQuery()
            ->getResult();

        return $this->render('incidencia/index.html.twig', [
            'incidencias' => $incidencias
        ]);
    }

    #[IsGranted('ROLE_USER', message: 'No tienes permisos para acceder')]
    #[Route('/incidencias/cliente/{id}', name: 'verIncidenciasPorCliente')]
    public function verIncidenciasPorCliente(Cliente $cliente): Response
    {
        return $this->render('incidencia/verIncidenciasPorCliente.html.twig', [
            'cliente' => $cliente
        ]);
    }

    #[IsGranted('ROLE_USER', message: 'No tienes permisos para acceder')]
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

            $this->addFlash('success', 'Incidencia para ' . $incidencia->getCliente()->getNombre() . ' creada con éxito');

   
            return $this->redirectToRoute('verIncidenciasPorCliente',['id' => $id]);
           }


        return $this->render('incidencia/addIncidencia.html.twig', ['formularioIncidencia'=>$formularioIncidencia]);
    }

    #[IsGranted('ROLE_USER', message: 'No tienes permisos para acceder')]
    #[Route('/incidencia/edit/{id}', name: 'editIncidencia')]
    public function editIncidencia(EntityManagerInterface $entityManager, Request $request, int $id): Response
    {
        $incidencia = $entityManager->getRepository(Incidencia::class)->find($id);

        if (!$incidencia) {
            throw $this->createNotFoundException('No se encontró la incidencia con el id ' . $id);
        }

        $formularioIncidencia = $this->createForm(IncidenciaType::class, $incidencia);

        $formularioIncidencia->handleRequest($request);

        if ($formularioIncidencia->isSubmitted() && $formularioIncidencia->isValid()) {
            // Puedes agregar lógica adicional si es necesario

            $entityManager->flush();

            $this->addFlash('success', 'Incidencia para ' . $incidencia->getCliente()->getNombre() . ' editada con éxito');


            return $this->redirectToRoute('verIncidenciasPorCliente', ['id' => $incidencia->getCliente()->getId()]);
        }

        return $this->render('incidencia/addIncidencia.html.twig', [
            'formularioIncidencia' => $formularioIncidencia->createView(),
        ]);
    }
}
