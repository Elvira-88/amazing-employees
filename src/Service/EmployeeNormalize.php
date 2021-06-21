<?php

namespace App\Service;

use App\Entity\Employee;
use Symfony\Component\HttpFoundation\UrlHelper;

class EmployeeNormalize {
    private $urlHelper;

    public function __construct(UrlHelper $constructorDeURL)
    {
        $this->urlHelper = $constructorDeURL;
    }

    /**
     * Normalize an employee.
     * 
     * @param Employee $employee
     * 
     * @return array|null
     */
    public function employeeNormalize (Employee $employee): ?array {
        $projects = [];

        foreach($employee->getProjects() as $project) {
            array_push($projects, [
                'id' => $project->getId(),    
                'name' => $project->getName(),    
            ]);
        }

        $avatar = '';
        if($employee->getAvatar()) {
            $avatar = $this->urlHelper->getAbsoluteUrl('/employee/avatar/'.$employee->getAvatar());
        }

        return [
            'name' => $employee->getName(),
            'email' => $employee->getEmail(),
            'city' => $employee->getCity(),
            'department' => [
                'id' => $employee->getDepartment()->getId(),
                'name' => $employee->getDepartment()->getName(),
            ],
            'projects' => $projects,
            'avatar' => $avatar
        ];
    }
}