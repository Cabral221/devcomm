<?php

namespace App\Domains\Imputation\Models;

use App\Models\Service;
use Illuminate\Database\Eloquent\Model;
use Database\Factories\ImputationFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Imputation extends Model
{
    use HasFactory;

    protected $appends = ['agent'];

    protected $fillable = ['sick_name', 'first_name', 'last_name',
                            'email', 'phone', 'cni', 'registration_number',
                            'service_id', 'fonction', 'file', 'status', 'validation'];

    public const LOAD_EMPLOYE = 0.2;
    public const LOAD_EMPLOYER = 0.8;

    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        static::creating(function ($imputation) {
            $imputation->phone =  (int) (221 . $imputation->phone);
        });
    }

    public function getAgentAttribute() : String
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    /**
     * Scope a query to only include active users.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return void
     */
    public function scopeActive($query)
    {
        $query->where('validation', 1);
    }

     /**
     * Create a new factory instance for the model.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    protected static function newFactory()
    {
        return ImputationFactory::new();
    }


    public function service()
    {
        return $this->belongsTo(service::class, 'service_id');
    }
}
