<?php

namespace Application\Actions\Cup\Publication;

use Application\Actions\Action;
use DateTime;
use Exception;
use Psr\Container\ContainerInterface;

abstract class PublicationAction extends Action
{
    /**
     * @var \Doctrine\Common\Persistence\ObjectRepository|\Doctrine\ORM\EntityRepository
     */
    protected $publicationRepository;

    /**
     * @var \Doctrine\Common\Persistence\ObjectRepository|\Doctrine\ORM\EntityRepository
     */
    protected $categoryRepository;

    /**
     * @inheritDoc
     */
    public function __construct(ContainerInterface $container)
    {
        parent::__construct($container);

        $this->publicationRepository = $this->entityManager->getRepository(\Domain\Entities\Publication::class);
        $this->categoryRepository = $this->entityManager->getRepository(\Domain\Entities\Publication\Category::class);
    }
}