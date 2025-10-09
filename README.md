# Table of Contents

- [Installation](#installation)
  - [Composer](#composer)
  - [Migrations](#migrations)
- [Vehicle states](#vehicle-states)

# Installation

## Composer

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
        {
            "type": "vcs",
            "url": "git@github.com:dp-bratislava/ext-spatie-model-states-.git"
        },        
        ...,
]
```

### 2. Install composer repositories

```bash
# install package
composer require dpb/pkg-fleet
```

## Migrations

First it installs migrations for EAV package, then for fleet package itself.

```bash
# publish migrations
artisan pkg-fleet:install

# yes to create and run migrations
```

# 4. Vehicle states

Using extended spatie model states package we can define state matrix with states, transitions between states and rules for transitions.

Specific states and transitions have to be defined in application itself. Package provides just basic abstract state that should be extended accordingly.

1. Add default state class to `App/States/Fleet/Vehicle` 
2. Add default state class mapping to pkg-fleet config
#### config/pkg-fleet.php
```php 
# config/pkg-fleet.php

    /*
    |--------------------------------------------------------------------------
    | Default class mapping
    |--------------------------------------------------------------------------
    */
    'classes' => [
        'vehicle_state_class' => '\App\States\Fleet\Vehicle\VehicleState::class',
    ],    
```
3. add custom states extending default state to `App/States/Fleet/Vehicle` 
#### app/States/Fleet/Vehicle/Discarded.php
```php
<?php

namespace App\States\Fleet\Vehicle;

 class Discarded extends VehicleState
{
    public static $name = "discarded";

    public function label():string {
        return __('fleet/vehicle.states.discarded');
    }    
}
```
4. add transitions classes to `App/StateTransitions/Fleet/Vehicle` 

TO DO

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