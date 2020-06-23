<?php

declare(strict_types=1);

namespace Tests\Guikingone\SymfonyUid\Doctrine\Uuid;

use Doctrine\DBAL\DBALException;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;
use Guikingone\SymfonyUid\Doctrine\Uuid\UuidType;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Uid\Uuid;

/**
 * @author Guillaume Loulier <contact@guillaumeloulier.fr>
 */
final class UuidTypeTest extends TestCase
{
    protected function setUp(): void
    {
        if (!Type::hasType('uuid')) {
            Type::addType('uuid', UuidType::class);
        }
    }

    public function testTypeNameIsSet(): void
    {
        static::assertSame('uuid', Type::getType('uuid')->getName());
    }

    public function testTypeCannotBeConvertedToDatabaseValueWhenUsingNull(): void
    {
        $platform = $this->createMock(AbstractPlatform::class);

        $value = Type::getType('uuid')->convertToDatabaseValue(null, $platform);
        static::assertNull($value);
    }

    public function testTypeCannotBeConvertedToDatabaseValueWhenUsingAnEmptyString(): void
    {
        $platform = $this->createMock(AbstractPlatform::class);

        $value = Type::getType('uuid')->convertToDatabaseValue('', $platform);
        static::assertNull($value);
    }

    public function testTypeCannotBeConvertedToDatabaseValueWhenUsingAnInvalidString(): void
    {
        $platform = $this->createMock(AbstractPlatform::class);

        static::expectException(DBALException::class);
        Type::getType('uuid')->convertToDatabaseValue('foo', $platform);
    }

    public function testTypeCanBeConvertedToDatabaseValueWhenUsingUuid(): void
    {
        $platform = $this->createMock(AbstractPlatform::class);

        $uuid = Uuid::v4();

        $value = Type::getType('uuid')->convertToDatabaseValue($uuid, $platform);
        static::assertSame($uuid->toRfc4122(), $value);
    }

    public function testTypeCannotBeConvertedToPHPValueWhenUsingNull(): void
    {
        $platform = $this->createMock(AbstractPlatform::class);

        $value = Type::getType('uuid')->convertToPHPValue(null, $platform);
        static::assertNull($value);
    }

    public function testTypeCannotBeConvertedToPHPValueWhenUsingAnEmptyString(): void
    {
        $platform = $this->createMock(AbstractPlatform::class);

        $value = Type::getType('uuid')->convertToPHPValue('', $platform);
        static::assertNull($value);
    }

    public function testTypeCannotBeConvertedToPHPValueWhenUsingInvalidUuid(): void
    {
        $platform = $this->createMock(AbstractPlatform::class);

        $uuid = Uuid::v4();

        static::expectException(DBALException::class);
        Type::getType('uuid')->convertToPHPValue(substr($uuid->toRfc4122(), 0, 10), $platform);
    }

    public function testTypeCanBeConvertedToPHPValueWhenUsingUuid(): void
    {
        $platform = $this->createMock(AbstractPlatform::class);

        $uuid = Uuid::v4();

        $value = Type::getType('uuid')->convertToPHPValue($uuid->toRfc4122(), $platform);
        static::assertInstanceOf(Uuid::class, $value);
    }
}
