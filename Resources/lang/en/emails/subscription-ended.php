<?php
return [
    'subject' => 'Your membership with {{ company.name }} has expired',

    'html_template' => '
        <p>Dear {{ user.first_name }},</p>
        <p><br></p>
        <p>Your membership with {{ company.name }} has now expired. We hope you have enjoyed the benefits and experiences of being a member.</p>
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

        <p>If you would like to reactivate your membership, you can log in and renew it at any time.</p>
        <p><br></p>

        [button url="{{ url }}" text="Renew membership" type="success"]

        <p><br></p>
        <p>Thank you for being part of our community.</p>
        <p><br></p>
        <p>Kind regards,</p>
        <p>{{ company.name }}</p>
    ',

    'text_template' => "
        Dear {{ user.first_name }},

        Your membership with {{ company.name }} has now expired. We hope you have enjoyed the benefits and experiences of being a member.

        Membership details:
        - Name: {{ subscription.name }}
        - Plan: {{ plan.title }}
        - Start date: {{ subscription.starts_at }}
        - End date: {{ subscription.ends_at }}
        - Trial end: {{ subscription.trial_ends_at }}
        - Payment method: {{ subscription.payment_method }}
        - Status: {{ subscription.status }}

        If you would like to reactivate your membership, you can log in and renew it at any time:
        {{ url }}

        Thank you for being part of our community.

        Kind regards,
        {{ company.name }}
    ",
];
