<?php

declare(strict_types=1);

namespace App\PartPrice;

use App\Part\Entity\PartId;
use App\PartPrice\Entity\Discount;
use App\Shared\Doctrine\Registry;
use DateTimeImmutable;
use Doctrine\ORM\AbstractQuery;
use Money\Currency;
use Money\Money;

final class PartPrice
{
    private Registry $registry;

    public function __construct(Registry $registry)
    {
        $this->registry = $registry;
    }

    public function sell(PartId $partId): Money
    {
        $price = $this->price($partId);
        $discount = $this->discount($partId);
        if (null !== $discount) {
            return $price->subtract($discount);
        }

        return $price;
    }

    public function price(PartId $partId): Money
    {
        $view = $this->registry->manager(Entity\Price::class)
            ->createQueryBuilder()
            ->select('pp')
            ->from(Entity\Price::class, 'pp')
            ->where('pp.partId = :part')
            ->setParameter('part', $partId)
            ->andWhere('pp.since <= :now')
            ->setParameter('now', new DateTimeImmutable())
            ->orderBy('pp.since', 'DESC')
            ->getQuery()
            ->setMaxResults(1)
            ->getOneOrNullResult(AbstractQuery::HYDRATE_ARRAY);

        return new Money($view['price.amount'] ?? 0, new Currency($view['price.currency.code'] ?? 'RUB'));
    }

    public function discount(PartId $partId): ?Money
    {
        $view = $this->registry->manager(Discount::class)
            ->createQueryBuilder()
            ->select('pp')
            ->from(Discount::class, 'pp')
            ->where('pp.partId = :part')
            ->setParameter('part', $partId)
            ->andWhere('pp.since <= :now')
            ->setParameter('now', new DateTimeImmutable())
            ->orderBy('pp.since', 'DESC')
            ->getQuery()
            ->setMaxResults(1)
            ->getOneOrNullResult(AbstractQuery::HYDRATE_ARRAY);

        if (null === $view) {
            return null;
        }

        return new Money($view['discount.amount'], new Currency($view['discount.currency.code']));
    }
}
