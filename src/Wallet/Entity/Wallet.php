<?php

declare(strict_types=1);

namespace App\Wallet\Entity;

use App\Payment\Transactional;
use App\Shared\Doctrine\ORM\Mapping\Traits\Identity;
use Doctrine\ORM\Mapping as ORM;
use Money\Currency;

/**
 * @ORM\Entity
 */
class Wallet implements Transactional
{
    use Identity;

    /**
     * @ORM\Column
     */
    public string $name;

    /**
     * @ORM\Embedded(class=Currency::class)
     */
    public Currency $currency;

    /**
     * @ORM\Column(type="boolean")
     */
    public bool $useInIncome;

    /**
     * @ORM\Column(type="boolean")
     */
    public bool $useInOrder;

    /**
     * @ORM\Column(type="boolean")
     */
    public bool $showInLayout;

    /**
     * @ORM\Column(type="boolean")
     */
    public bool $defaultInManualTransaction = false;

    public function __construct(
        string $name,
        Currency $currency,
        bool $useInIncome = false,
        bool $useInOrder = false,
        bool $showInLayout = true
    ) {
        $this->name = $name;
        $this->currency = $currency;
        $this->useInIncome = $useInIncome;
        $this->useInOrder = $useInOrder;
        $this->showInLayout = $showInLayout;
    }

    public function __toString(): string
    {
        return $this->name;
    }

    public function getTransactionClass(): string
    {
        return WalletTransaction::class;
    }
}
