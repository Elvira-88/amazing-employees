<?php

namespace App\Controller;

use App\Entity\Employee;
use App\Repository\DepartmentRepository;
use App\Repository\EmployeeRepository;
use App\Service\EmployeeNormalize;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

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
    public function index(Request $request, EmployeeRepository $employeeRepository, EmployeeNormalize $employeeNormalize): Response
    {
        if($request->query->has('term')) {
            $result = $employeeRepository->findByTerm($request->query->get('term'));

            $data = [];

        foreach($result as $employee) {
            $data[] = $employeeNormalize->employeeNormalize($employee);

        }

            return $this->json($data);
        } 

        $result = $employeeRepository->findAll();

        $data = [];

        foreach($result as $employee) {
            $data[] = $employeeNormalize->employeeNormalize($employee);

        }
        return $this->json($data);
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
    public function show(
        int $id, 
        EmployeeRepository $employeeRepository,
        EmployeeNormalize $employeeNormalize
        ): Response
    {
        $data = $employeeRepository->find($id);

        dump($id);
        dump($data);

        return $this->json($employeeNormalize->employeeNormalize($data));
    }

    /**
     * @Route(
     *      "",
     *      name="post",
     *      methods={"POST"}
     * )
     */
    public function add(
        Request $request,
        EntityManagerInterface $entityManager,
        ValidatorInterface $validator,
        DepartmentRepository $departmentRepository,
        EmployeeNormalize $employeeNormalize
        ): Response {
        $data = $request->request;
        
        $department = $departmentRepository->find($data->get('department_id'));

        $employee = new Employee();

        $employee->setName($data->get('name'));
        $employee->setEmail($data->get('email'));
        $employee->setAge($data->get('age'));
        $employee->setCity($data->get('city'));
        $employee->setPhone($data->get('phone'));
        $employee->setDepartment($department);

        $errors = $validator->validate($employee);

        if(count($errors) > 0) {
            $dataErrors = [];

            /** @var \Symfony\Component\Validator\ConstraintViolation $error */
            foreach($errors as $error) {
                $dataErrors[] = $error->getMessage();
            }

            return $this->json([
                'status' => 'error',
                'data' => [
                    'errors' => $dataErrors
                ],
            ],
            Response::HTTP_BAD_REQUEST);
        }

        $entityManager->persist($employee);

        // $employee no tiene id.

        $entityManager->flush();

        dump($employee);

        return  $this->json(
            $employeeNormalize->employeeNormalize($employee),
            Response::HTTP_CREATED,
            [
                'Location' => $this->generateUrl(
                'api_employees_get',
                [
                    'id' => $employee->getId()
                ]
                )
            ]

        );
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
    public function update(
        Employee $employee,
        EntityManagerInterface $entityManager,
        Request $request
        ): Response
    {
        $data = $request->request;

        $employee->setName($data->get('name'));
        $employee->setEmail($data->get('email'));
        $employee->setAge($data->get('age'));
        $employee->setCity($data->get('city'));
        $employee->setPhone($data->get('phone'));

        $entityManager->flush();

        return $this->json(null, Response::HTTP_NO_CONTENT
           
        );
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
    public function remove(
        Employee $employee,
        EntityManagerInterface $entityManager
        ): Response
    {
        dump($employee);

        // remove() prepara el sistema pero NO ejecuta la sentencia.
        $entityManager->remove($employee);
        $entityManager->flush();

        return $this->json(null, Response::HTTP_NO_CONTENT);
        
    }
}

