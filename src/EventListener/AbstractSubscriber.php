<?php

declare(strict_types=1);

namespace Ikuzo\SyliusMatomoPlugin\EventListener;

use Iterator;
use Sylius\Component\Channel\Context\ChannelContextInterface;
use Sylius\Component\Core\Model\ProductInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

abstract class AbstractSubscriber implements EventSubscriberInterface
{
    public function __construct(private ChannelContextInterface $channelContext)
    {
    }

    protected function getTaxonsArray(ProductInterface $product): Iterator
    {
        foreach ($product->getProductTaxons() as $productTaxon) {
            yield $productTaxon->getTaxon()->getName();
        }
    }
}