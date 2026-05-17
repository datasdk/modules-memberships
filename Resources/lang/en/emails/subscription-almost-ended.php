<?php
return [
    'subject' => 'Your membership with {{ company.name }} will expire soon',

    'html_template' => '
        <p>Dear {{ user.first_name }},</p>
        <p><br></p>
        <p>Your membership with {{ company.name }} will expire soon. To avoid interruption of your benefits, we recommend renewing your membership in time.</p>
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

        <p>Log in to your profile to extend your membership right away.</p>
        <p><br></p>
        <p>We look forward to continuing to have you as a valued member.</p>
        <p><br></p>

        <p>Kind regards,</p>
        <p>{{ company.name }}</p>
    ',

    'text_template' => "
        Dear {{ user.first_name }},

        Your membership with {{ company.name }} will expire soon. To avoid interruption of your benefits, we recommend renewing your membership in time.

        Membership details:
        - Name: {{ subscription.name }}
        - Plan: {{ plan.title }}
        - Start date: {{ subscription.starts_at }}
        - End date: {{ subscription.ends_at }}
        - Trial end: {{ subscription.trial_ends_at }}
        - Payment method: {{ subscription.payment_method }}
        - Status: {{ subscription.status }}

        Log in to your profile to extend your membership right away.

        We look forward to continuing to have you as a valued member.

        Kind regards,
        {{ company.name }}
    ",
];
