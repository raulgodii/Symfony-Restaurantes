<?php

namespace App\Entity;

use App\Repository\PedidoProductoRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PedidoProductoRepository::class)]
class PedidoProducto
{

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'Pedido')]
    #[ORM\JoinColumn(name:"pedido_id",nullable: false)]
    private ?PedidoRestaurante $Pedido = null;

    #[ORM\ManyToOne(inversedBy: 'pedidoProductos')]
    #[ORM\JoinColumn(name:"producto_id",nullable: false)]
    private ?Producto $Producto = null;

    #[ORM\Column]
    private ?int $Unidades = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPedido(): ?PedidoRestaurante
    {
        return $this->Pedido;
    }

    public function setPedido(?PedidoRestaurante $Pedido): static
    {
        $this->Pedido = $Pedido;

        return $this;
    }

    public function getProducto(): ?Producto
    {
        return $this->Producto;
    }

    public function setProducto(?Producto $Producto): static
    {
        $this->Producto = $Producto;

        return $this;
    }

    public function getUnidades(): ?int
    {
        return $this->Unidades;
    }

    public function setUnidades(int $Unidades): static
    {
        $this->Unidades = $Unidades;

        return $this;
    }
}
