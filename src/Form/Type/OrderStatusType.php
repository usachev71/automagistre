<?php

declare(strict_types=1);

namespace App\Form\Type;

use App\Order\Enum\OrderStatus;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * @author Konstantin Grachev <me@grachevko.ru>
 */
final class OrderStatusType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'choices' => OrderStatus::all([OrderStatus::closed()], true),
            'choice_label' => fn (OrderStatus $status) => $status->toName(),
            'choice_value' => fn (OrderStatus $status) => $status->toId(),
        ]);
    }

    public function getParent(): ?string
    {
        return ChoiceType::class;
    }
}
