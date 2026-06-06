<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ScanFinding extends Model
{
    protected $fillable = [
        'scan_id',
        'category',
        'title',
        'description',
        'severity',
    ];

    public function scan()
    {
        return $this->belongsTo(Scan::class);
    }
}