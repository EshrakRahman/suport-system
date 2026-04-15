<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['assigned_to', 'assigned_by', 'title', 'description', 'status', 'priority', 'comment'])]
class Ticket extends Model
{
    use HasFactory;

    const PRIORITY = [
        'Low' => 'Low',
        'Medium' => 'Medium',
        'High' => 'High'
    ];

    const STATUS = [
        'Open' => 'Open',
        'Closed' => 'Closed',
        'Archived' => 'Archived'
    ];

    public function assignedTo(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    public function assignedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_by');
    }
}
