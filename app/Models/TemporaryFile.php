<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TemporaryFile extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'temporary_file';

    protected $fillable = [
        'folder',
        'nama_file',
        'nama_file_unformatted',
        'size',
        'extension'
    ];
}
