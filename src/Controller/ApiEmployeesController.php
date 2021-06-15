<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api/amazing-employees", name="api_employees_")
 */
class ApiEmployeesController extends AbstractController
{
    /**
     * @Route(
     *      "",
     *      name="cget",
     *      methods={"GET"}
     * )
     */
    public function index(): Response
    {
        return $this->json([
            'method' => 'CGET',
            'description' => 'Devuelve el listado del recurso empleados.',
        ]);
    }

    /**
     * @Route(
     *      "/{id}",
     *      name="get",
     *      methods={"GET"},
     *      requirements={
     *          "id": "\d+"
     *      }
     * )
     */
    public function show(int $id): Response
    {
        return $this->json([
            'method' => 'GET',
            'description' => 'Devuelve un solo recurso empleado con id: '.$id.'.',
        ]);
    }

    /**
     * @Route(
     *      "",
     *      name="post",
     *      methods={"POST"}
     * )
     */
    public function add(): Response {
        return  $this->json([
            'method' => 'POST',
            'description' => 'Crea un recurso empleado.',

        ]);
    }

    /**
     * @Route(
     *      "/{id}",
     *      name="put",
     *      methods={"PUT"},
     *      requirements={
     *          "id": "\d+"
     *      }
     * )
     */
    public function update(int $id): Response
    {
        return $this->json([
            'method' => 'PUT',
            'description' => 'Actualiza un recurso empleado con id: '.$id.'.',
        ]);
    }

    /**
     * @Route(
     *      "/{id}",
     *      name="delete",
     *      methods={"DELETE"},
     *      requirements={
     *          "id": "\d+"
     *      }
     * )
     */
    public function remove(int $id): Response
    {
        return $this->json([
            'method' => 'DELETE',
            'description' => 'Elimina un recurso empleado con id: '.$id.'.',
        ]);
    }
}

