# DTO

**Data Transfer Object**

- [DTO](#dto)
  - [Installation](#installation)
  - [Usage](#usage)
    - [Object](#object)
    - [Map](#map)
    - [Collection](#collection)

***

## Installation

Install *dto* via Composer:

```bash
composer require ali-eltaweel/dto
```

## Usage

### Object

Data transfer objects have well defined fields and types.

```php
use DTO\DataTransferObject;

class InputDirectory extends DataTransferObject {

  public final function __construct(string $path, float $maxDepth = 32, bool $followSymlinks = true) {

    parent::__construct(func_get_args());
  }
}
```

```php
$inputDirectory = InputDirectory::fromArray([ 'path' => '/var/www/html' ]);
```

### Map

Data transfer maps - on the other hands - don't have well defined fields and accept all fields.

```php
use DTO\DataTransferMap;

class LookupTable extends DataTransferMap {
}
```

Maps can enforce a type for all fields via the `__v` method:

```php
use DTO\DataTransferMap;

class LookupTable extends DataTransferMap {

  function __v(string $field) {}
}
```

### Collection

Data transfer collections are used to hold multiple data transfer objects.

```php
use DTO\DataTransferCollection;

class InputDirectories extends DataTransferCollection {

  function __v(InputDirectory $field) {}
}
```
