<?php

namespace App\Models;

use App\Models\Scopes\OrderByNameScope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Student extends Model
{
    protected $fillable = ['student_name', 'class_id', 'active'];

    /**
     * Bài 5: Global Scope - Tự động sắp xếp theo tên tăng dần
     */
    protected static function booted(): void
    {
        static::addGlobalScope(new OrderByNameScope);
    }

    // ==================== QUAN HỆ (Bài 3) ====================

    /**
     * Quan hệ n-1 → Sinh viên thuộc về một lớp
     */
    public function classroom(): BelongsTo
    {
        return $this->belongsTo(Classroom::class, 'class_id');
    }

    /**
     * Quan hệ n-n → Sinh viên đăng ký nhiều môn học
     */
    public function subjects(): BelongsToMany
    {
        return $this->belongsToMany(Subject::class, 'student_subject')
                    ->withPivot(['score', 'registered_at']);
    }

    // ==================== LOCAL SCOPE (Bài 5) ====================

    /**
     * Local Scope: Lấy sinh viên có trạng thái active
     */
    public function scopeActive(Builder $query): Builder
    {
        return $query->where('active', true);
    }
}
