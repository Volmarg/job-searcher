<?php

namespace App\Entity\Module\Mail;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\Module\Mail\MailTemplateRepository")
 */
class MailTemplate
{
    const KEY_TITLE            = "title";
    const KEY_NAME             = "name";
    const KEY_DESCRIPTION      = "description";
    const KEY_ATTACHMENT_LINKS = "attachmentLinks";

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $description;

    /**
     * @ORM\Column(type="array", nullable=true)
     */
    private $attachmentLinks = [];

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $title;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getAttachmentLinks(): ?array
    {
        return $this->attachmentLinks;
    }

    public function setAttachmentLinks($attachmentLinks): self
    {
        if( is_string($attachmentLinks) ) {
            $attachmentLinksArray  =  explode(',',$attachmentLinks);
            $this->attachmentLinks = $attachmentLinksArray;
            return $this;
        }

        $this->attachmentLinks = $attachmentLinks;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }
}
