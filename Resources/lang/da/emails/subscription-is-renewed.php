<?php
return [
    'subject' => 'Dit medlemskab hos {{ app.name }} er blevet fornyet',

    'html_template' => '
        <p>Kære {{ user.first_name }},</p>
        <p><br></p>
        <p>Godt nyt! Dit medlemskab hos {{ app.name }} er blevet fornyet automatisk.</p>
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
        <p><br></p>

        <p>Vi ser frem til endnu en periode med dig som medlem. Du kan altid se detaljer om dit medlemskab på din profil.</p>
        <p><br></p>

        <p>Tak fordi du fortsat er en del af vores fællesskab.</p>
        <p><br></p>
        <p>Venlig hilsen,</p>
        <p>{{ app.name }}</p>
    ',

    'text_template' => "
        Kære {{ user.first_name }},

        Godt nyt! Dit medlemskab hos {{ app.name }} er blevet fornyet automatisk.

        Medlemskabsdetaljer:
        - Navn: {{ subscription.name }}
        - Plan: {{ plan.title }}
        - Startdato: {{ subscription.starts_at }}
        - Slutdato: {{ subscription.ends_at }}
        - Trial slut: {{ subscription.trial_ends_at }}
        - Betalingsmetode: {{ subscription.payment_method }}
        - Status: {{ subscription.status }}

        Vi ser frem til endnu en periode med dig som medlem. Du kan altid se detaljer om dit medlemskab på din profil.

        Tak fordi du fortsat er en del af vores fællesskab.

        Venlig hilsen,
        {{ app.name }}
    ",
];
