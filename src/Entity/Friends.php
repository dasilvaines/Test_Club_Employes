<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\FriendsRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 *
 * @ORM\Table(name="`friends`")
 * @ORM\Entity(repositoryClass=FriendsRepository::class)
 */
#[ApiResource]
class Friends
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="friends")
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="friendsWithMe")
     */
    private $friend;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $is_pending;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSender(): ?string
    {
        return $this->sender;
    }

    public function setSender(?string $sender): self
    {
        $this->sender = $sender;

        return $this;
    }

    public function getIsPending(): ?bool
    {
        return $this->is_pending;
    }

    public function setIsPending(?bool $is_pending): self
    {
        $this->is_pending = $is_pending;

        return $this;
    }

    public function getReceiver(): ?string
    {
        return $this->receiver;
    }

    public function setReceiver(?string $receiver): self
    {
        $this->receiver = $receiver;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param mixed $user
     */
    public function setUser($user): void
    {
        $this->user = $user;
    }

    /**
     * @return mixed
     */
    public function getFriend()
    {
        return $this->friend;
    }

    /**
     * @param mixed $friend
     */
    public function setFriend($friend): void
    {
        $this->friend = $friend;
    }

}
