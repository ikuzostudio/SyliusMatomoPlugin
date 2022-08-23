<?php

declare(strict_types=1);

namespace Ikuzo\SyliusMatomoPlugin\EventListener;

use Ikuzo\SyliusMatomoPlugin\Services\MatomoApiServiceInterface;
use Psr\EventDispatcher\EventDispatcherInterface;
use Sylius\Bundle\ResourceBundle\Event\ResourceControllerEvent;
use Sylius\Component\Core\Model\OrderInterface;
use Sylius\Component\Order\Context\CartContextInterface;
use Sylius\Component\Order\Repository\OrderRepositoryInterface;
use Sylius\Component\Product\Resolver\ProductVariantResolverInterface;
use Symfony\Component\EventDispatcher\GenericEvent;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\KernelEvents;

final class CartSubscriber extends AbstractSubscriber
{
    use FormatAmountTrait;

    public function __construct(
        private EventDispatcherInterface $eventDispatcher,
        private ProductVariantResolverInterface $productVariantResolver,
        private MatomoApiServiceInterface $matomo,
        private CartContextInterface $cartContext,
        private OrderRepositoryInterface $orderRepository
    ) {        
    }

    public static function getSubscribedEvents(): array
    {
        return [
            'sylius.order_item.post_add' => 'trackOrderItem',
            'sylius.order_item.post_delete' => 'trackOrderItem',
            'sylius.cart_change' => 'trackCart',
            KernelEvents::REQUEST => 'trackOrder',
        ];
    }

    public function trackOrder(RequestEvent $requestEvent): void
    {
        if (!$this->matomo->isAvailable()) {
            return;
        }

        $request = $requestEvent->getRequest();

        if (!$requestEvent->isMainRequest()) {
            return;
        }

        if (!$request->attributes->has('_route')) {
            return;
        }

        
        $route = $request->attributes->get('_route');
        if ('sylius_shop_order_thank_you' !== $route) {
            return;
        }

        $orderId = $request->getSession()->get('sylius_order_id');

        if (!is_scalar($orderId)) {
            return;
        }

        $order = $this->orderRepository->find($orderId);
        if (!$order instanceof OrderInterface) {
            return;
        }

        $this->_trackOrder($order);
    }

    public function trackCart(GenericEvent $event): void
    {
        if (!$this->matomo->isAvailable()) {
            return;
        }

        if (!$event->getSubject() instanceof OrderInterface) {
            return;
        }

        $this->_trackCart($event->getSubject());
    }

    public function trackOrderItem(ResourceControllerEvent $resourceControllerEvent): void
    {
        if (!$this->matomo->isAvailable()) {
            return;
        }

        $order = $this->cartContext->getCart();

        if (!$order instanceof OrderInterface) {
            return;
        }

        $this->_trackCart($order);
    }

    private function _trackCart(OrderInterface $order): void
    {
        $this->_addOrderItems($order);
        $this->matomo->client->doTrackEcommerceCartUpdate(self::formatAmount($order->getTotal()));
    }

    private function _trackOrder(OrderInterface $order): void
    {
        $this->_addOrderItems($order);
        $this->matomo->client->doTrackEcommerceOrder(
            $order->getNumber(),
            self::formatAmount($order->getTotal()),
            self::formatAmount($order->getItemsTotal()),
            self::formatAmount($order->getTaxTotal()),
            self::formatAmount($order->getShippingTotal()),
            self::formatAmount($order->getOrderPromotionTotal()),
        );
    }

    private function _addOrderItems(OrderInterface $order): void
    {
        if (count($order->getItems()) > 0) {
            foreach ($order->getItems() as $orderItem) {
                $variant = $orderItem->getVariant();
    
                $this->matomo->client->addEcommerceItem(
                    $variant->getCode(),
                    ($variant->getName() != '') ? $variant->getName() : $variant->getProduct()->getName(),
                    iterator_to_array($this->getTaxonsArray($orderItem->getProduct())),
                    self::formatAmount($orderItem->getFullDiscountedUnitPrice()),
                    $orderItem->getQuantity()
                );
            }
        }
    }
}
