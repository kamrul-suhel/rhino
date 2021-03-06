<?php

namespace App\Http\Controllers\Booking;

use App\Event;
use App\Guest;
use App\Dealership;
use App\Appointment;
use App\AppointmentVehicle;
use App\Mail\GuestConfirmed;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use App\Http\Requests\BookingRequest;

class BookingStoreController extends Controller
{

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(BookingRequest $request)
    {
        if (
            $request->has('appointment_id') &&
            !empty($request->appointment_id))
        {
            $appointment = $this->save($request, $request->appointment_id);
        } else {
            $appointment = $this->save($request);
        }

        if ($appointment) {
            if ($appointment->guest_id) {
                // Update guest status to
                $guest = Guest::findOrFail($request->guest_id);

                if ($request->has('type') && !empty($request->type)) {
                    switch ($request->type) {
                        case 'canceled':
                            $guest->status = Guest::STATUS_CANCELED;
                            break;

                        case 'pending':
                            $guest->status = Guest::STATUS_PENDING;
                            break;

                        case 'confirmed':
                            $guest->status = Guest::STATUS_CONFIRMED;
                            break;
                    }
                }

                $guest->save();
            }

            return response()->json([
                'success' => true,
                'request' => $appointment
            ]);
        }

        return response()->json([
            'success' => false
        ]);
    }

    public function save(BookingRequest $request, $id = null)
    {

        $appointment = $id ? Appointment::findOrFail($id) : new Appointment();

        $request->has('event_id') ? $appointment->event_id = $request->event_id : null;
        $request->has('user_id') ? $appointment->user_id = $request->user_id : null;
        $appointment->guest_id = $request->has('guest_id') ? $request->guest_id : null;
        $request->has('slot_id') ? $appointment->slot_id = $request->slot_id : null;
        $request->has('bring_guest') && $request->bring_guest !== 'undefined' ? $appointment->bring_guest = $request->bring_guest : null;
        $request->has('guest_changing_car') && $request->guest_changing_car !== 'undefined' ? $appointment->guest_changing_car = $request->guest_changing_car : null;
        $request->has('start') ? $appointment->start = $request->start : null;
        $request->has('end') ? $appointment->end = $request->end : null;
        $request->has('part_ex_vrm') && $request->part_ex_vrm !== 'undefined' ? $appointment->part_ex_vrm = $request->part_ex_vrm : null;
        $request->has('part_ex_vehicle') && $request->part_ex_vehicle !== 'undefined' ? $appointment->part_ex_vehicle = $request->part_ex_vehicle : null;
        $request->has('part_ex_distance') && $request->part_ex_distance !== 'undefined' ? $appointment->part_ex_distance = $request->part_ex_distance : null;
        $request->has('status') && $request->status !== 'null' ? $appointment->status = $request->status : null;

        $appointment->save();


        // if request has canceled, do not update appointment vehicle
        if ($request->has('canceled') && !empty($request->canceled)) {
            return $appointment;
        }

        // Do not want to delete vehicle
        if ($request->has('delete_vehicle') && !empty($request->delete_vehicle)) {
            return $appointment;
        }

        // if vehicles exists then update vehicle
        if (
            $request->has('vehicles')
            && count($request->vehicles) > 0
        ) {
            $appointment->vehicles()->delete();
            foreach ($request->vehicles as $vehicle) {
                $this->saveAppointmentVehicle($vehicle, $appointment->id);
            }
        } else {
            if ($id) {
                $appointment->vehicles()->delete();
            }
        }

        // Send email if appointment is new
        if(

            $request->has('sendEmail') &&
            $request->sendEmail == true
        ){

            Mail::send(new GuestConfirmed($request->guest_id, $this->languageId));


            // check dealership emails setting
            $event = Event::find($appointment->event_id);
            $dealership = Dealership::find($event->dealership_id);

            if ($dealership->enable_emails){
                Mail::send(new GuestConfirmed($request->guest_id, $this->languageId, 'dealerManager'));
                Mail::send(new GuestConfirmed($request->guest_id, $this->languageId, 'saleExecutive'));
            }

        }

        return $appointment;
    }

    private function saveAppointmentVehicle($vehicle, $appointmentId, $appointmentVehicleId = null)
    {
        $appointmentVehicle = $appointmentVehicleId ? AppointmentVehicle::findOrFail($appointmentVehicleId) : new AppointmentVehicle();
        $appointmentVehicle->appointment_id = $appointmentId;
        $appointmentVehicle->vehicle_id = $vehicle['vehicle_id'];
        $appointmentVehicle->vehicle_condition = $vehicle['condition'];
        $appointmentVehicle->save();
        return true;
    }
}
