<?php

namespace App\Models\PACIENTE;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class EMPaciente extends Model
{
    use HasFactory, Notifiable;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table          = 'patients';
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



    public function getBirthdayAttribute(){

        return Carbon::parse($this->attributes['birthday'])->format('d/m/Y');
    }




}
