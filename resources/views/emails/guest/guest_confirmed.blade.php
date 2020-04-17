<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <title>{{$trans['thankYouForConfirmingYourAppointment']}}</title>
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
                                    <img src="http://vipevent.co.uk/book/images/emails/map-marker.jpg"/>
                                </td>
                                <td width="14">&nbsp;</td>
                                <td width="208">
                                    <p style="margin: 0;"><strong>{{ $guest->event_name}}</strong></p>
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
                                    <p style="margin: 0;"><strong>{{ $guest->event_type }}</strong></p>
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
        <td colspan="3" style="border:0; text-align:center" valign="top">
            <img src="http://vipevent.co.uk/book/images/emails/headImg.jpg"/>
        </td>
    </tr>

    <tr>
        <td colspan="3" width="650" style="font-size: 1px; line-height: 0" height="40">&nbsp;</td>
    </tr>

    <tr>
        <td bgcolor="#ffffff" width="66">&nbsp;</td>
        <td bgcolor="#ffffff" width="518">
            <h1 style="font-weight: normal; font-size: 30px; margin-top: 0; color: #007bcd">{{ $trans['greatNews'] }}<br/>{{ $trans['yourAppointmentIsConfirmed'] }}</h1>

            <p>Dear {{ $guest->title }} {{ $guest->surname }},</p>

            <p>{{ $trans['thankYouForTheInterestYouHaveShown'] }}
                {{ $guest->event_name }}
            </p>

            <p style="color: #007bcd"><strong>
                {{ $trans['iAmPleasedToConfirmYourAppointmentHasBeenMade'] }}
                    {{ $guest->appointment_date }}
                    at
                    {{ $guest->appointment_start }} - {{ $guest->appointment_end }}
                    .</strong>
            </p>


            <p>{{ $trans['yourUniqueCodeIs'] }} <strong>{{ $guest->unique }}</strong></p>

            <p>{{ $trans['confirmGuestMailDescription'] }}</p>

            <p>{{ $trans['confirmGuestMailFurtherQuestions'] }}</p>

            <p>{{ $trans['confirmGuestMailForwardWelcoming'] }}</p>

            <p>{{ $trans['kindRegards'] }}<br/>
                {{ $trans['eventsTeam'] }}</p>

        </td>
        <td bgcolor="#ffffff" width="66">&nbsp;</td>
    </tr>

    <tr>
        <td bgcolor="#ffffff" colspan="3" width="650" style="font-size: 1px; line-height: 0" height="40">&nbsp;</td>
    </tr>

</table>

</body>
</html>
