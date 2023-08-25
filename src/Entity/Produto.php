<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=ProdutoRepository::class)
 */
class Produto
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups("api_list")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=60)
     * @Groups("api_list")
     */
    private $nome;

    /**
     * @ORM\Column(type="float")
     * @Groups("api_list")
     */
    private $valor;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups("api_list")
     */
    private $link;

    /**
     * @ORM\ManyToOne(targetEntity=Categoria::class, inversedBy="produtos")
     * @ORM\JoinColumn(nullable=false)
     * @Groups("api_list")
     */
    private $categoria;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNome(): ?string
    {
        return $this->nome;
    }

    public function setNome(string $nome): self
    {
        $this->nome = $nome;

        return $this;
    }

    public function getValor(): ?float
    {
        return $this->valor;
    }

    public function setValor(float $valor): self
    {
        $this->valor = $valor;

        return $this;
    }

    public function getLink(): ?string
    {
        return $this->link;
    }

    public function setLink(string $link): self
    {
        $this->link = $link;

        return $this;
    }

    public function getCategoria(): ?Categoria
    {
        return $this->categoria;
    }

    public function setCategoria(?Categoria $categoria): self
    {
        $this->categoria = $categoria;

        return $this;
    }
}
