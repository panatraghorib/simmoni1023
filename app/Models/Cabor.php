<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cabor extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'cabor_name',
        'initial',
        'logo',
        'description',
    ];

    protected $table = null;

    public function __construct($attributes = [])
    {
        $prefix = config('apptra.database.prefix');
        $this->table = $prefix . 'cabor';
        parent::__construct($attributes);
    }

    public function users(): HasMany
    {
        return $this->hasMany(User::class, 'cabor_id');
    }
}
