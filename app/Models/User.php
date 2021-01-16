<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles;

    const ADMIN_ROLE = 'Admin';
    const TEAM_LEADER_ROLE = 'Team Leader';
    const AGENT_ROLE = 'Agent';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'employee_id',
        'name',
        'birthday',
        'username',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function team()
    {
        return $this->belongsTo(Team::class);
    }

    public function logStatuses()
    {
        return $this->hasMany(LogStatus::class);
    }

    public function getMyAgentsAttribute()
    {
        if ($this->getRoleNames()[0] === self::AGENT_ROLE) {
            return collect([$this]);
        }

        if ($this->getRoleNames()[0] === self::TEAM_LEADER_ROLE) {
            return $this->team->users;
        }

        if ($this->getRoleNames()[0] === self::ADMIN_ROLE) {
            return self::all();
        }

        return [];
    }

    public function getLatestStatusAttribute()
    {
        $lastLogStatus = $this->logStatuses()
            ->whereNull('out')
            ->get()
            ->last();

        if ($lastLogStatus === null) {
            return 'Offline';
        }

        if ($lastLogStatus->status->key === 'check') {
            return 'Online';
        }

        return $lastLogStatus->status->name;
    }
}
