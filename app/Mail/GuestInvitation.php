<?php

namespace App\Mail;

use App\Appointment;
use App\Guest;
use App\Setting;
use App\User;
use App\Vehicle;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class GuestInvitation extends Mailable
{
    use Queueable, SerializesModels;

    public $guest;
    public $trans;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($guestId, $languageId)
    {
        $this->languageId = $languageId;

        $guest = Guest::select(
            'guests.*',
            'events.id as event_id',
            'events_translation.name as event_name',
            'types_translation.name as event_type'
        )->leftJoin('events', function ($event) use ($languageId) {
            $event->on('events.id', '=', 'guests.event_id');
            $event->leftJoin('events_translation', function ($eventT) use ($languageId) {
                $eventT->on('events.id', '=', 'events_translation.event_id')
                    ->where('events_translation.language_id', $languageId);
            });

            $event->leftJoin('types', function ($type) use ($languageId) {
                $type->on('events.type_id', '=', 'types.id');
                $type->leftJoin('types_translation', function ($typeT) use ($languageId) {
                    $typeT->on('types_translation.type_id', '=', 'types.id')
                        ->where('types_translation.language_id', $languageId);
                });
            });
        })
            ->where('guests.id', $guestId)
            ->first();

        $this->guest = $guest;

        // Get translation field
        $trans = Setting::select(
            'settings.*',
            'settings_translation.*'
        )->leftJoin('settings_translation', function ($settingTranslation) use ($languageId) {
            $settingTranslation->on('settings_translation.setting_id', '=', 'settings.id')
                ->where('settings_translation.language_id', $languageId);
        })
            ->orderBy('settings.identifier')
            ->pluck('translation', 'identifier');

        $this->trans = $trans;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from(env('MAIL_SENDER'))
            ->to($this->guest->email)
            ->view('emails.guest.guest_invitation');
    }
}
