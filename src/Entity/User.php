<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use http\Env\Request;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @ORM\Table(name="`user`")
 */
class User implements UserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     */
    private $email;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * The people who I think are my friends.
     *
     * @ORM\OneToMany(targetEntity="Friends", mappedBy="user")
     */
    private $friends;
    /**
     * Array of friendship requests (which users requested current user to friends)
     * @var array
     */
    private $requests = [];

    /**
     * The people who think that I’m their friend.
     *
     * @ORM\OneToMany(targetEntity="Friends", mappedBy="friend")
     */
    private $friendsWithMe;
    private $request;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->email;
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

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return (string) $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Returning a salt is only needed, if you are not using a modern
     * hashing algorithm (e.g. bcrypt or sodium) in your security.yaml.
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

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     *
     * Returns friend IDs
     * @return mixed
     */
    public function getFriends()
    {
        return $this->friends;
    }

    /**
     * @param mixed $friends
     */
    public function setFriends($friends): void
    {
        $this->friends = $friends;
    }

    /**
     * @return mixed
     */
    public function getFriendsWithMe()
    {
        return $this->friendsWithMe;
    }

    /**
     * @param mixed $friendsWithMe
     */
    public function setFriendsWithMe($friendsWithMe): void
    {
        $this->friendsWithMe = $friendsWithMe;
    }

    public function addFriend($friendId)
    {
        if (!$this->hasFriend($friendId)) {
            $this->friends[] = $friendId;
        }

        return $this;
    }
    public function hasFriend($friendId)
    {
        return in_array($friendId, $this->friends);
    }
    /**
     * Returns array of IDs of friendship requests
     * @return string[]
     */
    public function getRequests()
    {
        return $this->requests;
    }

    /**
     * Removes friend request
     * @param Request $requesterId ID of user
     * @return $this
     */
    public function removeRequest(Request $requesterId): static
    {
        $this->requests = array_diff($this->requests, [$requesterId]);

        return $this;
    }

    /**
     * Checks if current user was requested a friendship by certain user
     * @param Request $requesterId user id who requested friendship
     * @return bool
     */
    public function hasRequest(Request $requesterId)
    {
        return in_array($requesterId, $this->friends);
    }

    /**
     * Adds friendship request
     * @param string $userId ID of user who requests friendship
     * @return $this
     */
    public function addRequest(string $userId): static
    {
        if (!in_array($userId, $this->requests)) {
            $this->requests[] = $userId;
        }

        return $this;
    }
}
