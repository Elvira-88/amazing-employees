<?php

namespace App\Entity;

use App\Repository\EmployeeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass=EmployeeRepository::class)
 * @UniqueEntity("email")
 */
class Employee
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=128)
     * 
     * @Assert\NotBlank
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=128, unique=true)
     * 
     * @Assert\Email(
     *      message = "El correo {{ value }} no tiene un formato válido."
     * )
     */
    private $email;

    /**
     * @ORM\Column(type="smallint")
     * 
     * @Assert\GreaterThanOrEqual(
     *      value = 18,
     *      message = "El empelado debe ser mayor de edad."
     * )
     */
    private $age;

    /**
     * @ORM\Column(type="string", length=128, nullable=true)
     */
    private $city;

    /**
     * @ORM\Column(type="string", length=12)
     */
    private $phone;

    /**
     * @ORM\ManyToOne(targetEntity=Department::class, inversedBy="employees")
     * @ORM\JoinColumn(nullable=false)
     */
    private $department;

    /**
     * @ORM\ManyToMany(targetEntity=Project::class, mappedBy="employees")
     */
    private $projects;

    public function __construct()
    {
        $this->projects = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getAge(): ?int
    {
        return $this->age;
    }

    public function setAge(int $age): self
    {
        $this->age = $age;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(?string $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    public function getDepartment(): ?Department
    {
        return $this->department;
    }

    public function setDepartment(?Department $department): self
    {
        $this->department = $department;

        return $this;
    }

    /**
     * @return Collection|Project[]
     */
    public function getProjects(): Collection
    {
        return $this->projects;
    }

    public function addProject(Project $project): self
    {
        if (!$this->projects->contains($project)) {
            $this->projects[] = $project;
            $project->addEmployee($this);
        }

        return $this;
    }

    public function removeProject(Project $project): self
    {
        if ($this->projects->removeElement($project)) {
            $project->removeEmployee($this);
        }

        return $this;
    }
}
