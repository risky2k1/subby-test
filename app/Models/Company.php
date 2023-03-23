<?php

namespace App\Models;

use Bpuig\Subby\Exceptions\InvalidPlanSubscription;
use Bpuig\Subby\Traits\HasSubscriptions;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;
    use HasSubscriptions;

    /**
     * @throws InvalidPlanSubscription
     */
    public function hasActiveSubscription()
    {

        return $this->subscriptions();

    }
}
