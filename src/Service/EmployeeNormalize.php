<?php

namespace App\Service;

use App\Entity\Employee;

class EmployeeNormalize {

    public function employeeNormalize (Employee $employee): ?array {
        $projects = [];

        foreach($employee->getProjects() as $project) {
            array_push($projects, [
                'id' => $project->getId(),    
                'name' => $project->getName(),    
            ]);
        }

        return [
            'name' => $employee->getName(),
            'email' => $employee->getEmail(),
            'city' => $employee->getCity(),
            'department' => [
                'id' => $employee->getDepartment()->getId(),
                'name' => $employee->getDepartment()->getName(),
            ],
            'projects' => $projects
        ];
    }
}