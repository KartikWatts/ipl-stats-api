<?php

namespace App\Entity;

use App\Repository\TeamsDataRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TeamsDataRepository::class)
 */
class TeamsData
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $team_id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $team_name;

    public function getTeamId(): ?int
    {
        return $this->team_id;
    }

    public function setTeamId(int $team_id): self
    {
        $this->team_id = $team_id;

        return $this;
    }

    public function getTeamName(): ?string
    {
        return $this->team_name;
    }

    public function setTeamName(string $team_name): self
    {
        $this->team_name = $team_name;

        return $this;
    }
}
