<?php

namespace App\Traits;

use Illuminate\Support\Facades\Log;

trait LogChangesTrait
{
    public static function bootLogChangesTrait()
    {
        static::created(function ($model) {
            Log::info('New ' . $model->getTable() . ' created with ID ' . $model->id);
        });

        static::updated(function ($model) {
            Log::info('Existing ' . $model->getTable() . ' updated with ID ' . $model->id);
        });

        static::deleted(function ($model) {
            Log::info('Existing ' . $model->getTable() . ' deleted with ID ' . $model->id);
        });
    }
}
