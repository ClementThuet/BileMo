<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\MobilePhoneRepository")
 */
class MobilePhone
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=150)
     */
    private $manufacturer;
    
    /**
     * @ORM\Column(type="string", length=150)
     */
    private $modelName;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $modelReference;

    /**
     * @ORM\Column(type="smallint")
     */
    private $memory;

    /**
     * @ORM\Column(type="string", length=150)
     */
    private $screenDiagonalSize;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="integer")
     */
    private $price;

    public function getId()
    {
        return $this->id;
    }

    public function getModelName()
    {
        return $this->modelName;
    }

    public function setModelName(string $modelName)
    {
        $this->modelName = $modelName;

        return $this;
    }

    public function getModelReference()
    {
        return $this->modelReference;
    }

    public function setModelReference(string $modelReference): self
    {
        $this->modelReference = $modelReference;

        return $this;
    }

    public function getMemory()
    {
        return $this->memory;
    }

    public function setMemory(int $memory): self
    {
        $this->memory = $memory;

        return $this;
    }

    public function getScreenDiagonalSize()
    {
        return $this->screenDiagonalSize;
    }

    public function setScreenDiagonalSize(string $screenDiagonalSize): self
    {
        $this->screenDiagonalSize = $screenDiagonalSize;

        return $this;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    public function getPrice()
    {
        return $this->price;
    }

    public function setPrice(int $price): self
    {
        $this->price = $price;

        return $this;
    }
    
    function getManufacturer() {
        return $this->manufacturer;
    }

    function setManufacturer($manufacturer) {
        $this->manufacturer = $manufacturer;
    }


}
