<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use OpenApi\Annotations as OA;
use Symfony\Component\Validator\Constraints as Assert;
use Hateoas\Configuration\Annotation as Hateoas;

/**
 * @OA\Schema()
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @Hateoas\Relation("self", href = "expr('/api/user/' ~ object.getId())")
 * @Hateoas\Relation("get_all", href = "expr('/api/users')")
 * @Hateoas\Relation("add", href = "expr('/api/user/add')")
 * @Hateoas\Relation("delete", href = "expr('/api/user/delete/' ~ object.getId())")
 * 
 */
class User
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer", nullable=false)
     * @OA\Property(type="integer", nullable=false)
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100, nullable=false, unique=true)
     * @OA\Property(type="string", nullable=false)
     * @Assert\NotBlank
     * @Assert\Email
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255, nullable=false)
     * @OA\Property(type="string", nullable=false)
     * @Assert\NotBlank 
     * @Assert\Type("string")
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @OA\Property(type="string", nullable=true)
     * @Assert\Type("string")
     */
    private $adress;
    
    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @OA\Property(type="string", format="date-time", nullable=true)
     * @Assert\Type("datetime")
     */
    private $birthDate;
    
    /**
     * @ORM\Column(type="datetime", nullable=false)
     */
    private $registeredAt;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Client", inversedBy="users")
     * @ORM\JoinColumn(nullable=false)
     * @Assert\NotNull 
     */
    private $client;
    
    public function __construct()
    {
        $this->registeredAt = new \DateTime('now');
    }
    public function getId()
    {
        return $this->id;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }
    
    function getAdress() {
        return $this->adress;
    }

    function getBirthDate() {
        return $this->birthDate;
    }

    function setAdress($adress) {
        $this->adress = $adress;
    }

    function setBirthDate($birthDate) {
        $this->birthDate = $birthDate;
    }

    public function getRegisteredAt()
    {
        return $this->registeredAt;
    }

    public function setRegisteredAt(\DateTimeInterface $registeredAt): self
    {
        $this->registeredAt = $registeredAt;

        return $this;
    }

    public function getClient()
    {
        return $this->client;
    }

    public function setClient(Client $client)
    {
        $this->client = $client;

        return $this;
    }
}
