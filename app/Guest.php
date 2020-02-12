<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Guest extends Model
{
    const STATUS_COMPLETED_NO_SALE = 0;
    const STATUS_COMPLETED_SALE_MADE = 1;
    const STATUS_COMPLETED_NO_SHOW = 2;

    protected $table = 'guests';

    protected $fillable = [
        'unique',
        'first_name',
        'surname',
        'address_line_1',
        'address_line_2',
        'address_line_3',
        'address_line_4',
        'address_line_5',
        'address_line_6',
        'postcode',
        'landline',
        'mobile',
        'part_ex_vrm',
        'part_ex_vehicle',
        'part_ex_distance',
        'part_ex_settlement',
        'confirmation_letter_sent',
        'postal_contact',
        'email_contact',
        'sms_contact',
        'method',
        'last_logged_in',
        'stage'
    ];
}
