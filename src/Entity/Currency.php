<?php

namespace App\Entity;

use App\Repository\CurrencyRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity(repositoryClass: CurrencyRepository::class)]
class Currency
{
    #[ORM\Id]
    #[ORM\Column( type: 'uuid', unique: true )]
    #[ORM\GeneratedValue( strategy: 'CUSTOM' )]
    #[ORM\CustomIdGenerator( class: 'doctrine.uuid_generator' )]
    private ?Uuid $id = null;

    #[ORM\Column(length: 50)]
    private ?string $name = null;

    #[ORM\Column(length: 3)]
    private ?string $currencyCode = null;

    #[ORM\Column(length: 10)]
    private ?string $exchangeRate = null;

    public function getId(): ?Uuid
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

    public function getCurrencyCode(): ?string
    {
        return $this->currencyCode;
    }

    public function setCurrencyCode(string $currencyCode): self
    {
        $this->currencyCode = $currencyCode;

        return $this;
    }

    public function getExchangeRate(): ?string
    {
        return $this->exchangeRate;
    }

    public function setExchangeRate(string $exchangeRate): self
    {
        $this->exchangeRate = $exchangeRate;

        return $this;
    }
}
