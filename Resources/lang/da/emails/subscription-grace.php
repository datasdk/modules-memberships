<?php
return [
    'subject' => 'Dit medlemskab hos {{ app.name }} er udløbet',

    'html_template' => '
        <p>Kære {{ user.first_name }},</p>
        <p><br></p>
        <p>Dit medlemskab hos {{ app.name }} er nu udløbet. Du har dog stadig {{ grace_days }} dage til at genaktivere dit medlemskab, før det bliver lukket permanent.</p>
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

        <p>Hvis du ønsker at fortsætte som medlem, kan du logge ind og forny dit medlemskab inden for denne periode.</p>
        <p><br></p>

        [button url="{{ url }}" text="Forny medlemskab" type="success"]

        <p><br></p>
        <p>Venlig hilsen,</p>
        <p>{{ app.name }}</p>
    ',

    'text_template' => "
        Kære {{ user.first_name }},

        Dit medlemskab hos {{ app.name }} er nu udløbet. Du har dog stadig {{ grace_days }} dage til at genaktivere dit medlemskab, før det bliver lukket permanent.

        Medlemskabsdetaljer:
        - Navn: {{ subscription.name }}
        - Plan: {{ plan.title }}
        - Startdato: {{ subscription.starts_at }}
        - Slutdato: {{ subscription.ends_at }}
        - Trial slut: {{ subscription.trial_ends_at }}
        - Betalingsmetode: {{ subscription.payment_method }}
        - Status: {{ subscription.status }}

        Hvis du ønsker at fortsætte som medlem, kan du logge ind og forny dit medlemskab inden for denne periode:
        {{ url }}

        Venlig hilsen,
        {{ app.name }}
    ",
];
