<?php

namespace App\Models\APPOINTMENTS;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class EMAppointment extends Model
{
    use HasFactory, Notifiable;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table          = 'appointments';
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






    /*****  RELACIONES CON OTROS MODELOS *****/

    /**
     * @return \App\Models\PACIENTE\EMPaciente
     */
    public function patient(){
        return $this->hasone('App\Models\PACIENTE\EMPaciente','id','patient_id');
    }

    /**
     * @return \App\Models\MEDIC\EMMEdic
     */
    public function medic(){
        return $this->hasone('App\Models\MEDIC\EMMEdic','id','medic_id');
    }




    public function getDateAttribute(){

        return Carbon::parse($this->attributes['date'])->format('d/m/Y');
    }

    public function getHour1Attribute(){

        return Carbon::parse($this->attributes['date'])->format('H:i');
    }

    public function getHour2Attribute(){

        return Carbon::parse($this->attributes['date'])->format('H:i');
    }

}
