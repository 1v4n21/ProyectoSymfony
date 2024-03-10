<?php

namespace App\Entity;

use App\Repository\ClienteRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ClienteRepository::class)]
class Cliente
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    //Nombre obligatorio
    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: "El nombre es obligatorio.")]
    private ?string $nombre = null;

    #[ORM\Column(length: 255, nullable:true)]
    private ?string $apellidos = null;

    //Telefono obligatorio
    #[ORM\Column]
    #[Assert\NotBlank(message: "El telefono es obligatorio.")]
    private ?int $telefono = null;

    #[ORM\Column(length: 255, nullable:true)]
    private ?string $direccion = null;

    #[ORM\OneToMany(targetEntity: Incidencia::class, mappedBy: 'cliente', orphanRemoval: true)]
    private Collection $incidencias;

    public function __construct()
    {
        $this->incidencias = new ArrayCollection();
    }

    /**
     * Get the value of id
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Set the value of id
     */
    public function setId(?int $id): self
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get the value of nombre
     */
    public function getNombre(): ?string
    {
        return $this->nombre;
    }

    /**
     * Set the value of nombre
     */
    public function setNombre(?string $nombre): self
    {
        $this->nombre = $nombre;

        return $this;
    }

    /**
     * Get the value of apellidos
     */
    public function getApellidos(): ?string
    {
        return $this->apellidos;
    }

    /**
     * Set the value of apellidos
     */
    public function setApellidos(?string $apellidos): self
    {
        $this->apellidos = $apellidos;

        return $this;
    }

    /**
     * Get the value of telefono
     */
    public function getTelefono(): ?int
    {
        return $this->telefono;
    }

    /**
     * Set the value of telefono
     */
    public function setTelefono(?int $telefono): self
    {
        $this->telefono = $telefono;

        return $this;
    }

    /**
     * Get the value of direccion
     */
    public function getDireccion(): ?string
    {
        return $this->direccion;
    }

    /**
     * Set the value of direccion
     */
    public function setDireccion(?string $direccion): self
    {
        $this->direccion = $direccion;

        return $this;
    }

    /**
     * Get the value of incidencias
     */
    public function getIncidencias(): Collection
    {
        return $this->incidencias;
    }

    /**
     * Set the value of incidencias
     */
    public function setIncidencias(Collection $incidencias): self
    {
        $this->incidencias = $incidencias;

        return $this;
    }
}