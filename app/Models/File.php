<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class File extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'path', 'size', 'expires_at'];

    /**
     * Delete file.
     */
    public function deleteFile(): bool {
        Storage::delete($this->path);
        return $this->delete();
    }

}
