<?php

namespace App\Entity;

use App\Repository\DateOpeningClosingTimeRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DateOpeningClosingTimeRepository::class)]
class DateOpeningClosingTime
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $day = null;

    #[ORM\Column(type: Types::TIME_MUTABLE)]
    private ?\DateTimeInterface $opening_time_moon = null;

    #[ORM\Column(type: Types::TIME_MUTABLE)]
    private ?\DateTimeInterface $closing_time_moon = null;

    #[ORM\Column(type: Types::TIME_MUTABLE)]
    private ?\DateTimeInterface $opening_time_evening = null;

    #[ORM\Column(type: Types::TIME_MUTABLE)]
    private ?\DateTimeInterface $closing_time_evening = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDay(): ?string
    {
        return $this->day;
    }

    public function setDay(string $day): self
    {
        $this->day = $day;

        return $this;
    }

    public function getOpeningTimeMoon(): ?\DateTimeInterface
    {
        return $this->opening_time_moon;
    }

    public function setOpeningTimeMoon(\DateTimeInterface $opening_time_moon): self
    {
        $this->opening_time_moon = $opening_time_moon;

        return $this;
    }

    public function getClosingTimeMoon(): ?\DateTimeInterface
    {
        return $this->closing_time_moon;
    }

    public function setClosingTimeMoon(\DateTimeInterface $closing_time_moon): self
    {
        $this->closing_time_moon = $closing_time_moon;

        return $this;
    }

    public function getOpeningTimeEvening(): ?\DateTimeInterface
    {
        return $this->opening_time_evening;
    }

    public function setOpeningTimeEvening(\DateTimeInterface $opening_time_evening): self
    {
        $this->opening_time_evening = $opening_time_evening;

        return $this;
    }

    public function getClosingTimeEvening(): ?\DateTimeInterface
    {
        return $this->closing_time_evening;
    }

    public function setClosingTimeEvening(\DateTimeInterface $closing_time_evening): self
    {
        $this->closing_time_evening = $closing_time_evening;

        return $this;
    }
}
