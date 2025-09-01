<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Issue extends Model
{
    protected $fillable = [
        'project_id',
        'title',
        'description',
        'status',
        'priority',
    ];

    // Relationships
    public function project() {
        return $this->belongsTo(Project::class);
    }
    public function members()
    {
        return $this->belongsToMany(User::class, 'issue_user');
    }
    public function tags() {
        return $this->belongsToMany(Tag::class);
    }
    public function comments() {
        return $this->hasMany(Comment::class);
    }
    // 🔹 Scopes
    public function scopeStatus($query, $status)
    {
        if ($status) {
            return $query->where('status', $status);
        }
        return $query;
    }

    public function scopePriority($query, $priority)
    {
        if ($priority) {
            return $query->where('priority', $priority);
        }
        return $query;
    }

    public function scopeWithTag($query, $tagId)
    {
        if ($tagId) {
            return $query->whereHas('tags', fn($q) => $q->where('tags.id', $tagId));
        }
        return $query;
    }

    public function scopeSearch($query, $term)
    {
        if ($term) {
            return $query->where('title', 'like', "%{$term}%")
                         ->orWhere('description', 'like', "%{$term}%");
        }
        return $query;
    }
}

