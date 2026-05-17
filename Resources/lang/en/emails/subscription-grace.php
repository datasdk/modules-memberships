<?php
return [
    'subject' => 'Your membership at {{ app.name }} has expired',

    'html_template' => '
        <p>Dear {{ user.first_name }},</p>
        <p><br></p>
        <p>Your membership at {{ app.name }} has now expired. You still have {{ grace_days }} days to reactivate your membership before it is permanently closed.</p>
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

        <p>If you wish to continue as a member, you can log in and renew your membership within this period.</p>
        <p><br></p>
        [button url="{{ url }}" text="Renew Membership" type="success"]
        <p><br></p>
        <p>Best regards,</p>
        <p>{{ app.name }}</p>
    ',

    'text_template' => "
        Dear {{ user.first_name }},

        Your membership at {{ app.name }} has now expired. You still have {{ grace_days }} days to reactivate your membership before it is permanently closed.

        Membership details:
        - Name: {{ subscription.name }}
        - Plan: {{ plan.title }}
        - Start date: {{ subscription.starts_at }}
        - End date: {{ subscription.ends_at }}
        - Trial end: {{ subscription.trial_ends_at }}
        - Payment method: {{ subscription.payment_method }}
        - Status: {{ subscription.status }}

        If you wish to continue as a member, you can log in and renew your membership within this period:
        {{ url }}

        Best regards,
        {{ app.name }}
    ",
];
