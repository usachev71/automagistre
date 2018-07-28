<?php

declare(strict_types=1);

namespace App\Controller\EasyAdmin;

use App\Entity\User;
use App\Request\EntityTransformer;
use Doctrine\ORM\QueryBuilder;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AdminController;
use Money\Formatter\DecimalMoneyFormatter;
use Money\Money;
use Money\MoneyFormatter;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;

/**
 * @method User getUser()
 *
 * @author Konstantin Grachev <me@grachevko.ru>
 */
abstract class AbstractController extends AdminController
{
    /**
     * @var EntityTransformer
     */
    private $entityTransformer;

    /**
     * @var MoneyFormatter
     */
    private $moneyFormatter;

    /**
     * @var DecimalMoneyFormatter
     */
    private $decimalMoneyFormatter;

    /**
     * @required
     */
    public function setEntityTransformer(EntityTransformer $entityTransformer): void
    {
        $this->entityTransformer = $entityTransformer;
    }

    /**
     * @required
     */
    public function setMoneyFormatter(MoneyFormatter $moneyFormatter): void
    {
        $this->moneyFormatter = $moneyFormatter;
    }

    /**
     * @required
     */
    public function setDecimalMoneyFormatter(DecimalMoneyFormatter $moneyFormatter): void
    {
        $this->decimalMoneyFormatter = $moneyFormatter;
    }

    protected function formatMoney(Money $money, bool $decimal = false): string
    {
        $formatter = $decimal ? $this->decimalMoneyFormatter : $this->moneyFormatter;

        return $formatter->format($money);
    }

    protected function redirectToEasyPath(
        object $entity,
        string $action,
        array $parameters = [],
        int $status = 302
    ): RedirectResponse {
        return $this->redirect($this->generateEasyPath($entity, $action, $parameters), $status);
    }

    protected function generateEasyPath(object $entity, string $action, array $parameters = []): string
    {
        return $this->container->get('easyadmin.router')->generate($entity, $action, $parameters);
    }

    protected function redirectToReferrer(): RedirectResponse
    {
        $refererUrl = trim($this->request->query->get('referer', ''));

        return '' !== $refererUrl
            ? $this->redirect(
                urldecode($refererUrl)
            )
            : parent::redirectToReferrer();
    }

    protected function getEntity(string $class): ?object
    {
        $entity = $this->entityTransformer->reverseTransform($class);

        if (null === $entity) {
            $entity = $this->request->attributes->get('easyadmin')['item'];
        }

        if (!$entity instanceof $class) {
            return null;
        }

        return $entity;
    }

    /**
     * {@inheritdoc}
     */
    protected function isActionAllowed($actionName): bool
    {
        return parent::isActionAllowed($actionName);
    }

    /**
     * {@inheritdoc}
     */
    protected function createListQueryBuilder(
        $entityClass,
        $sortDirection,
        $sortField = null,
        $dqlFilter = null
    ): QueryBuilder {
        return parent::createListQueryBuilder($entityClass, $sortDirection, $sortField, $dqlFilter);
    }

    /**
     * {@inheritdoc}
     */
    protected function createEntityForm($entity, array $entityProperties, $view): FormInterface
    {
        return parent::createEntityForm($entity, $entityProperties, $view);
    }

    /**
     * {@inheritdoc}
     */
    protected function createSearchQueryBuilder(
        $entityClass,
        $searchQuery,
        array $searchableFields,
        $sortField = null,
        $sortDirection = null,
        $dqlFilter = null
    ): QueryBuilder {
        return parent::createSearchQueryBuilder(
            $entityClass,
            $searchQuery,
            $searchableFields,
            $sortField,
            $sortDirection,
            $dqlFilter
        );
    }

    /**
     * {@inheritdoc}
     */
    protected function renderTemplate($actionName, $templatePath, array $parameters = []): Response
    {
        return parent::renderTemplate($actionName, $templatePath, $parameters);
    }

    /**
     * {@inheritdoc}
     */
    protected function findBy(
        $entityClass,
        $searchQuery,
        array $searchableFields,
        $page = 1,
        $maxPerPage = 15,
        $sortField = null,
        $sortDirection = null,
        $dqlFilter = null
    ) {
        return parent::findBy($entityClass, $searchQuery, $searchableFields, $page, $maxPerPage, $sortField, $sortDirection, $dqlFilter);
    }

    /**
     * {@inheritdoc}
     */
    protected function createDeleteForm($entityName, $entityId): FormInterface
    {
        return parent::createDeleteForm($entityName, $entityId);
    }

    /**
     * {@inheritdoc}
     */
    protected function createEntityFormBuilder($entity, $view): FormBuilderInterface
    {
        return parent::createEntityFormBuilder($entity, $view);
    }
}
