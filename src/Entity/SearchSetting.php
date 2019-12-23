<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\SearchSettingRepository")
 */
class SearchSetting
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
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $urlPattern;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $pageOffsetReplacePattern;

    /**
     * @ORM\Column(type="integer")
     */
    private $pageOffsetSteps;

    /**
     * @ORM\Column(type="integer")
     */
    private $endPageOffset;

    /**
     * @ORM\Column(type="integer")
     */
    private $startPageOffset;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $bodyQuerySelector;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $headerQuerySelector;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $linkQuerySelector;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $linksSkippingRegex;

    /**
     * @ORM\Column(type="array", nullable=true)
     */
    private $acceptedKeywords = [];

    /**
     * @ORM\Column(type="array", nullable=true)
     */
    private $rejectedKeywords = [];

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

    public function getUrlPattern(): ?string
    {
        return $this->urlPattern;
    }

    public function setUrlPattern(string $urlPattern): self
    {
        $this->urlPattern = $urlPattern;

        return $this;
    }

    public function getPageOffsetReplacePattern(): ?string
    {
        return $this->pageOffsetReplacePattern;
    }

    public function setPageOffsetReplacePattern(string $pageOffsetReplacePattern): self
    {
        $this->pageOffsetReplacePattern = $pageOffsetReplacePattern;

        return $this;
    }

    public function getPageOffsetSteps(): ?int
    {
        return $this->pageOffsetSteps;
    }

    public function setPageOffsetSteps(int $pageOffsetSteps): self
    {
        $this->pageOffsetSteps = $pageOffsetSteps;

        return $this;
    }

    public function getEndPageOffset(): ?int
    {
        return $this->endPageOffset;
    }

    public function setEndPageOffset(int $endPageOffset): self
    {
        $this->endPageOffset = $endPageOffset;

        return $this;
    }

    public function getStartPageOffset(): ?int
    {
        return $this->startPageOffset;
    }

    public function setStartPageOffset(int $startPageOffset): self
    {
        $this->startPageOffset = $startPageOffset;

        return $this;
    }

    public function getBodyQuerySelector(): ?string
    {
        return $this->bodyQuerySelector;
    }

    public function setBodyQuerySelector(string $bodyQuerySelector): self
    {
        $this->bodyQuerySelector = $bodyQuerySelector;

        return $this;
    }

    public function getHeaderQuerySelector(): ?string
    {
        return $this->headerQuerySelector;
    }

    public function setHeaderQuerySelector(string $headerQuerySelector): self
    {
        $this->headerQuerySelector = $headerQuerySelector;

        return $this;
    }

    public function getLinkQuerySelector(): ?string
    {
        return $this->linkQuerySelector;
    }

    public function setLinkQuerySelector(string $linkQuerySelector): self
    {
        $this->linkQuerySelector = $linkQuerySelector;

        return $this;
    }

    public function getLinksSkippingRegex(): ?string
    {
        return $this->linksSkippingRegex;
    }

    public function setLinksSkippingRegex(?string $linksSkippingRegex): self
    {
        $this->linksSkippingRegex = $linksSkippingRegex;

        return $this;
    }

    public function getAcceptedKeywords(): ?array
    {
        return $this->acceptedKeywords;
    }

    public function setAcceptedKeywords(?array $acceptedKeywords): self
    {
        $this->acceptedKeywords = $acceptedKeywords;

        return $this;
    }

    public function getRejectedKeywords(): ?array
    {
        return $this->rejectedKeywords;
    }

    public function setRejectedKeywords(?array $rejectedKeywords): self
    {
        $this->rejectedKeywords = $rejectedKeywords;

        return $this;
    }
}
