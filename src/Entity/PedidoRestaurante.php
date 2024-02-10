<?php

namespace App\Entity;

use App\Repository\PedidoRestauranteRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PedidoRestauranteRepository::class)]
class PedidoRestaurante
{

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $CodPed = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $Fecha = null;

    #[ORM\Column]
    private ?bool $Enviado = null;

    #[ORM\ManyToOne(inversedBy: 'Pedidos')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Restaurante $Restaurante = null;

    #[ORM\OneToMany(targetEntity: PedidoProducto::class, mappedBy: 'Pedido', orphanRemoval: true)]
    private Collection $Pedido;

    public function __construct()
    {
        $this->Pedido = new ArrayCollection();
    }

    public function getCodPed(): ?int
    {
        return $this->CodPed;
    }

    public function setCodPed(int $CodPed): static
    {
        $this->CodPed = $CodPed;

        return $this;
    }

    public function getFecha(): ?\DateTimeInterface
    {
        return $this->Fecha;
    }

    public function setFecha(\DateTimeInterface $Fecha): static
    {
        $this->Fecha = $Fecha;

        return $this;
    }

    public function isEnviado(): ?bool
    {
        return $this->Enviado;
    }

    public function setEnviado(bool $Enviado): static
    {
        $this->Enviado = $Enviado;

        return $this;
    }

    public function getRestaurante(): ?Restaurante
    {
        return $this->Restaurante;
    }

    public function setRestaurante(?Restaurante $Restaurante): static
    {
        $this->Restaurante = $Restaurante;

        return $this;
    }

    /**
     * @return Collection<int, PedidoProducto>
     */
    public function getPedido(): Collection
    {
        return $this->Pedido;
    }

    public function addPedido(PedidoProducto $pedido): static
    {
        if (!$this->Pedido->contains($pedido)) {
            $this->Pedido->add($pedido);
            $pedido->setPedido($this);
        }

        return $this;
    }

    public function removePedido(PedidoProducto $pedido): static
    {
        if ($this->Pedido->removeElement($pedido)) {
            // set the owning side to null (unless already changed)
            if ($pedido->getPedido() === $this) {
                $pedido->setPedido(null);
            }
        }

        return $this;
    }
}
