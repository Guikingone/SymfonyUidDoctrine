<?php

declare(strict_types=1);

namespace Tests\Guikingone\SymfonyUid\Uuid;

use Doctrine\ORM\EntityManager as DoctrineEntityManager;
use Doctrine\ORM\Mapping\Entity;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Uid\AbstractUid;
use Symfony\Component\Uid\Uuid;
use Guikingone\SymfonyUid\Doctrine\Uuid\UuidGenerator;

/**
 * @author Guillaume Loulier <contact@guillaumeloulier.fr>
 */
final class UuidGeneratorTest extends TestCase
{
    public function testUuidCanBeGenerated(): void
    {
        $em = new EntityManager();
        $generator = new UuidGenerator();

        $uuid = $generator->generate($em, new Entity());

        static::assertInstanceOf(AbstractUid::class, $uuid);
        static::assertInstanceOf(Uuid::class, $uuid);
    }
}

final class EntityManager extends DoctrineEntityManager
{
    public function __construct()
    {
    }
}
