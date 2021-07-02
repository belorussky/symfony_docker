<?php

namespace App\Entity;

use App\Repository\TodoRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=TodoRepository::class)
 */
class Todo
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @Assert\NotNull
     * @ORM\Column(type="string", length=255)
     */
    // @Assert\Email( message="This is not valid email {{ value }}" ) /*example valid email field*/
    private $priority;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $status;

    /**
     * @ORM\Column(type="datetime", options={"default": "1970-01-02"}))
     */
    private $createdData;

    /**
     * @ORM\Column(type="datetime", options={"default": "1970-01-02"})
     */
    private $dateDue;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $description;

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

    public function getPriority(): ?string
    {
        return $this->priority;
    }

    public function setPriority(string $priority): self
    {
        $this->priority = $priority;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        $this->status = $status;

        return $this;
    }

public function getCreatedData(): ?\DateTimeInterface
{
    return $this->createdData;
}

public function setCreatedData(\DateTimeInterface $createdData): self
{
    $this->createdData = $createdData;

    return $this;
}

public function getDateDue(): ?\DateTimeInterface
{
    return $this->dateDue;
}

public function setDateDue(\DateTimeInterface $dateDue): self
{
    $this->dateDue = $dateDue;

    return $this;
}

public function getDescription(): ?string
{
    return $this->description;
}

public function setDescription(string $description): self
{
    $this->description = $description;

    return $this;
}
}
