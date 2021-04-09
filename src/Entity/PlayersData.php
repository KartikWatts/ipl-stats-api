<?php

namespace App\Entity;

use App\Repository\PlayersDataRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PlayersDataRepository::class)
 */
class PlayersData
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $player_id;

    /**
     * @ORM\Column(type="integer")
     */
    private $team_id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $player_name;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $matches;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $not_outs;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $runs;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $highest;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $batting_average;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $strike_rate;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $hundreds;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $fifties;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $fours;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $sixes;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $catches;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $overs;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $wickets;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $average;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $economy;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $four_wickets;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPlayerNumber(): ?int
    {
        return $this->player_number;
    }

    public function setPlayerNumber(int $player_number): self
    {
        $this->player_number = $player_number;

        return $this;
    }

    public function getPlayerId(): ?int
    {
        return $this->player_id;
    }

    public function setPlayerId(int $player_id): self
    {
        $this->player_id = $player_id;

        return $this;
    }

    public function getTeamId(): ?string
    {
        return $this->team_id;
    }

    public function setTeamId(string $team_id): self
    {
        $this->team_id = $team_id;

        return $this;
    }

    public function getPlayerName(): ?string
    {
        return $this->player_name;
    }

    public function setPlayerName(string $player_name): self
    {
        $this->player_name = $player_name;

        return $this;
    }

    public function getMatches(): ?string
    {
        return $this->matches;
    }

    public function setMatches(?string $matches): self
    {
        $this->matches = $matches;

        return $this;
    }

    public function getNotOuts(): ?string
    {
        return $this->not_outs;
    }

    public function setNotOuts(?string $not_outs): self
    {
        $this->not_outs = $not_outs;

        return $this;
    }

    public function getRuns(): ?string
    {
        return $this->runs;
    }

    public function setRuns(?string $runs): self
    {
        $this->runs = $runs;

        return $this;
    }

    public function getHighest(): ?string
    {
        return $this->highest;
    }

    public function setHighest(?string $highest): self
    {
        $this->highest = $highest;

        return $this;
    }

    public function getBattingAverage(): ?string
    {
        return $this->batting_average;
    }

    public function setBattingAverage(?string $batting_average): self
    {
        $this->batting_average = $batting_average;

        return $this;
    }

    public function getStrikeRate(): ?string
    {
        return $this->strike_rate;
    }

    public function setStrikeRate(?string $strike_rate): self
    {
        $this->strike_rate = $strike_rate;

        return $this;
    }

    public function getHundreds(): ?string
    {
        return $this->hundreds;
    }

    public function setHundreds(?string $hundreds): self
    {
        $this->hundreds = $hundreds;

        return $this;
    }

    public function getFifties(): ?string
    {
        return $this->fifties;
    }

    public function setFifties(?string $fifties): self
    {
        $this->fifties = $fifties;

        return $this;
    }

    public function getFours(): ?string
    {
        return $this->fours;
    }

    public function setFours(?string $fours): self
    {
        $this->fours = $fours;

        return $this;
    }

    public function getSixes(): ?string
    {
        return $this->sixes;
    }

    public function setSixes(?string $sixes): self
    {
        $this->sixes = $sixes;

        return $this;
    }

    public function getCatches(): ?string
    {
        return $this->catches;
    }

    public function setCatches(?string $catches): self
    {
        $this->catches = $catches;

        return $this;
    }

    public function getOvers(): ?string
    {
        return $this->overs;
    }

    public function setOvers(?string $overs): self
    {
        $this->overs = $overs;

        return $this;
    }

    public function getWickets(): ?string
    {
        return $this->wickets;
    }

    public function setWickets(?string $wickets): self
    {
        $this->wickets = $wickets;

        return $this;
    }

    public function getAverage(): ?string
    {
        return $this->average;
    }

    public function setAverage(?string $average): self
    {
        $this->average = $average;

        return $this;
    }

    public function getEconomy(): ?string
    {
        return $this->economy;
    }

    public function setEconomy(?string $economy): self
    {
        $this->economy = $economy;

        return $this;
    }

    public function getFourWickets(): ?string
    {
        return $this->four_wickets;
    }

    public function setFourWickets(?string $four_wickets): self
    {
        $this->four_wickets = $four_wickets;

        return $this;
    }
}
