<?php

namespace App;

use App\Traits\HasSettings;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasSettings, HasApiTokens, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];


    public function getStormAttribute(){
        return  $this->settings()->get('storm');
    }

    public function getRainAttribute(){
        return  $this->settings()->get('rain');
    }

    public function getSnowAttribute(){
        return  $this->settings()->get('snow');
    }

    public function getDrizzleAttribute(){
        return  $this->settings()->get('drizzle');
    }
    public function getAtmosphereAttribute(){
        return  $this->settings()->get('atmosphere');
    }


}
