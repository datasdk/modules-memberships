<?php
return [
    'subject' => 'Your trial period with {{ company.name }} has ended',

    'html_template' => '
        <p>Dear {{ user.first_name }},</p>
        <p><br></p>
        <p>Your trial period with {{ company.name }} has now ended. We hope you enjoyed exploring our membership and discovering its benefits.</p>
        <p><br></p>

        <p>Membership details:</p>
        <ul>
            <li>Name: {{ subscription.name }}</li>
            <li>Plan: {{ plan.title }}</li>
            <li>Start date: {{ subscription.starts_at }}</li>
            <li>End date: {{ subscription.ends_at }}</li>
            <li>Trial end: {{ subscription.trial_ends_at }}</li>
            <li>Payment method: {{ subscription.payment_method }}</li>
            <li>Status: {{ subscription.status }}</li>
        </ul>
        <p><br></p>

        <p>If you wish to continue as a member, simply log in and renew your membership:</p>
        <p><br></p>
        [button url="{{url}}" text="Renew membership" type="success"]
        <p><br></p>
        <p>If you have any questions, feel free to contact us anytime.</p>
        <p><br></p>
        <p>Kind regards,</p>
        <p>{{ company.name }}</p>
    ',

    'text_template' => "
        Dear {{ user.first_name }},

        Your trial period with {{ company.name }} has now ended. We hope you enjoyed exploring our membership and discovering its benefits.

        Membership details:
        - Name: {{ subscription.name }}
        - Plan: {{ plan.title }}
        - Start date: {{ subscription.starts_at }}
        - End date: {{ subscription.ends_at }}
        - Trial end: {{ subscription.trial_ends_at }}
        - Payment method: {{ subscription.payment_method }}
        - Status: {{ subscription.status }}

        If you wish to continue as a member, simply log in and renew your membership:
        {{ url }}

        If you have any questions, feel free to contact us anytime.

        Kind regards,
        {{ company.name }}
    ",
];
