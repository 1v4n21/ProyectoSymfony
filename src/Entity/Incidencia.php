<?php

namespace App\Entity;

use App\Repository\IncidenciaRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: IncidenciaRepository::class)]
class Incidencia
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    #[Assert\NotBlank(message: "El título es obligatorio.")]
    private ?string $titulo = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $fechaCreacion = null;

    #[ORM\Column]
    #[Assert\NotBlank(message: "El estado es obligatorio.")]
    private ?string $estado = null;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'incidencias')]
    #[ORM\JoinColumn(nullable: false)]
    private $usuario = null;

    #[ORM\ManyToOne(targetEntity: Cliente::class, inversedBy: 'incidencias')]
    #[ORM\JoinColumn(nullable: false)]
    private $cliente = null;

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
     * Get the value of titulo
     */
    public function getTitulo(): ?string
    {
        return $this->titulo;
    }

    /**
     * Set the value of titulo
     */
    public function setTitulo(?string $titulo): self
    {
        $this->titulo = $titulo;

        return $this;
    }

    /**
     * Get the value of fechaCreacion
     */
    public function getFechaCreacion(): ?\DateTimeInterface
    {
        return $this->fechaCreacion;
    }

    /**
     * Set the value of fechaCreacion
     */
    public function setFechaCreacion(?\DateTimeInterface $fechaCreacion): self
    {
        $this->fechaCreacion = $fechaCreacion;

        return $this;
    }

    /**
     * Get the value of estado
     */
    public function getEstado(): ?string
    {
        return $this->estado;
    }

    /**
     * Set the value of estado
     */
    public function setEstado(?string $estado): self
    {
        $this->estado = $estado;

        return $this;
    }

    /**
     * Get the value of usuario
     */
    public function getUsuario()
    {
        return $this->usuario;
    }

    /**
     * Set the value of usuario
     */
    public function setUsuario($usuario): self
    {
        $this->usuario = $usuario;

        return $this;
    }

    /**
     * Get the value of cliente
     */
    public function getCliente()
    {
        return $this->cliente;
    }

    /**
     * Set the value of cliente
     */
    public function setCliente($cliente): self
    {
        $this->cliente = $cliente;

        return $this;
    }
}