<?php

declare(strict_types=1);

namespace Guikingone\SymfonyUid\Doctrine\Ulid;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\ConversionException;
use Doctrine\DBAL\Types\GuidType;
use Symfony\Component\Uid\Ulid;
use Throwable;

/**
 * @author Guillaume Loulier <contact@guillaumeloulier.fr>
 */
final class UlidType extends GuidType
{
    private const NAME = 'ulid';

    /**
     * {@inheritdoc}
     */
    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        if (null === $value || '' === $value) {
            return null;
        }

        if ($value instanceof Ulid) {
            return $value->toRfc4122();
        }

        throw ConversionException::conversionFailed($value, self::NAME);
    }

    /**
     * {@inheritdoc}
     */
    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        if (null === $value || '' === $value) {
            return null;
        }

        if (!Ulid::isValid($value)) {
            throw ConversionException::conversionFailed($value, self::NAME);
        }

        return Ulid::fromString($value);
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return self::NAME;
    }
}
