<?php

namespace App\Entity;

use App\Repository\TheUsersRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: TheUsersRepository::class)]
class TheUsers implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 180, unique: true)]
    private $username;

    #[ORM\Column(type: 'json')]
    private $roles = [];

    #[ORM\Column(type: 'string')]
    private $password;

    #[ORM\Column(type: 'string', length: 180, unique: true)]
    private $themail;

    #[ORM\Column(type: 'string', length: 250)]
    private $therealname;

    #[ORM\OneToMany(mappedBy: 'useriduser', targetEntity: TheArticles::class)]
    private $theArticles;

    public function __construct()
    {
        $this->theArticles = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @deprecated since Symfony 5.3, use getUserIdentifier instead
     */
    public function getUsername(): string
    {
        return (string) $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->username;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Returning a salt is only needed, if you are not using a modern
     * hashing algorithm (e.g. bcrypt or sodium) in your security.yaml.
     *
     * @see UserInterface
     */
    public function getSalt(): ?string
    {
        return null;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getThemail(): ?string
    {
        return $this->themail;
    }

    public function setThemail(string $themail): self
    {
        $this->themail = $themail;

        return $this;
    }

    public function getTherealname(): ?string
    {
        return $this->therealname;
    }

    public function setTherealname(string $therealname): self
    {
        $this->therealname = $therealname;

        return $this;
    }

    /**
     * @return Collection<int, TheArticles>
     */
    public function getTheArticles(): Collection
    {
        return $this->theArticles;
    }

    public function addTheArticle(TheArticles $theArticle): self
    {
        if (!$this->theArticles->contains($theArticle)) {
            $this->theArticles[] = $theArticle;
            $theArticle->setUseriduser($this);
        }

        return $this;
    }

    public function removeTheArticle(TheArticles $theArticle): self
    {
        if ($this->theArticles->removeElement($theArticle)) {
            // set the owning side to null (unless already changed)
            if ($theArticle->getUseriduser() === $this) {
                $theArticle->setUseriduser(null);
            }
        }

        return $this;
    }
}
