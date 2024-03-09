<?php
// src/Controller/LuckyController.php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;

class LuckyController extends AbstractController
{
    #[Route('/lucky', name: "principal")]
    public function number(): Response
    {

        $number = random_int(0, 100);

        return $this->render('number.html.twig', [
            'number' => $number,
            'titulo' => "Numero Aleatorio Nuevo",
        ]);
    }


    //Redirige al controlador numero_aleatorio2 pasándo como parámetro numMax = 500
    #[Route('/redirigir')]
    public function redirigr(): Response{
        return $this->redirectToRoute("numero_aleatorio2", ['numMax'=>500]);
    }


    #[Route('/numeros/aleatorio/{numMax}', name: "numero_aleatorio2")]
    public function number2(int $numMax = 0): Response
    {
        $number = random_int(0, $numMax);

        return new Response(
            '<html><body>Lucky number: '.$number.'</body></html>'
        );
    }

    #[Route('/api/numero_aleatorio', name: "api_aleatorio", methods:['GET'])]
    public function api_aleatorio(): Response
    {
        $number = random_int(0, 500);

        return $this->json(['numero'=> $number]);
    }

    
}