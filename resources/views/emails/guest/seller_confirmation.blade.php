<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <title>{{{ $trans['youHaveNewBooking'] ?? 'You have a new booking'}}}</title>
    <style type="text/css">
        .ReadMsgBody {
            width: 100%;
        }

        .ExternalClass {
            width: 100%;
        }

        -moz-hyphens: none

        ;
        -ms-hyphens: none

        ;
        -webkit-hyphens: none

        ;
        hyphens: none

        ;
    </style>
</head>

<body style="background:#fafafa">

<table border="0" cellpadding="0" cellspacing="0"
       style="border:1px solid #777777; font-family: Arial, 'Helvetica Neue', Helvetica, 'sans-serif'; font-size: 18px; color: #333c42; line-height: 1.4"
       align="center" width="650" bgcolor="#FFFFFF">

    <tr>
        <td colspan="3" width="650" style="font-size: 1px; line-height: 0" height="40">&nbsp;</td>
    </tr>

    <tr>
        <td width="66">&nbsp;</td>
        <td width="518">
            <table cellpadding="0" cellspacing="0" border="0" width="518">
                <tr>
                    <td width="259">
                        <table cellpadding="0" cellspacing="0" border="0" width="259">
                            <tr>
                                <td width="37" style="text-align: center">
                                    <img src="http://vipevent.co.uk/book/images/map-marker.jpg"/>
                                </td>
                                <td width="14">&nbsp;</td>
                                <td width="208">
                                    <p style="margin: 0;color:#333c42;font-size:15px;">
                                        <strong>{{ $guest->event_name }}</strong></p>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="3" height="15" style="line-height: 0; font-size: 1px">&nbsp;</td>
                            </tr>
                            <tr>
                                <td width="37" style="text-align: center">
                                    <img src="http://vipevent.co.uk/book/images/emails/event-type.jpg"/>
                                </td>
                                <td width="14">&nbsp;</td>
                                <td width="208">
                                    <p style="margin: 0;color:#333c42;font-size:15px;">
                                        <strong>{{ $guest->event_type }}</strong></p>
                                </td>
                            </tr>
                        </table>
                    </td>
                    <td width="259" style="text-align: right">
                        <img src="{{ $guest->banner_image}}" width="100"/>
                    </td>
                </tr>
            </table>
        </td>
        <td width="66">&nbsp;</td>
    </tr>

    <tr>
        <td colspan="3" width="650" style="font-size: 1px; line-height: 0" height="40">&nbsp;</td>
    </tr>

    <tr>
        <td bgcolor="#ffffff" width="66">&nbsp;</td>
        <td bgcolor="#ffffff" width="518">
            <h1 style="font-weight: normal; font-size: 30px; margin-top: 0;color:#333c42;">{!! $trans['bookingConfirmationForYourRhinoSalesEvent'] ?? 'Booking Confirmation<br />for your Rhino sales event!' !!}</h1>

            <p style="color:#333c42;font-size:15px;">{{ $trans['dear'] ?? 'dear' }} {{ $user->firstname }} {{ $user->surname }}
                ,</p>

            <p style="color:#333c42;font-size:15px;"> {{ $trans['pleaseBeAdvisedThat'] ?? 'Please be advised that' }} {{{ $guest->title or '' }}} {{ $guest->surname }} {{ $trans['hasMadeAnAppointment'] ?? 'has made an appointment at the following times to attend your' }}
                {{ $guest->event_nmae }}
                .</p>

            <hr/>

            <p style="color:#333c42;font-size:15px;">
                <strong>{{ $trans['appointmentConfirmed'] ?? 'Appointment Confirmed:' }}</strong></p>

            <p style="color:#333c42;font-size:15px;">{{{ $guest->title or '' }}} {{ $guest->first_name }} {{ $guest->surname }}
                <br/>
                @if($guest->addressline1){{ $guest->addressline1 }}<br/>@endif
                @if($guest->addressline2){{ $guest->addressline2 }}<br/>@endif
                @if($guest->addressline3){{ $guest->addressline3 }}<br/>@endif
                @if($guest->addressline4){{ $guest->addressline4 }}<br/>@endif
                @if($guest->addressline5){{ $guest->addressline5 }}<br/>@endif
                @if($guest->addressline6){{ $guest->addressline6 }}<br/>@endif
                @if($guest->post){{ $guest->post }}<br/>@endif
                {{ $guest->landline }}<br/>
                {{ $guest->email }}</p>


            <p style="color: #007bcd"><strong>
                    {{ $trans['iAmPleasedToConfirmYourAppointmentHasBeenMade'] ?? 'I am pleased to confirm your appointment has been made on' }}
                    {{ $guest->appointment_date }}
                    at
                    {{ $guest->appointment_start }} - {{ $guest->appointment_end }}
                    .</strong>
            </p>

            <hr/>

            @if(isset($vehicles))
                <p style="color:#333c42;font-size:15px;">
                    <strong>{{ $trans['vehiclesTheCustomer'] ?? 'Vehicles the customer has expressed an interest in:' }}</strong>
                </p>
                @foreach($vehicles as $key => $car)
                    <p style="color:#333c42;font-size:15px;">
                        @switch($car->vehicle_condition)
                            @case(1)
                            {{ $trans['naw'] ?? 'New' }}
                            @break

                            @case(2)
                            {{ $trans['used'] ?? 'Used' }}
                            @break

                            @case(3)
                            {{ $trans['unsure'] ?? 'Unsure' }}
                            @break
                            @default
                            none
                        @endswitch {{ $car -> vehicle_name }}
                    </p>
                @endforeach
                <hr/>
            @endif

            <p style="color:#333c42;font-size:15px;">{{ $trans['pleaseCanYouEnsure'] ?? 'Please can you ensure that you send out the letter of confirmation and also execute your pre-qualification call in the week leading up to your Event.' }}</p>

            <p style="color:#333c42;font-size:15px;">{{ $trans['weWishYouEverySuccess'] ?? 'We wish you every success for your forthcoming Event.' }}</p>

            <p style="margin-bottom: 0;color:#333c42;font-size:15px;">{{ $trans['kindRegards'] ?? 'Kind Regards,' }}
                <br/>
                {{ $trans['rhinoEvent'] ?? 'Rhino Event' }}</p>

        </td>
        <td bgcolor="#ffffff" width="66">&nbsp;</td>
    </tr>

    <tr>
        <td bgcolor="#ffffff" colspan="3" width="650" style="font-size: 1px; line-height: 0" height="40">&nbsp;</td>
    </tr>

    <tr>
        <td colspan="3" width="650" style="font-size: 1px; line-height: 0" height="30">&nbsp;</td>
    </tr>

    <tr>
        <td width="66">&nbsp;</td>
        <td width="518">
            <a href="http://rhinoevents.com"><img src="http://vipevent.co.uk/book/images/emails/rhino-logo.jpg"/></a>
        </td>
        <td width="66">&nbsp;</td>
    </tr>

    <tr>
        <td colspan="3" width="650" style="font-size: 1px; line-height: 0" height="20">&nbsp;</td>
    </tr>

    <tr>
        <td width="66">&nbsp;</td>
        <td width="518"><img src="http://vipevent.co.uk/book/images/emails/line.jpg"/></td>
        <td width="66">&nbsp;</td>
    </tr>

    <tr>
        <td colspan="3" width="650" style="font-size: 1px; line-height: 0" height="15">&nbsp;</td>
    </tr>

    <tr>
        <td width="66">&nbsp;</td>
        <td width="518">
            <table cellpadding="0" cellspacing="0" border="0" width="518">
                <tr>
                    <td width="41"><a href="https://www.facebook.com/rhinoeventscom"><img
                                src="http://vipevent.co.uk/book/images/emails/fb.jpg"/></a></td>
                    <td width="8">&nbsp;</td>
                    <td width="41"><a href="https://twitter.com/_rhinoevents"><img
                                src="http://vipevent.co.uk/book/images/emails/tw.jpg"/></a></td>
                    <td width="8">&nbsp;</td>
                    <td width="41"><a href="https://www.instagram.com/rhinomedia/"><img
                                src="http://vipevent.co.uk/book/images/emails/insta.jpg"/></a></td>
                    <td width="8">&nbsp;</td>
                    <td width="41"><a href="https://www.youtube.com/channel/UCyRCxuXTOba2sFXaRiqJ9Cw"><img
                                src="http://vipevent.co.uk/book/images/emails/yt.jpg"/></a></td>
                    <td width="330">&nbsp;</td>
                </tr>
            </table>
        </td>
        <td width="66">&nbsp;</td>
    </tr>

    <tr>
        <td colspan="3" width="650" style="font-size: 1px; line-height: 0" height="15">&nbsp;</td>
    </tr>

    <tr>
        <td width="66">&nbsp;</td>
        <td width="518" style="font-size: 15px;">
            <p><a href="https://rhinogroup.co.uk/" style="color:#333c42;text-decoration:none;">Rhino Group</a> | <a
                    href="https://rhinogroup.co.uk/contact/" style="color:#333c42;text-decoration:none;">Contact Us</a>
            </p>

            <p style="color: #989c9f;font-size: 15px;">Rhino Events, Russell Street, Cheshire, SK14 2HJ, United
                Kingdom</p>

            <p style="color: #989c9f;font-size: 15px; margin-bottom: 0;">© Rhino Group 2018</p>
        </td>
        <td width="66">&nbsp;</td>
    </tr>

    <tr>
        <td colspan="3" width="650" style="font-size: 1px; line-height: 0" height="40">&nbsp;</td>
    </tr>

</table>

</body>
</html>
