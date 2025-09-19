# 

# Install

```bash
# install package
composer require dpb/pkg-fleet:dev-main
```

```bash
# publish migrations
artisan pkg-fleet:install

# yes to create and run migrations
```

# Package content

## Vehicle

| modul          | desc                                                              |
| -------------- | ----------------------------------------------------------------- |
| Vehicle        | List of vehicle instances. Concrete vehicles                      |
| Vehicle type   | Generic vehicle type like bus, tram, etc.                         |
| Vehicle model  | Specific vehicle model with detailed parameters                   |
| Vehicle groups | Generic tool to group vehicles                                    |
| Licence plates | List of lince plates and history of their assignments to vehicles |

## Fuel

| modul                  | desc                                                                 |
| ---------------------- | -------------------------------------------------------------------- |
| Fuel types             |                                                                      |
| Fuel consumption types | List of fuel consumption types e.g. city, out of city in winter etc. |

## TO DO

* Tires
* More fuel related functionality