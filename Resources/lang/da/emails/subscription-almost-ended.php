<?php
return [
    'subject' => 'Dit medlemskab hos {{ app.name }} udløber snart',

    'html_template' => '
        <p>Kære {{ user.first_name }},</p>
        <p><br></p>
        <p>Dit medlemskab hos {{ app.name }} udløber snart. For at undgå afbrydelse i dine fordele anbefaler vi, at du fornyer medlemskabet i god tid.</p>
        <p><br></p>

        <p>Medlemskabsdetaljer:</p>
        <ul>
            <li>Navn: {{ subscription.name }}</li>
            <li>Plan: {{ plan.title }}</li>
            <li>Startdato: {{ subscription.starts_at }}</li>
            <li>Slutdato: {{ subscription.ends_at }}</li>
            <li>Trial slut: {{ subscription.trial_ends_at }}</li>
            <li>Betalingsmetode: {{ subscription.payment_method }}</li>
            <li>Status: {{ subscription.status }}</li>
        </ul>

        <p>Log ind på din profil for at forlænge dit medlemskab med det samme.</p>
        <p><br></p>
        <p>Vi glæder os til fortsat at have dig som medlem.</p>
        <p><br></p>
        <p>Venlig hilsen,</p>
        <p>{{ app.name }}</p>
    ',

    'text_template' => "
        Kære {{ user.first_name }},

        Dit medlemskab hos {{ app.name }} udløber snart. For at undgå afbrydelse i dine fordele anbefaler vi, at du fornyer medlemskabet i god tid.

        Medlemskabsdetaljer:
        - Navn: {{ subscription.name }}
        - Plan: {{ plan.title }}
        - Startdato: {{ subscription.starts_at }}
        - Slutdato: {{ subscription.ends_at }}
        - Trial slut: {{ subscription.trial_ends_at }}
        - Betalingsmetode: {{ subscription.payment_method }}
        - Status: {{ subscription.status }}

        Log ind på din profil for at forlænge dit medlemskab med det samme.

        Vi glæder os til fortsat at have dig som medlem.

        Venlig hilsen,
        {{ app.name }}
    ",
];
