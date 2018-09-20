<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $fillable = [
        'nick',
        'password',
        'gold',
        'food',
    ];

    public function villages()
    {
        return $this->hasMany(Village::class);
    }

    /**
     * @param \App\Models\Report $report
     * @return boolean
     */
    public function ownerOfReport(Report $reportToCheck): bool
    {
        foreach ($this->villages as $village) {
            foreach ($village->reports as $report) {
                if ($reportToCheck->id === $report->id) {
                    return true;
                }
            }
        }

        return false;
    }
}
