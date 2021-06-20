<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EMGenero extends Model
{
    use HasFactory;

    /**
     * The database table used by the model.
     *
     * @var stringphp artisan make:migration create_notes_table
     */
    protected $table          = 'cat_genero';
    protected $primaryKey     = 'id';
    public    $timestamps     = false;


    /**
     * define which attributes are mass assignable (for security)
     *
     * @var array
     */
    protected $fillable = [];
}
