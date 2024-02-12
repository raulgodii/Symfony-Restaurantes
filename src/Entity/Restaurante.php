<?php

namespace App\Entity;

use App\Repository\RestauranteRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;


#[ORM\Entity(repositoryClass: RestauranteRepository::class)]
#[UniqueEntity(fields: ['email'], message: 'An account already exists with this email.')]

class Restaurante implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nombre = null;

    #[ORM\Column(length: 180, unique: true)]
    private ?string $email = null;

    #[ORM\Column]
    private ?string $password = null;

    #[ORM\Column]
    private array $roles = [];

    #[ORM\Column]
    private ?int $CP = null;

    #[ORM\Column(length: 255)]
    private ?string $Pais = null;

    #[ORM\Column(length: 255)]
    private ?string $Direccion = null;

    #[ORM\Column(type: 'boolean')]
    private $isVerified = false;

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

    public function getNombre(): ?string
    {
        return $this->nombre;
    }

    public function setNombre(string $nombre): static
    {
        $this->nombre = $nombre;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }


    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }


    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

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

    public function getPais(): ?string
    {
        return $this->Pais;
    }

    public function setPais(string $Pais): static
    {
        $this->Pais = $Pais;

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

    public function isVerified(): bool
    {
        return $this->isVerified;
    }

    public function setIsVerified(bool $isVerified): static
    {
        $this->isVerified = $isVerified;

        return $this;
    }



    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }




    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
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