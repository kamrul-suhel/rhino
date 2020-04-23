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

class GuestConfirmed extends Mailable
{
    use Queueable, SerializesModels;

    public $guest;
    public $trans;
    public $languageId;
    public $vehicles;
    public $user;
    public $sendTo;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($guestId, $languageId, $sendTo = 'guest')
    {
        $this->languageId = $languageId;
        $this->sendTo = $sendTo;

        $guest = Guest::select(
            'guests.*',
            'events.id as event_id',
            'events_translation.name as event_name',
            'types_translation.name as event_type',
            'appointments.id as appointment_id',
            'appointments.user_id',
            'appointments.start as appointment_start',
            'appointments.end as appointment_end'
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
            ->leftJoin('appointments', function ($appointment) use ($languageId) {
                $appointment->on('guests.id', '=', 'appointments.guest_id')
                    ->where('appointments.status', Appointment::APPOINTMENT_CONFIRMED);
            })
            ->where('guests.id', $guestId)
            ->first();



        if ($this->sendTo != 'guest') {
            // Get All vehicles
            $vehicles = Vehicle::select(
                'vehicles.*',
                'vehicles_translation.model as vehicle_name',
                'vehicles_translation.language_id',
                'appointment_vehicles.*'
            )->leftJoin('vehicles_translation', function ($vehicleT) {
                $vehicleT->on('vehicles_translation.vehicle_id', '=', 'vehicles.id')
                    ->where('vehicles_translation.language_id', $this->languageId);
            })->leftJoin('appointment_vehicles', function ($appointmentVehicle) {
                $appointmentVehicle->on('vehicles.id', '=', 'appointment_vehicles.vehicle_id');
            })
                ->where('appointment_vehicles.appointment_id', $guest->appointment_id)
                ->get();
            $this->vehicles = $vehicles;

            if($sendTo == 'saleExecutive'){
                // get Sales executive data
                $salesExecutive = User::find($guest->user_id);
                    if (!$salesExecutive){
                        return;
                    }
                $this->user = $salesExecutive;
            }

            if($sendTo == 'dealerManager'){
                // Get managers for this events.
                $manager = User::select(
                    'users.email',
                    'users.firstname',
                    'users.surname',
                    'users.id',
                    'users.level'
                )->leftJoin('dealership_user', 'dealership_user.user_id', '=', 'users.id')
                ->leftJoin('events', 'dealership_user.dealership_id', '=', 'events.dealership_id')    
                ->where('events.id', $guest->event_id)
                    ->where('users.level', '=', 'dealership')
                    ->first();
                
                    if (!$manager){
                        return;
                    }

                $this->user = $manager;
            }

        }

        // Convert appointment time
        $appointmentStart = Carbon::create($guest->appointment_start);
        $appointmentDate = $appointmentStart->isoFormat('dddd D, YYYY');
        $appointmentStart = $appointmentStart->format('H:i');

        $appointmentEnd = Carbon::create($guest->appointment_end);
        $appointmentEnd = $appointmentEnd->format('H:i');

        $guest->appointment_start = $appointmentStart;
        $guest->appointment_date = $appointmentDate;
        $guest->appointment_end = $appointmentEnd;

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
        switch ($this->sendTo) {
            case 'guest':
                return $this->from(env('MAIL_SENDER'))
                    ->to($this->guest->email)
                    ->view('emails.guest.guest_confirmed');

            case 'dealerManager':
                return $this->from(env('MAIL_SENDER'))
                    ->to($this->user->email)
                    ->view('emails.guest.seller_confirmation');

            case 'saleExecutive':
                return $this->from(env('MAIL_SENDER'))
                    ->to($this->user->email)
                    ->view('emails.guest.seller_confirmation');
        }

    }
}
