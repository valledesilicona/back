<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 */
class Film
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $user;

    /**
     * @ORM\Column(type="datetime")
     */
    private $created;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $film_id;

    /**
     * @ORM\Column(type="text")
     */
    private $link;

    /**
     * @ORM\Column(type="integer")
     */
    private $port;



    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): ?string
    {
        return $this->user;
    }

    public function setUser(string $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getCreated(): ?\DateTimeInterface
    {
        return $this->created;
    }

    public function setCreated(\DateTimeInterface $created): self
    {
        $this->created = $created;

        return $this;
    }

    public function getFilmId(): ?string
    {
        return $this->film_id;
    }

    public function setFilmId(string $film_id): self
    {
        $this->film_id = $film_id;

        return $this;
    }

    public function getLink(): ?string
    {
        return $this->link;
    }

    public function setLink(string $link): self
    {
        $this->link = $link;

        return $this;
    }

    public function getPort(): ?int
    {
        return $this->port;
    }

    public function setPort(int $port): self
    {
        $this->port = $port;

        return $this;
    }


    public function toJson()
    {

        return [

            'user' => $this->getUser(),
            'created' => $this->getCreated()->getTimestamp(),
            'port' => $this->getPort(),
            'film_id' => $this->getFilmId(),
            'link' => $this->getLink()

        ];

    }



}
