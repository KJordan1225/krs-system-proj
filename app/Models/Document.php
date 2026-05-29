<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    protected $fillable = [
        'title',
        'category',
        'document_type',
        'tags',
        'file_name',
        'file_path',
        'file_mime',
        'file_size',
        'version',
        'effective_date',
        'expiration_date',
        'approval_status',
        'uploaded_by',
        'description',
    ];

    protected $casts = [
        'effective_date' => 'date',
        'expiration_date' => 'date',
    ];

    public function fileSizeFormatted(): string
    {
        if (! $this->file_size) {
            return 'N/A';
        }

        if ($this->file_size >= 1048576) {
            return round($this->file_size / 1048576, 2) . ' MB';
        }

        return round($this->file_size / 1024, 2) . ' KB';
    }

    public function isExpired(): bool
    {
        return $this->expiration_date && $this->expiration_date->isPast();
    }
}