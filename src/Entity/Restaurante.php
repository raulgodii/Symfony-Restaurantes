<?php

namespace App\Entity;

use App\Repository\RestauranteRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RestauranteRepository::class)]
class Restaurante
{

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 90)]
    private ?string $Correo = null;

    #[ORM\Column(length: 45)]
    private ?string $Clave = null;

    #[ORM\Column(length: 45)]
    private ?string $Pais = null;

    #[ORM\Column]
    private ?int $CP = null;

    #[ORM\Column(length: 45)]
    private ?string $Ciudad = null;

    #[ORM\Column(length: 255)]
    private ?string $Direccion = null;

    #[ORM\Column(length: 45)]
    private ?string $Rol = null;

    #[ORM\OneToMany(targetEntity: PedidoRestaurante::class, mappedBy: 'Restaurante', orphanRemoval: true)]
    private Collection $Pedidos;

    public function __construct()
    {
        $this->Pedidos = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCorreo(): ?string
    {
        return $this->Correo;
    }

    public function setCorreo(string $Correo): static
    {
        $this->Correo = $Correo;

        return $this;
    }

    public function getClave(): ?string
    {
        return $this->Clave;
    }

    public function setClave(string $Clave): static
    {
        $this->Clave = $Clave;

        return $this;
    }

    public function getPais(): ?string
    {
        return $this->Pais;
    }

    public function setPais(string $Pais): static
    {
        $this->Pais = $Pais;

        return $this;
    }

    public function getCP(): ?int
    {
        return $this->CP;
    }

    public function setCP(int $CP): static
    {
        $this->CP = $CP;

        return $this;
    }

    public function getCiudad(): ?string
    {
        return $this->Ciudad;
    }

    public function setCiudad(string $Ciudad): static
    {
        $this->Ciudad = $Ciudad;

        return $this;
    }

    public function getDireccion(): ?string
    {
        return $this->Direccion;
    }

    public function setDireccion(string $Direccion): static
    {
        $this->Direccion = $Direccion;

        return $this;
    }

    public function getRol(): ?string
    {
        return $this->Rol;
    }

    public function setRol(string $Rol): static
    {
        $this->Rol = $Rol;

        return $this;
    }

    /**
     * @return Collection<int, PedidoRestaurante>
     */
    public function getPedidos(): Collection
    {
        return $this->Pedidos;
    }

    public function addPedido(PedidoRestaurante $pedido): static
    {
        if (!$this->Pedidos->contains($pedido)) {
            $this->Pedidos->add($pedido);
            $pedido->setRestaurante($this);
        }

        return $this;
    }

    public function removePedido(PedidoRestaurante $pedido): static
    {
        if ($this->Pedidos->removeElement($pedido)) {
            // set the owning side to null (unless already changed)
            if ($pedido->getRestaurante() === $this) {
                $pedido->setRestaurante(null);
            }
        }

        return $this;
    }
}
