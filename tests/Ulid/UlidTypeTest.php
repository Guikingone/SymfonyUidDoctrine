<?php

declare(strict_types=1);

namespace Tests\Guikingone\SymfonyUid\Doctrine\Ulid;

use Doctrine\DBAL\DBALException;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;
use Guikingone\SymfonyUid\Doctrine\Ulid\UlidType;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Uid\Ulid;

/**
 * @author Guillaume Loulier <contact@guillaumeloulier.fr>
 */
final class UlidTypeTest extends TestCase
{
    /**
     * {@inheritdoc}
     */
    protected function setUp(): void
    {
        if (!Type::hasType('ulid')) {
            Type::addType('ulid', UlidType::class);
        }
    }

    public function testTypeNameIsSet(): void
    {
        static::assertSame('ulid', Type::getType('ulid')->getName());
    }

    public function testTypeCannotBeConvertedToDatabaseValueWhenUsingNull(): void
    {
        $platform = $this->createMock(AbstractPlatform::class);

        $value = Type::getType('ulid')->convertToDatabaseValue(null, $platform);
        static::assertNull($value);
    }

    public function testTypeCannotBeConvertedToDatabaseValueWhenUsingAnEmptyString(): void
    {
        $platform = $this->createMock(AbstractPlatform::class);

        $value = Type::getType('ulid')->convertToDatabaseValue('', $platform);
        static::assertNull($value);
    }

    public function testTypeCannotBeConvertedToDatabaseValueWhenUsingAnInvalidString(): void
    {
        $platform = $this->createMock(AbstractPlatform::class);

        static::expectException(DBALException::class);
        Type::getType('ulid')->convertToDatabaseValue('foo', $platform);
    }

    public function testTypeCanBeConvertedToDatabaseValueWhenUsingUuid(): void
    {
        $platform = $this->createMock(AbstractPlatform::class);

        $ulid = new Ulid();

        $value = Type::getType('ulid')->convertToDatabaseValue($ulid, $platform);
        static::assertSame($ulid->toRfc4122(), $value);
    }

    public function testTypeCannotBeConvertedToPHPValueWhenUsingNull(): void
    {
        $platform = $this->createMock(AbstractPlatform::class);

        $value = Type::getType('ulid')->convertToPHPValue(null, $platform);
        static::assertNull($value);
    }

    public function testTypeCannotBeConvertedToPHPValueWhenUsingAnEmptyString(): void
    {
        $platform = $this->createMock(AbstractPlatform::class);

        $value = Type::getType('ulid')->convertToPHPValue('', $platform);
        static::assertNull($value);
    }

    public function testTypeCannotBeConvertedToPHPValueWhenUsingUlid(): void
    {
        $platform = $this->createMock(AbstractPlatform::class);

        $ulid = new Ulid();

        static::expectException(DBALException::class);
        Type::getType('ulid')->convertToPHPValue($ulid->toRfc4122(), $platform);
    }

    public function testTypeCanBeConvertedToPHPValueWhenUsingValidString(): void
    {
        $platform = $this->createMock(AbstractPlatform::class);

        $ulid = new Ulid();

        $entryValue = substr($ulid->toRfc4122(), 0, 26);

        $value = Type::getType('ulid')->convertToPHPValue(strtr($entryValue, ['-' => '0']), $platform);
        static::assertInstanceOf(Ulid::class, $value);
    }

    public function testTypeCanBeConvertedToPHPValueWhenUsingAnUlidObject(): void
    {
        $platform = $this->createMock(AbstractPlatform::class);

        $ulid = new Ulid();

        $value = Type::getType('ulid')->convertToPHPValue($ulid, $platform);
        static::assertInstanceOf(Ulid::class, $value);
    }
}
