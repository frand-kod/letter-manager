<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DocumentModel extends Model
{
    //
    protected $table = 'documents';

    public $incrementing = false;

    protected $keyType = 'string';

    public $timestamps = false;

    protected $fillable = [
        'id',
        'number',
        'title',
        'filename',
        'hash',
        'qr_code',
        'status',
        'uploaded_at',
    ];
}
