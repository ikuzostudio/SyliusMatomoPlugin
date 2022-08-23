<?php

declare(strict_types=1);

namespace Ikuzo\SyliusMatomoPlugin\Model;

interface MatomoChannelInterface {
    public function getMatomoActive(): bool;
    public function setMatomoActive(bool $input): void;
    public function setMatomoUrl(?string $input): void;
    public function getMatomoUrl(): ?string;
    public function setMatomoWebsiteId(?int $input): void;
    public function getMatomoWebsiteId(): ?int;
    public function setMatomoToken(?string $input): void;
    public function getMatomoToken(): ?string;
}