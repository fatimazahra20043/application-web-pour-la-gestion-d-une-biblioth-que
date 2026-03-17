<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'book_id',
        'status',
        'confirmation_code',
        'reservation_date',
        'return_date',
        'refusal_reason',
        'admin_notes',
        'actual_return_date',
        'book_condition',
        'start_date',
        'end_date'
    ];

    protected $casts = [
        'reservation_date' => 'date',
        'return_date' => 'date',
        'actual_return_date' => 'date',
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function book()
    {
        return $this->belongsTo(Book::class);
    }

    public function isLate()
    {
        if ($this->status !== 'confirmed' || !$this->end_date) {
            return false;
        }
        return now()->greaterThan($this->end_date);
    }

    public function getDaysLate()
    {
        if (!$this->isLate()) {
            return 0;
        }
        return now()->diffInDays($this->end_date);
    }
}
