# guikingone/symfony-uid-doctrine

![SymfonyUidDoctrine](https://github.com/Guikingone/SymfonyUidDoctrine/workflows/SymfonyUidDoctrine/badge.svg?branch=master)
![SymfonyUidDoctrine - Configuration](https://github.com/Guikingone/SymfonyUidDoctrine/workflows/SymfonyUidDoctrine%20-%20Configuration/badge.svg?branch=master)

The `guikingone/symfony-uid-doctrine` aim to provide the support of `Symfony/Uid` as a `Doctrine` type.

## Installation

Consider using `Packagist` and `Composer` when installing the following project:

```bash
composer require guikingone/symfony-uid-doctrine
```

## Configuration

### Uuid

```php
Doctrine\DBAL\Types\Type::addType('uuid', Guikingone\SymfonyUid\Doctrine\Uuid\UuidType::class);
```

```yaml
# config/packages/doctrine.yaml
doctrine:
    dbal:
        types:
            uuid: Guikingone\SymfonyUid\Doctrine\Uuid\UuidType
```

### Ulid

```php
Doctrine\DBAL\Types\Type::addType('ulid', Guikingone\SymfonyUid\Doctrine\Ulid\UlidType::class);
```

```yaml
# config/packages/doctrine.yaml
doctrine:
    dbal:
        types:
            ulid: Guikingone\SymfonyUid\Doctrine\Ulid\UlidType
```

## Usage

### Uuid

```php
use Doctrine\ORM\Mapping as ORM;
use Guikingone\SymfonyUid\Doctrine\Uuid\UuidGenerator;

/**
 * @ORM\Entity
 * @ORM\Table(name="posts")
 */
class Post
{
    /**
     * @var Symfony\Component\Uid\Uuid
     *
     * @ORM\Id
     * @ORM\Column(type="uuid", unique=true)
     * @ORM\GeneratedValue(strategy="CUSTOM")
     * @ORM\CustomIdGenerator(class=UuidGenerator::class)
     */
    protected $id;

    public function getId(): Uuid
    {
        return $this->id;
    }
}
```

If you don't want to use the generator, consider using the `__construct()` method:

```php
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\Uuid;

/**
 * @ORM\Entity
 * @ORM\Table(name="posts")
 */
class Post
{
    /**
     * @var Symfony\Component\Uid\Uuid
     *
     * @ORM\Id
     * @ORM\Column(type="uuid", unique=true)
     */
    protected $id;

    public function __construct() 
    {
        $this->id = Uuid::v4();
    }

    public function getId(): Uuid
    {
        return $this->id;
    }
}
```

### Ulid

```php
use Doctrine\ORM\Mapping as ORM;
use Guikingone\SymfonyUid\Doctrine\Ulid\UlidGenerator;

/**
 * @ORM\Entity
 * @ORM\Table(name="posts")
 */
class Post
{
    /**
     * @var Symfony\Component\Uid\Ulid
     *
     * @ORM\Id
     * @ORM\Column(type="ulid", unique=true)
     * @ORM\GeneratedValue(strategy="CUSTOM")
     * @ORM\CustomIdGenerator(class=UlidGenerator::class)
     */
    protected $id;

    public function getId(): Ulid
    {
        return $this->id;
    }
}
```

If you don't want to use the generator, consider using the `__construct()` method:

```php
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\Ulid;

/**
 * @ORM\Entity
 * @ORM\Table(name="posts")
 */
class Post
{
    /**
     * @var Symfony\Component\Uid\Ulid
     *
     * @ORM\Id
     * @ORM\Column(type="ulid", unique=true)
     */
    protected $id;

    public function __construct() 
    {
        $this->id = new Ulid();
    }

    public function getId(): Ulid
    {
        return $this->id;
    }
}
```

## Contributing

Contributions are welcome! Please read [CONTRIBUTING](.github/CONTRIBUTING.md) for details.
