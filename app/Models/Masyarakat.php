<?php

namespace App\Models;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Masyarakat extends Model implements Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'masyarakat';

    protected $fillable = [
        'username',
        'password',
        'alamat',
        'kota',
        'login_token',
    ];

    /*

'getAuthIdentifierName', 'getAuthIdentifier', 'getAuthPassword', 'getRememberToken', 'setRememberToken', 'getRememberTokenName'


    */

    public function getAuthIdentifierName()
    {
        return 'id';
    }

    public function getAuthIdentifier()
    {
        return $this->getKey();
    }

    public function getAuthPassword()
    {
        return $this->password;
    }

    public function getRememberToken()
    {
        return $this->login_token;
    }

    public function getRememberTokenName()
    {
        return "login_token";
    }

    public function setRememberToken($value)
    {
        return $this->login_token = $value;
    }
}
