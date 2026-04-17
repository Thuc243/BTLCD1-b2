<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Subject extends Model
{
    protected $fillable = ['subject_name'];

    /**
     * Bài 3: Quan hệ n-n → Một môn học có nhiều sinh viên đăng ký
     */
    public function students(): BelongsToMany
    {
        return $this->belongsToMany(Student::class, 'student_subject')
                    ->withPivot(['score', 'registered_at']);
    }
}
