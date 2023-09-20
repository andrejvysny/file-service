<?php

namespace App\Entity;

use App\Repository\FileRepository;
use DateTime;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Types\UlidType;
use Symfony\Component\Uid\Ulid;

#[ORM\Entity(repositoryClass: FileRepository::class)]
class File
{
    #[ORM\Id]
    #[ORM\Column(type: UlidType::NAME, unique: true)]
    #[ORM\GeneratedValue(strategy: 'NONE')]
    private ?Ulid $id = null;

    #[ORM\Column(length: 255)]
    private ?string $originalName = null;

    #[ORM\Column(length: 255)]
    private ?string $extension = null;

    #[ORM\Column(length: 255)]
    private ?string $path = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $uploadedAt = null;

    #[ORM\Column(length: 255)]
    private ?string $url = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $owner = null;

    #[ORM\Column(type: Types::BIGINT)]
    private ?string $size = null;

    #[ORM\Column(nullable: true)]
    private ?DateTime $removeAt = null;


    /**
     * @return Ulid|null
     */
    public function getId(): ?Ulid
    {
        return $this->id;
    }

    /**
     * @param Ulid|null $id
     */
    public function setId(?Ulid $id): void
    {
        $this->id = $id;
    }

    /**
     * @return string|null
     */
    public function getOriginalName(): ?string
    {
        return $this->originalName;
    }

    /**
     * @param string|null $originalName
     */
    public function setOriginalName(?string $originalName): void
    {
        $this->originalName = $originalName;
    }

    /**
     * @return string|null
     */
    public function getExtension(): ?string
    {
        return $this->extension;
    }

    /**
     * @param string|null $extension
     */
    public function setExtension(?string $extension): void
    {
        $this->extension = $extension;
    }

    /**
     * @return string|null
     */
    public function getPath(): ?string
    {
        return $this->path;
    }

    /**
     * @param string|null $path
     */
    public function setPath(?string $path): void
    {
        $this->path = $path;
    }

    /**
     * @return \DateTimeImmutable|null
     */
    public function getUploadedAt(): ?\DateTimeImmutable
    {
        return $this->uploadedAt;
    }

    /**
     * @param \DateTimeImmutable|null $uploadedAt
     */
    public function setUploadedAt(?\DateTimeImmutable $uploadedAt): void
    {
        $this->uploadedAt = $uploadedAt;
    }

    /**
     * @return string|null
     */
    public function getUrl(): ?string
    {
        return $this->url;
    }

    /**
     * @param string|null $url
     */
    public function setUrl(?string $url): void
    {
        $this->url = $url;
    }

    /**
     * @return User|null
     */
    public function getOwner(): ?User
    {
        return $this->owner;
    }

    /**
     * @param User|null $owner
     */
    public function setOwner(?User $owner): void
    {
        $this->owner = $owner;
    }

    /**
     * @return string|null
     */
    public function getSize(): ?string
    {
        return $this->size;
    }

    /**
     * @param string|null $size
     */
    public function setSize(?string $size): void
    {
        $this->size = $size;
    }

    /**
     * @return DateTime|null
     */
    public function getRemoveAt(): ?DateTime
    {
        return $this->removeAt;
    }

    /**
     * @param DateTime|null $removeAt
     */
    public function setRemoveAt(?DateTime $removeAt): void
    {
        $this->removeAt = $removeAt;
    }


}
