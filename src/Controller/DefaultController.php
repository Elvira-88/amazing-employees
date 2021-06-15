<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

// AbstractController es un controlador de symfony que pone
// a disposición nuestra multitud de características
class DefaultController extends AbstractController
{
    const PEOPLE = [
        ['name' => 'Carlos', 'email' => 'carlos@correo.com', 'age' => 30, 'city' => 'Benalmádena'],
        ['name' => 'Carmen', 'email' => 'carmen@correo.com', 'age' => 25, 'city' => 'Fuengirola'],
        ['name' => 'Carmelo', 'email' => 'carmelo@correo.com', 'age' => 35, 'city' => 'Torremolinos'],
        ['name' => 'Carolina', 'email' => 'carolina@correo.com', 'age' => 38, 'city' => 'Málaga'],        
    ];
    
    /**
     * @Route("/default", name="default_index")
     * 
     * La clase ruta debe estar precedida en los comentario por una arroba.
     * El primer parámetro de Route es la URL a la que queremos asociar la acción.
     * El segundo parámetro de Route es el nombre que queremos dar a la ruta.
     */

    public function index(Request $request): Response
    {
     
        // Una acción siempre debe devolver una respesta.
        // Por defecto deberá ser un objeto de la clase,
        // Symfony\Component\HttpFoundation\Response

        // render() es un método heredado de AbstractController
        // que devuelve el contenido declarado en una plantilla de Twig.
        
        // symfony console es un comando equivalente a php bin/console

        $name = 'Elvi';
        
        return $this->render('default/index.html.twig', [
            'people' => self::PEOPLE
        ]);
    }

    /**
     * @Route("/hola", name="default_hola")
     */

    public function hola() : Response {
        return new Response('<html><body>hola</body></html>');
    }

    /**
     * @Route(
     *      "/default.{_format}", 
     *      name="default_index_json",
     *      requirements = {
     *          "_format": "json"
     *      }
     * )
     * 
     *  El comando:
     *  symfony console router:match /default.json
     *  buscará la acción coincidente con la ruta indicada
     *  y mostrará la información asociada.
     */

    public function indexJson(): JsonResponse {
        return $this->json(self::PEOPLE);
    }

    /**
     * @Route(
     *     "/default/{id}",
     *     name="default_show",
     *     requirements = {
     *          "id": "[0-3]"
     *     }
     * )
     */
    public function show(int $id): Response {
        return $this->render('default/show.html.twig', [
            'id' => $id,
            'person' => self::PEOPLE[$id]
        ]);
    }


    // EJERCICIO
    // Crear el recurso para obtener una representación de
    // "UN" empleado en formato JSON.

        /**
     * @Route(
     *     "/default/{id}",
     *     name="default_show_json",
     *     requirements = {
     *     "id": "[0-3]",
     *          "_format": "json"
     *     }
     * )
     */

    public function showJson(int $id): JsonResponse {
        $person = self::PEOPLE[$id];
        return new JsonResponse($person);
    }
    

    /**
     * @Route("/redirect-to-home", name="default_redirect_to_home")
     */
    public function redirectToHome(): Response {
        // Redirigir a la URL
        // return $this->redirect('/');

        // Redirigir a una ruta utilizando su nombre
        // return $this->redirectToRoute('default_show', ['id' => 1]);

        // Devolver directamente un objeto RedirectResponse

        return new RedirectResponse('/', Response:: HTTP_TEMPORARY_REDIRECT);        
    }

}