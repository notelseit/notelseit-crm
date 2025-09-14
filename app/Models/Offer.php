<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Offer extends Model
{
    protected $fillable = [
        'client_id', 'titolo', 'descrizione', 'importo', 'stato', 'data'
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }
}