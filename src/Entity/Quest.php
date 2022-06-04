<?php

namespace App\Entity;

use App\Repository\QuestRepository;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=QuestRepository::class)
 * @ORM\Table(name="quest")
 * @ApiResource(
 *     collectionOperations={"get", "post"},
 *     itemOperations={"get", "put", "delete"},
 *     normalizationContext={"groups"={"quests:read"}},
 *     denormalizationContext={"groups"={"quests:write"}}
 * )
 */
class Quest {

    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private int $id;

    /**
     * @ORM\Column(type="string", length=100)
     * @Groups({"quests:read", "quests:write"})
     */
    private string $title;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="createdQuests")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"quests:read", "quests:write"})
     */
    private User $author;

    /**
     * @ORM\Column(type="string", length=1000)
     * @Groups({"quests:read", "quests:write"})
     */
    private string $description;

    /**
     * @ORM\Column(type="datetime")
     * @Groups({"quests:read", "quests:write"})
     */
    private DateTime $date;

    /**
     * @ORM\Column(type="string")
     * @Groups({"quests:read", "quests:write"})
     */
    private string $place;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"quests:read", "quests:write"})
     */
    private int $maxPeopleNumber;

    /**
     * @ORM\Column(type="string", length=255, options={"default" : "/images/volunteers-3874924_960_720.webp"})
     * @Groups({"quests:read"})
     */
    private string $picture = "/images/volunteers-3874924_960_720.webp";

    /**
     * @ORM\ManyToMany(targetEntity=User::class, mappedBy="participatingQuests")
     */
    private Collection $participants;

    public function __construct()
    {
        $this->participants = new ArrayCollection();
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    /**
     * @return User
     */
    public function getAuthor(): User
    {
        return $this->author;
    }

    /**
     * @param User $author
     * @return $this
     */
    public function setAuthor(User $author): self
    {
        $this->author = $author;

        return $this;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    /**
     * @return DateTime
     */
    public function getDate(): DateTime
    {
        return $this->date;
    }

    /**
     * @param DateTime $date
     */
    public function setDate(DateTime $date): void
    {
        $this->date = $date;
    }

    /**
     * @return string
     */
    public function getPlace(): string
    {
        return $this->place;
    }

    /**
     * @param string $place
     */
    public function setPlace(string $place): void
    {
        $this->place = $place;
    }

    /**
     * @return int
     */
    public function getMaxPeopleNumber(): int
    {
        return $this->maxPeopleNumber;
    }

    /**
     * @param int $maxPeopleNumber
     */
    public function setMaxPeopleNumber(int $maxPeopleNumber): void
    {
        $this->maxPeopleNumber = $maxPeopleNumber;
    }

    /**
     * @return string
     */
    public function getPicture(): string
    {
        return $this->picture;
    }

    /**
     * @param string $picture
     * @return $this
     */
    public function setPicture(string $picture): self
    {
        $this->picture = $picture;

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getParticipants(): Collection
    {
        return $this->participants;
    }

    /**
     * @param User $participant
     * @return $this
     */
    public function addParticipant(User $participant): self
    {
        if (!$this->participants->contains($participant)) {
            $this->participants[] = $participant;
            $participant->addParticipatingQuest($this);
        }

        return $this;
    }

    /**
     * @param User $participant
     * @return $this
     */
    public function removeParticipant(User $participant): self
    {
        if ($this->participants->removeElement($participant)) {
            $participant->removeParticipatingQuest($this);
        }

        return $this;
    }
}