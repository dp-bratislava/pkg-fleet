# 

# Install

### 1. Add repository sources into `composer.json` file in application root directory

```json
"repositories": [
        ...,
        {
            "type": "vcs",
            "url": "git@github.com:dp-bratislava/pkg-fleet.git"
        },        
        {
            "type": "vcs",
            "url": "git@github.com:dp-bratislava/pkg-eav.git"
        },
        ...,
]
```

### 2. Install composer repositories

```bash
# install package
composer require dpb/pkg-fleet
```

### 3. Run migrations

First it installs migrations for EAV package, then for fleet package itself.

```bash
# publish migrations
artisan pkg-fleet:install

# yes to create and run migrations
```

# WIP

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