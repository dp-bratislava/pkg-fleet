# WIP

# Table of Contents

- [Introduction](#introduction)
- [Installation](#installation)
  - [Composer](#composer)
  - [Migrations](#migrations)
- [Vehicle states](#vehicle-states)

# Introduction

Package providing datanbase structures and models for vehcicle fleet management.

# Installation

Package uses other packages under the hood

* EAV - 
* Model states - 

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

# Vehicle states

Using [spatie model states package](https://spatie.be/docs/laravel-model-states/v2/01-introduction) we can define state matrix with states, transitions between states and rules for transitions.

[Extended spatie package](https://github.com/dp-bratislava/ext-spatie-model-states) adds ...

Specific states and transitions have to be defined in application itself. Package provides just basic abstract state that should be extended accordingly.

## 1. Default state

Add default state class to `App/States/Fleet/Vehicle` 

#### app/States/Fleet/Vehicle/VehicleState.php
```php
<?php

namespace App\States\Fleet\Vehicle;

use App\StateTransitions\Fleet\Vehicle\DiscardedToInService;
use App\StateTransitions\Fleet\Vehicle\InServiceToDiscarded;
use Dpb\Package\Fleet\States\VehicleState as BaseVehicleState;
use Spatie\ModelStates\StateConfig;

abstract class VehicleState extends BaseVehicleState
{
    public static function config(): StateConfig
    {
        return parent::config()
            ->default(InService::class)
            ->allowTransition(InService::class, Discarded::class, InServiceToDiscarded::class)
            ->allowTransition(Discarded::class, InService::class, DiscardedToInService::class)
        ;
    }
}
```

## 2. Default state class mapping

Add default state class mapping to pkg-fleet config

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

## 3. Custom states

Add custom states extending default state to `App/States/Fleet/Vehicle` 

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

## 4. Transition classes

Add transitions classes to `App/StateTransitions/Fleet/Vehicle` 

```php
<?php

namespace App\StateTransitions\Fleet\Vehicle;

use Dpb\Package\Fleet\Models\Vehicle;
use App\States\Fleet\Vehicle\Discarded;
use App\States\Fleet\Vehicle\InService;
use Illuminate\Contracts\Auth\Authenticatable;
use Spatie\ModelStates\Transition;

class DiscardedToInService extends Transition
{
    public function __construct(private Vehicle $vehicle, private Authenticatable $user) {}

    public function canTransition(): bool
    {
        // $userCan = app()->runningInConsole() ? true : ($this->user->can('discard-vehicle') || $this->user->hasRole('super-admin'));
        $userCan = true;
        $validInitialState = $this->vehicle->state->equals(Discarded::class);
        return $userCan && $validInitialState;
    }

    public function handle(): ?Vehicle
    {
        if ($this->canTransition()) {

            $this->vehicle->state = new InService($this->vehicle);
            $this->vehicle->save();

            return $this->vehicle;
        }
        return null;
    }
}
```

## 5. Localisation

...

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