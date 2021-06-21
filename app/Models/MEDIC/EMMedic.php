<?php

namespace App\Models\MEDIC;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class EMMedic extends Model
{
    use HasFactory, Notifiable;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table          = 'medics';
    protected $primaryKey     = 'id';
    public    $timestamps     = false;


    /**
     * define which attributes are mass assignable (for security)
     *
     * @var array
     */
    protected $fillable = [];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [];



    public function getFullName(){
        return $this->getAttribute('name') . ' '.$this->getAttribute('lastname');
    }

}
