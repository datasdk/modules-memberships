<?php
return [
    'subject' => 'Dit medlemskab hos {{ app.name }} er opgraderet',

    'html_template' => '
        <p>Kære {{ user.first_name }},</p>
        <p><br></p>
        <p>Vi er glade for at meddele, at din prøvetid hos {{ app.name }} nu er blevet opgraderet til et fuldt medlemskab!</p>
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

        <p>Du kan nu nyde alle fordelene ved dit medlemskab. Log ind og se alle funktionerne og mulighederne.</p>
        <p><br></p>

        <p>Har du spørgsmål, er du altid velkommen til at kontakte os.</p>
        <p><br></p>
        <p>Venlig hilsen,</p>
        <p>{{ app.name }}</p>
    ',

    'text_template' => "
        Kære {{ user.first_name }},

        Vi er glade for at meddele, at din prøvetid hos {{ app.name }} nu er blevet opgraderet til et fuldt medlemskab!

        Medlemskabsdetaljer:
        - Navn: {{ subscription.name }}
        - Plan: {{ plan.title }}
        - Startdato: {{ subscription.starts_at }}
        - Slutdato: {{ subscription.ends_at }}
        - Trial slut: {{ subscription.trial_ends_at }}
        - Betalingsmetode: {{ subscription.payment_method }}
        - Status: {{ subscription.status }}

        Du kan nu nyde alle fordelene ved dit medlemskab. Log ind og se alle funktionerne og mulighederne.

        Har du spørgsmål, er du altid velkommen til at kontakte os.

        Venlig hilsen,
        {{ app.name }}
    ",
];
