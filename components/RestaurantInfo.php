<?php

namespace app\components;

use yii\base\Component;

class RestaurantInfo extends Component
{
    public string $name = 'Yummy Red';
    public string $phone = '+60 12-345 6789';
    public string $email = 'hello@yummyred.test';
    public string $address = 'Kuala Lumpur, Malaysia';
    public string $openingHours = 'Mon-Sat: 11AM - 11PM';

    public function getReservationSummary(): string
    {
        return $this->phone . ' | ' . $this->email;
    }
}
