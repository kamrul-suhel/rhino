<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Guest extends Model
{
    /**
     * Const form status field
     */
    const STATUS_PENDING = 0;
    const STATUS_CONFIRMED = 1;
    const STATUS_COMPLETED_ARRIVE = 2;
    const STATUS_COMPLETED_NO_SALE = 3;
    const STATUS_COMPLETED_SALE_MADE = 4;
    const STATUS_COMPLETED_NO_SHOW = 5;


    /**
     * Const for method field
     * @var string
     */
    const METHOD_ONLINE = 'online';
    const METHOD_TELEPHONE = 'telephone';
    const METHOD_EMAIL = 'email';
    const METHOD_SOCIAL = 'social';
    const METHOD_WALKIN = 'walkin';
    const METHOD_SMS = 'sms';
    const METHOD_PROSPECTING = 'prospecting';

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

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function appointment(){
        return $this->hasMany(Appointment::class,'guest_id', 'id');
    }
}
