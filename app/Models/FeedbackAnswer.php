<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FeedbackAnswer extends Model
{
    use HasFactory;

    protected $fillable = [
        'feedback_id',
        'question_id',
        'answer',
    ];

    public function question()
    {
        return $this->belongsTo(Question::class);
    }

    public function feedback()
    {
        return $this->belongsTo(Feedback::class);
    }
}
