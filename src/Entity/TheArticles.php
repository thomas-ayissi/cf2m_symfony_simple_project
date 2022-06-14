<?php

namespace App\Entity;

use App\Repository\TheArticlesRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TheArticlesRepository::class)]
class TheArticles
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 160)]
    private $TheTitle;

    #[ORM\Column(type: 'text')]
    private $TheText;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private $TheDate;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTheTitle(): ?string
    {
        return $this->TheTitle;
    }

    public function setTheTitle(string $TheTitle): self
    {
        $this->TheTitle = $TheTitle;

        return $this;
    }

    public function getTheText(): ?string
    {
        return $this->TheText;
    }

    public function setTheText(string $TheText): self
    {
        $this->TheText = $TheText;

        return $this;
    }

    public function getTheDate(): ?\DateTimeInterface
    {
        return $this->TheDate;
    }

    public function setTheDate(?\DateTimeInterface $TheDate): self
    {
        $this->TheDate = $TheDate;

        return $this;
    }
}
