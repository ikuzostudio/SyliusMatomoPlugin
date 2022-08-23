<?php

namespace Ikuzo\SyliusMatomoPlugin\Services;

use Ikuzo\SyliusMatomoPlugin\Model\MatomoChannelInterface;
use Sylius\Component\Channel\Context\ChannelContextInterface;

class MatomoApiService implements MatomoApiServiceInterface
{
    public ?\MatomoTracker $client = null;

    public function __construct(ChannelContextInterface $channelContext)
    {
        $channel = $channelContext->getChannel();

        if (!$channelContext->getChannel() instanceof MatomoChannelInterface) {
            return null;
        }

        if ($channel->getMatomoActive() && $channel->getMatomoUrl() !== null && $channel->getMatomoWebsiteId() !== null && $channel->getMatomoToken() !== null) 
        {
            $this->client = new \MatomoTracker($channel->getMatomoWebsiteId(), $channel->getMatomoUrl());
            $this->client->setTokenAuth($channel->getMatomoToken());
        }

        return null;
    }

    public function isAvailable(): bool
    {
        return isset($this->client);
    }
}