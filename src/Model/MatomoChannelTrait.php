<?php

declare(strict_types=1);

namespace Ikuzo\SyliusMatomoPlugin\Model;

use Doctrine\ORM\Mapping as ORM;

trait MatomoChannelTrait {

    /**
     * @ORM\Column(name="matomo_active", type="boolean")
     **/
    protected $matomoActive = false;

    /**
     * @ORM\Column(name="matomo_url", type="string", length="255", nullable="true")
     **/
    protected $matomoUrl = null;

    /**
     * @ORM\Column(name="matomo_website_id", type="integer", nullable="true")
     **/
    protected $matomoWebsiteId = null;

    /**
     * @ORM\Column(name="matomo_website_token", type="string", length="255", nullable="true")
     **/
    protected $matomoToken = null;

    public function getMatomoActive(): bool
    {
        return $this->matomoActive;
    }

    public function setMatomoActive(bool $isMatomoActive): void
    {
        $this->matomoActive = $isMatomoActive;
    }

    public function setMatomoUrl(?string $matomoUrl = null): void
    {
        $this->matomoUrl = $matomoUrl;
    }

    public function getMatomoUrl(): ?string
    {
        return $this->matomoUrl;
    }

    public function setMatomoWebsiteId(?int $matomoWebsiteId = null): void
    {
        $this->matomoWebsiteId = $matomoWebsiteId;
    }

    public function getMatomoWebsiteId(): ?int
    {
        return $this->matomoWebsiteId;
    }

    public function setMatomoToken(?string $matomoToken = null): void
    {
        $this->matomoToken = $matomoToken;
    }

    public function getMatomoToken(): ?string
    {
        return $this->matomoToken;
    }
}