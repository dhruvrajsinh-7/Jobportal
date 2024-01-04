<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\Job;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Employer extends Model
{
    use HasFactory;
    protected $fillable = ['company_name'];
    public function jobs(): HasMany
    {
        return $this->hasMany(Job::class);
    }
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
