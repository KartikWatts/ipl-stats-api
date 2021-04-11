<?php

namespace App\Entity;

use App\Repository\SecretKeysRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SecretKeysRepository::class)
 */
class SecretKeys
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
    private $secret_key;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSecretKey(): ?string
    {
        return $this->secret_key;
    }

    public function setSecretKey(string $secret_key): self
    {
        $this->secret_key = $secret_key;

        return $this;
    }
}
