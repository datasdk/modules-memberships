<?php
return [
    'subject' => 'Din prøvetid hos {{ app.name }} er slut',

    'html_template' => '
        <p>Kære {{ user.first_name }},</p>
        <p><br></p>
        <p>Din prøvetid hos {{ app.name }} er nu slut. Vi håber, du har nydt at prøve vores medlemskab og fået et godt indblik i fordelene.</p>
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

        <p>Hvis du ønsker at fortsætte som medlem, skal du blot logge ind og forny dit medlemskab.</p>
        <p><br></p>
        [button url="{{ url }}" text="Forny medlemskab" type="success"]
        <p><br></p>

        <p>Har du spørgsmål, er du altid velkommen til at kontakte os.</p>
        <p><br></p>
        <p>Venlig hilsen,</p>
        <p>{{ app.name }}</p>
    ',

    'text_template' => "
        Kære {{ user.first_name }},

        Din prøvetid hos {{ app.name }} er nu slut. Vi håber, du har nydt at prøve vores medlemskab og fået et godt indblik i fordelene.

        Medlemskabsdetaljer:
        - Navn: {{ subscription.name }}
        - Plan: {{ plan.title }}
        - Startdato: {{ subscription.starts_at }}
        - Slutdato: {{ subscription.ends_at }}
        - Trial slut: {{ subscription.trial_ends_at }}
        - Betalingsmetode: {{ subscription.payment_method }}
        - Status: {{ subscription.status }}

        Hvis du ønsker at fortsætte som medlem, skal du blot logge ind og forny dit medlemskab:
        {{ url }}

        Har du spørgsmål, er du altid velkommen til at kontakte os.

        Venlig hilsen,
        {{ app.name }}
    ",
];
