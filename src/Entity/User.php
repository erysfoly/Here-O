<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @ORM\Table(name="`user`")
 * @UniqueEntity(fields={"username"}, message="There is already an account with this username")
 * @ApiResource(
 *     collectionOperations={"get"},
 *     itemOperations={"get"},
 *     normalizationContext={"groups"={"users:read"}}
 * )
 */
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private int $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     * @Groups({"quests:read", "users:read"})
     */
    private string $username;

    /**
     * @ORM\Column(type="json")
     */
    private array $roles = [];

    /**
     * @ORM\Column(type="string", length=255)
     */
    private string $password;

    /**
     * @ORM\Column(type="string", length=255, unique=true)
     */
    private string $email;

    /**
     * @ORM\OneToMany(targetEntity=Quest::class, mappedBy="author", orphanRemoval=true)
     */
    private Collection $createdQuests;

    /**
     * @ORM\ManyToMany(targetEntity=Quest::class, inversedBy="participants")
     */
    private Collection $participatingQuests;

    public function __construct()
    {
        $this->createdQuests = new ArrayCollection();
        $this->participatingQuests = new ArrayCollection();
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @deprecated since Symfony 5.3, use getUserIdentifier instead
     */
    public function getUsername(): string
    {
        return (string) $this->username;
    }

    /**
     * @param string $username
     * @return $this
     */
    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->username;
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

    /**
     * @param array $roles
     * @return $this
     */
    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }

    /**
     * @param string $password
     * @return $this
     */
    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * This method can be removed in Symfony 6.0 - is not needed for apps that do not check user passwords.
     *
     * @see UserInterface
     */
    public function getSalt(): ?string
    {
        return null;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    /**
     * @return string|null
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * @param string $email
     * @return $this
     */
    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * @return Collection<int, Quest>
     */
    public function getCreatedQuests(): Collection
    {
        return $this->createdQuests;
    }

    /**
     * @param Quest $quest
     * @return $this
     */
    public function addCreatedQuest(Quest $quest): self
    {
        if (!$this->createdQuests->contains($quest)) {
            $this->createdQuests[] = $quest;
            $quest->setAuthor($this);
        }

        return $this;
    }

    /**
     * @param Quest $quest
     * @return $this
     */
    public function removeCreatedQuest(Quest $quest): self
    {
        if ($this->createdQuests->removeElement($quest)) {
            // set the owning side to null (unless already changed)
            if ($quest->getAuthor() === $this) {
                $quest->setAuthor(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Quest>
     */
    public function getParticipatingQuests(): Collection
    {
        return $this->participatingQuests;
    }

    /**
     * @param Quest $participatingQuest
     * @return $this
     */
    public function addParticipatingQuest(Quest $participatingQuest): self
    {
        if (!$this->participatingQuests->contains($participatingQuest)) {
            $this->participatingQuests[] = $participatingQuest;
        }

        return $this;
    }

    /**
     * @param Quest $participatingQuest
     * @return $this
     */
    public function removeParticipatingQuest(Quest $participatingQuest): self
    {
        $this->participatingQuests->removeElement($participatingQuest);

        return $this;
    }
}
