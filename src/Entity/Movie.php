<?php

namespace App\Entity;

use App\Repository\MovieRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MovieRepository::class)]
class Movie
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(length: 255)]
    private ?string $producer = null;

    #[ORM\Column]
    private ?int $duration = null;

    #[ORM\OneToMany(mappedBy: 'movie', targetEntity: Schedule::class, orphanRemoval: true)]
    private Collection $schedule;

    #[ORM\OneToMany(mappedBy: 'movie', targetEntity: Room::class)]
    private Collection $rooms;

    public function __construct()
    {
        $this->schedule = new ArrayCollection();
        $this->rooms = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getProducer(): ?string
    {
        return $this->producer;
    }

    public function setProducer(string $producer): static
    {
        $this->producer = $producer;

        return $this;
    }

    public function getDuration(): ?int
    {
        return $this->duration;
    }

    public function setDuration(int $duration): static
    {
        $this->duration = $duration;

        return $this;
    }

    public function getSchedule(): Collection
    {
        return $this->schedule;
    }

    public function addSchedule(Schedule $schedule): static
    {
        if (!$this->schedule->contains($schedule)) {
            $this->schedule->add($schedule);
            $schedule->setMovie($this);
        }

        return $this;
    }

    public function removeSchedule(Schedule $schedule): static
    {
        if ($this->schedule->removeElement($schedule)) {
            // set the owning side to null (unless already changed)
            if ($schedule->getMovie() === $this) {
                $schedule->setMovie(null);
            }
        }

        return $this;
    }

    public function getRooms(): Collection
    {
        return $this->rooms;
    }

    public function addRoom(Room $room): static
    {
        if (!$this->rooms->contains($room)) {
            $this->rooms->add($room);
            $room->setMovie($this);
        }

        return $this;
    }

    public function removeRoom(Room $room): static
    {
        if ($this->rooms->removeElement($room)) {
            // set the owning side to null (unless already changed)
            if ($room->getMovie() === $this) {
                $room->setMovie(null);
            }
        }

        return $this;
    }
}
