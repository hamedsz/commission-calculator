

## Commission Calculator

A sample laravel app for calculate commission from csv file in the command line


## Install

```bash
$ composer install
```

## Run tests
```bash
$ php artisan test
```

## How to use?

at the first you must put the csv file in the storage -> app folder
```bash
├── storage
│   ├── app
│   │   └── input.csv
```

Then run the following command:

```bash
$ php artisan commission:calculate input.csv
```

## Project structure

```bash
├── app
│   ├── Entities
│   │   └── CSV
│   │   └── DataStore
│   │   └── Deposit
│   │   └── Interfaces
│   │   └── Operation
│   │   └── Withdraw
│   │   └── Application.php
```

## Extensibility

### How to add new operation type? (deposit, withdraw, ...)

sometimes we need to add new operation type without changing project structure and implmented methods.
in my structure it can easily add!

1- create a new class and implement ```CommissionCalculatorInterface```

```php
class ExampleOperation implements OperationCalculator{
  
    public function __construct(Operation $operation, FreeCommissionUsageStore $freeCommissionUsageStore)
    {
        //TODO
    }
    
    public function main() : float{
        //TODO
    }
}
```

2- add the type name to the ```OperationTypeDetector.php```


```php
class OperationTypeDetector
{
    /** @var OperationCalculator */
    private $operationCalculator;
    private $operation;
    private $freeCommissionUsageStore;

    protected $operationTypes = [
        'deposit'  => DepositOperation::class,
        'withdraw' => WithdrawOperation::class,
        'example'  => ExampleOperation::class //add it here
    ];
}
```

Now we can implement new operation type easily without changing previous codes.

