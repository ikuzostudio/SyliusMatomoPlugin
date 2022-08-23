<?php

declare(strict_types=1);

namespace Tests\Ikuzo\SyliusMatomoPlugin\Application\Entity;

use Doctrine\ORM\Mapping as ORM;
use Ikuzo\SyliusMatomoPlugin\Model\MatomoChannelInterface;
use Ikuzo\SyliusMatomoPlugin\Model\MatomoChannelTrait;
use Sylius\Component\Core\Model\Channel as BaseChannel;

/**
 * @ORM\Table(name="sylius_channel")
 * @ORM\Entity()
 */
class Channel extends BaseChannel implements MatomoChannelInterface
{
    use MatomoChannelTrait;
}