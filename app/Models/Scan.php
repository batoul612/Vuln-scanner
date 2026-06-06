<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Scan extends Model
{
    protected $fillable = ['target', 'type', 'status', 'user_id'];

    public function findings()
    {
        return $this->hasMany(ScanFinding::class);
    }
    public function user()
{
    return $this->belongsTo(User::class);
}
}