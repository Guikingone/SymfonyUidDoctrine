<?php

declare(strict_types=1);

namespace Tests\Guikingone\SymfonyUid\Doctrine\Ulid;

use Doctrine\ORM\EntityManager as DoctrineEntityManager;
use Doctrine\ORM\Mapping\Entity;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Uid\AbstractUid;
use Symfony\Component\Uid\Ulid;
use Guikingone\SymfonyUid\Doctrine\Ulid\UlidGenerator;

/**
 * @author Guillaume Loulier <contact@guillaumeloulier.fr>
 */
final class UlidGeneratorTest extends TestCase
{
    public function testUlidCanBeGenerated(): void
    {
        $em = new EntityManager();
        $generator = new UlidGenerator();

        $uuid = $generator->generate($em, new Entity());

        static::assertInstanceOf(AbstractUid::class, $uuid);
        static::assertInstanceOf(Ulid::class, $uuid);
    }
}

final class EntityManager extends DoctrineEntityManager
{
    public function __construct()
    {
    }
}
