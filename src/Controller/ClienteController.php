<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Cliente;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Component\Form\Extension\Core\Type\TelType;

class ClienteController extends AbstractController
{
    #[IsGranted('ROLE_USER', message: 'No tienes permisos para acceder')]
    #[Route('/clientes', name: 'clientes')]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $clientes = $entityManager->getRepository(Cliente::class)->findAll();
        return $this->render('cliente/index.html.twig', [
            'clientes' => $clientes,
        ]);
    }

    #[IsGranted('ROLE_USER', message: 'No tienes permisos para acceder')]
    #[Route('/cliente/add', name: 'addCliente')]
    public function addCliente(EntityManagerInterface $entityManager, Request $request): Response
    {
        
        $cliente =new Cliente();
        $formularioCliente = $this->createFormBuilder($cliente)
           ->add('nombre',TextType::class, [
                'required' => true,
           ])
           ->add('apellidos',TextareaType::class, [
                'required' => false,
           ])
           ->add('telefono',TelType::class, [
                'required' => true,
           ])
           ->add('direccion',TextareaType::class, [
                'required' => false,
           ])
           ->getForm();


        $formularioCliente->handleRequest($request);
        if ($formularioCliente->isSubmitted() && $formularioCliente->isValid()) {
            
            $cliente = $formularioCliente->getData();
   
            $entityManager->persist($cliente);
            $entityManager->flush();

            // Flash message
            $this->addFlash('success', 'Cliente ' . $cliente->getNombre() . ' creado con éxito');
   
            return $this->redirectToRoute('clientes');
           }


        return $this->render('cliente/addCliente.html.twig', ['formularioCliente'=>$formularioCliente]);        
    }

    #[IsGranted('ROLE_USER', message: 'No tienes permisos para acceder')]
    #[Route('/cliente/delete/{id}', name: 'deleteCliente')]
    public function deleteCliente(Cliente $cliente, EntityManagerInterface $entityManager): Response
    {
        $entityManager->remove($cliente);
        $entityManager->flush();

        $this->addFlash('success', 'Cliente ' . $cliente->getNombre() . ' eliminado con éxito');


        return $this->redirectToRoute('clientes');
    }
 
}
