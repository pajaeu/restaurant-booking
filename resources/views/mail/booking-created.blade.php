<!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ config('restaurant.name') }}</title>
</head>
<body style="margin: 0; color: #212121; background-color: #f0f0f0">
    <table style="border-collapse: separate; width: 100%;">
        <tr>
            <td style="padding: 40px">
                <table style="width: 100%">
                    <tr>
                        <td></td>
                        <td style="width: 600px; text-align: center;">
                            <div style="margin-bottom: 20px; font-weight: 600; letter-spacing: 2px; text-transform: uppercase; text-align: center">{{ config('restaurant.name') }}</div>
                            <div style="border-radius: 5px; background-color: #ffffff">
                                <table style="width: 100%; text-align: left; border-radius: 5px; background-color: #ffffff">
                                    <tr>
                                        <td>
                                            <div style="padding: 40px;">
                                                <div style="margin-bottom: 40px; text-align: center">
                                                    <h1 style="margin: 0 0 10px; font-size: 1.2rem; font-weight: 600">Děkujeme za Vaši rezervaci!</h1>
                                                    <p style="font-size: 0.8rem;">Tímto emailem potvrzujeme Vaši rezervaci číslo {{ $booking->id }}</p>
                                                </div>
                                                <div>
                                                    <p>Datum Vaši rezervace: <b>{{ $booking->reserved_time->format('d.m.Y H:i') }}</b></p>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                            <div style="margin-top: 20px">
                                <p style="color: #718096; font-size: 0.8rem; text-align: center">Tento email byl vygenerován automaticky, neodpovídejte na něj.</p>
                            </div>
                        </td>
                        <td></td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>