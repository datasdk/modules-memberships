<?php
return [
    'subject' => 'Dit medlemskab hos {{ app.name }} er blevet slettet',

    'html_template' => '
        <p>Kære {{ user.first_name }},</p>
        <p><br></p>
        <p>Vi bekræfter hermed, at dit medlemskab hos {{ app.name }} er blevet slettet. Vi er kede af at se dig gå, og håber at kunne byde dig velkommen igen i fremtiden.</p>
        <p><br></p>

        <p>Medlemskabsdetaljer:</p>
        <ul>
            <li>Navn: {{ subscription.name }}</li>
            <li>Plan: {{ plan.title }}</li>
            <li>Startdato: {{ subscription.starts_at }}</li>
            <li>Slutdato: {{ subscription.ends_at }}</li>
            <li>Betalingsmetode: {{ subscription.payment_method }}</li>
            <li>Status: {{ subscription.status }}</li>
        </ul>

        <p>Alle dine oplysninger bliver behandlet i overensstemmelse med vores privatlivspolitik.</p>
        <p><br></p>
        <p>Har du spørgsmål, er du velkommen til at kontakte os.</p>
        <p><br></p>
        <p>Venlig hilsen,</p>
        <p>{{ app.name }}</p>
    ',

    'text_template' => "
        Kære {{ user.first_name }},

        Vi bekræfter hermed, at dit medlemskab hos {{ app.name }} er blevet slettet. Vi er kede af at se dig gå, og håber at kunne byde dig velkommen igen i fremtiden.

        Medlemskabsdetaljer:
        - Navn: {{ subscription.name }}
        - Plan: {{ plan.title }}
        - Startdato: {{ subscription.starts_at }}
        - Slutdato: {{ subscription.ends_at }}
        - Betalingsmetode: {{ subscription.payment_method }}
        - Status: {{ subscription.status }}

        Alle dine oplysninger bliver behandlet i overensstemmelse med vores privatlivspolitik.

        Har du spørgsmål, er du velkommen til at kontakte os.

        Venlig hilsen,
        {{ app.name }}
    ",
];
