<?php

declare(strict_types=1);

namespace App\PartPrice\Entity;

use App\Part\Entity\PartId;
use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;
use Money\Money;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

/**
 * @ORM\Entity
 * @ORM\Table(name="part_price")
 */
class Price
{
    /**
     * @ORM\Id()
     * @ORM\Column(type="uuid")
     */
    private UuidInterface $id;

    /**
     * @ORM\Column(type="part_id")
     */
    private PartId $partId;

    /**
     * @ORM\Embedded(class=Money::class)
     */
    private Money $price;

    /**
     * @ORM\Column(type="datetime_immutable")
     */
    private DateTimeImmutable $since;

    public function __construct(PartId $partId, Money $price, DateTimeImmutable $since)
    {
        $this->id = Uuid::uuid6();
        $this->partId = $partId;
        $this->price = $price;
        $this->since = $since;
    }
}
