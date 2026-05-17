<?php
return [
    'subject' => 'Dit medlemskab hos {{ app.name }} er sat på pause',

    'html_template' => '
        <p>Kære {{ user.first_name }},</p>
        <p><br></p>
        <p>Dit medlemskab hos {{ app.name }} er nu sat på pause. Du vil i denne periode ikke have adgang til medlemsfordelene.</p>
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

        <p>Du kan til enhver tid genaktivere dit medlemskab via din profilside.</p>
        <p><br></p>
        <p>Har du spørgsmål, er du meget velkommen til at kontakte os.</p>
        <p><br></p>
        <p>Venlig hilsen,</p>
        <p>{{ app.name }}</p>
    ',

    'text_template' => "
        Kære {{ user.first_name }},

        Dit medlemskab hos {{ app.name }} er nu sat på pause. Du vil i denne periode ikke have adgang til medlemsfordelene.

        Medlemskabsdetaljer:
        - Navn: {{ subscription.name }}
        - Plan: {{ plan.title }}
        - Startdato: {{ subscription.starts_at }}
        - Slutdato: {{ subscription.ends_at }}
        - Trial slut: {{ subscription.trial_ends_at }}
        - Betalingsmetode: {{ subscription.payment_method }}
        - Status: {{ subscription.status }}

        Du kan til enhver tid genaktivere dit medlemskab via din profilside.

        Har du spørgsmål, er du meget velkommen til at kontakte os.

        Venlig hilsen,
        {{ app.name }}
    ",
];
