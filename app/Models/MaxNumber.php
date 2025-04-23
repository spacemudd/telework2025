<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MaxNumber extends Model
{
    protected $fillable = [
        'name',
        'value',
    ];

    /**
     * Create a new number for a prefix.
     *
     * @param     $string
     * @param int $startFrom
     * @param int $digits
     *
     * @return MaxNumber
     */
    public static function generateForPrefix($string, int $startFrom = 0, int $digits = 4): string
    {
        $maxNumber = MaxNumber::lockForUpdate()->firstOrCreate([
            'name' => $string,
        ], [
            'value' => $startFrom,
        ]);

        $number = ++$maxNumber->value;
        $maxNumber->value = $number;
        $maxNumber->save();

        $prependDigits = sprintf('%0' . $digits . 'd', $number);

        return $prependDigits;
    }
}
