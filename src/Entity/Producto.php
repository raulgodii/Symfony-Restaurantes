<?php

namespace App\Entity;

use App\Repository\ProductoRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProductoRepository::class)]
class Producto
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 45)]
    private ?string $Nombre = null;

    #[ORM\Column(length: 255)]
    private ?string $Descripcion = null;

    #[ORM\Column]
    private ?float $Peso = null;

    #[ORM\Column]
    private ?int $Stock = null;

    #[ORM\Column]
    private ?string $Imagen = null;

    #[ORM\ManyToOne(inversedBy: 'productos')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Categoria $Categoria = null;

    #[ORM\OneToMany(targetEntity: PedidoProducto::class, mappedBy: 'Producto', orphanRemoval: true)]
    private Collection $pedidoProductos;

    public function __construct()
    {
        $this->pedidoProductos = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNombre(): ?string
    {
        return $this->Nombre;
    }

    public function setNombre(string $Nombre): static
    {
        $this->Nombre = $Nombre;

        return $this;
    }

    public function getDescripcion(): ?string
    {
        return $this->Descripcion;
    }

    public function setDescripcion(string $Descripcion): static
    {
        $this->Descripcion = $Descripcion;

        return $this;
    }

    public function getPeso(): ?float
    {
        return $this->Peso;
    }

    public function setPeso(float $Peso): static
    {
        $this->Peso = $Peso;

        return $this;
    }

    public function getStock(): ?int
    {
        return $this->Stock;
    }

    public function setStock(int $Stock): static
    {
        $this->Stock = $Stock;

        return $this;
    }

    public function getImagen(): ?string
    {
        return $this->Imagen;
    }

    public function setImagen(string $Imagen): static
    {
        $this->Imagen = $Imagen;

        return $this;
    }

    public function getCategoria(): ?Categoria
    {
        return $this->Categoria;
    }

    public function setCategoria(?Categoria $Categoria): static
    {
        $this->Categoria = $Categoria;

        return $this;
    }

    /**
     * @return Collection<int, PedidoProducto>
     */
    public function getPedidoProductos(): Collection
    {
        return $this->pedidoProductos;
    }

    public function addPedidoProducto(PedidoProducto $pedidoProducto): static
    {
        if (!$this->pedidoProductos->contains($pedidoProducto)) {
            $this->pedidoProductos->add($pedidoProducto);
            $pedidoProducto->setProducto($this);
        }

        return $this;
    }

    public function removePedidoProducto(PedidoProducto $pedidoProducto): static
    {
        if ($this->pedidoProductos->removeElement($pedidoProducto)) {
            // set the owning side to null (unless already changed)
            if ($pedidoProducto->getProducto() === $this) {
                $pedidoProducto->setProducto(null);
            }
        }

        return $this;
    }
}
