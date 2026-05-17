<?php

return [
    'subject' => 'Tillykke med dit medlemskab hos {{ app.name }}',

    'html_template' => '
        <p>Kære {{ user.first_name }},</p>
        <p><br></p>
        <p>Tillykke med dit medlemskab hos {{ app.name }}! Vi er glade for at byde dig velkommen og håber, du bliver glad for at være en del af fællesskabet.</p>
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
        <p>Har du spørgsmål eller brug for hjælp, er du altid velkommen til at kontakte os.</p>
        <p><br></p>
        <p>Venlig hilsen,</p>
        <p>{{ app.name }}</p>
    ',

    'text_template' => "
        Kære {{ user.first_name }},

        Tillykke med dit medlemskab hos {{ app.name }}! Vi er glade for at byde dig velkommen og håber, du bliver glad for at være en del af fællesskabet.

        Medlemskabsdetaljer:
        - Navn: {{ subscription.name }}
        - Plan: {{ plan.title }}
        - Startdato: {{ subscription.starts_at }}
        - Slutdato: {{ subscription.ends_at }}
        - Trial slut: {{ subscription.trial_ends_at }}
        - Betalingsmetode: {{ subscription.payment_method }}
        - Status: {{ subscription.status }}

        Du kan finde information om medlemskabets vilkår og andre detaljer på vores hjemmeside.

        Har du spørgsmål eller brug for hjælp, er du altid velkommen til at kontakte os.

        Venlig hilsen,
        {{ app.name }}
    ",
];
