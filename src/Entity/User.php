<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 180, unique: true)]
    private $email;

    #[ORM\Column(type: 'json')]
    private $roles = [];

    #[ORM\Column(type: 'string')]
    private $password;

    #[ORM\Column(type: 'string')]
    private $plainPassword;

    #[ORM\Column(type: 'string')]
    private $salt;


    #[ORM\Column(type: 'string', length: 255)]
    private $prenom;

    #[ORM\Column(type: 'string', length: 255)]
    private $nom;

    #[ORM\Column(type: 'string', length: 100, nullable: true)]
    private $service1;

    #[ORM\Column(type: 'string', length: 100, nullable: true)]
    private $service2;

    #[ORM\OneToMany(mappedBy: 'User', targetEntity: Calendar::class)]
    private $Calendar;

    #[ORM\OneToMany(mappedBy: 'userId', targetEntity: Service::class)]
    private $serviceId;

    public function __construct()
    {
        $this->Calendar = new ArrayCollection();
        $this->serviceId = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
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
     * @return string
     */
    public function getPlainPassword()
    {
        return $this->plainPassword;
    }

    /**
     * @param string $plainPassword
     */
    public function setPlainPassword(?string $plainPassword)
    {
        $this->plainPassword = $plainPassword;
    }

    /**
     * @return string
     */
    public function getSalt()
    {
        return $this->salt;
    }

    /**
     * @param string $salt
     */
    public function setSalt(string $salt)
    {
        $this->salt = $salt;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        $this->plainPassword = null;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getService1(): ?string
    {
        return $this->service1;
    }

    public function setService1(?string $service1): self
    {
        $this->service1 = $service1;

        return $this;
    }

    public function getService2(): ?string
    {
        return $this->service2;
    }

    public function setService2(?string $service2): self
    {
        $this->service2 = $service2;

        return $this;
    }

    /**
     * @return Collection<int, Calendar>
     */
    public function getCalendar(): Collection
    {
        return $this->Calendar;
    }

    public function addCalendar(Calendar $calendar): self
    {
        if (!$this->Calendar->contains($calendar)) {
            $this->Calendar[] = $calendar;
            $calendar->setUser($this);
        }

        return $this;
    }

    public function removeCalendar(Calendar $calendar): self
    {
        if ($this->Calendar->removeElement($calendar)) {
            // set the owning side to null (unless already changed)
            if ($calendar->getUser() === $this) {
                $calendar->setUser(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        return $this->nom . ' ' .$this->prenom;
    }

    /**
     * @return Collection<int, Service>
     */
    public function getServiceId(): Collection
    {
        return $this->serviceId;
    }

    public function addServiceId(Service $serviceId): self
    {
        if (!$this->serviceId->contains($serviceId)) {
            $this->serviceId[] = $serviceId;
            $serviceId->setUserId($this);
        }

        return $this;
    }

    public function removeServiceId(Service $serviceId): self
    {
        if ($this->serviceId->removeElement($serviceId)) {
            // set the owning side to null (unless already changed)
            if ($serviceId->getUserId() === $this) {
                $serviceId->setUserId(null);
            }
        }

        return $this;
    }
}
