<?php

declare(strict_types=1);

namespace Guikingone\SymfonyUid\Doctrine\Ulid;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Id\AbstractIdGenerator;
use Symfony\Component\Uid\Ulid;

/**
 * @author Guillaume Loulier <contact@guillaumeloulier.fr>
 */
final class UlidGenerator extends AbstractIdGenerator
{
    /**
     * {@inheritdoc}
     */
    public function generate(EntityManager $em, $entity)
    {
        return new Ulid();
    }
}
