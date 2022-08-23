<?php

namespace Ikuzo\SyliusMatomoPlugin\Form\Extension;

use Sylius\Bundle\ChannelBundle\Form\Type\ChannelType;
use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;


final class ChannelTypeExtension extends AbstractTypeExtension
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('matomoActive', CheckboxType::class, [
                'required' => true,
                'label' => 'ikuzo_matomo.form.active',
            ])
            ->add('matomoUrl', UrlType::class, [
                'required' => false,
                'label' => 'ikuzo_matomo.form.url',
            ])
            ->add('matomoWebsiteId', IntegerType::class, [
                'required' => false,
                'label' => 'ikuzo_matomo.form.website_id',
            ])
            ->add('matomoToken', TextType::class, [
                'required' => false,
                'label' => 'ikuzo_matomo.form.token',
            ])
        ;
    }

    public static function getExtendedTypes(): iterable
    {
        return [ChannelType::class];
    }
}