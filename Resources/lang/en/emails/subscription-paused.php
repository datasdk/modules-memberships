<?php
return [
    'subject' => 'Your membership at {{ app.name }} has been paused',

    'html_template' => '
        <p>Dear {{ user.first_name }},</p>
        <p><br></p>
        <p>Your membership at {{ app.name }} has been successfully paused. During this time, you will not have access to your membership benefits.</p>
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

        <p>You can reactivate your membership anytime from your profile page.</p>
        <p><br></p>
        <p>If you have any questions, feel free to contact us.</p>
        <p><br></p>
        <p>Best regards,</p>
        <p>{{ app.name }}</p>
    ',

    'text_template' => "
        Dear {{ user.first_name }},

        Your membership at {{ app.name }} has been successfully paused. During this time, you will not have access to your membership benefits.

        Membership details:
        - Name: {{ subscription.name }}
        - Plan: {{ plan.title }}
        - Start date: {{ subscription.starts_at }}
        - End date: {{ subscription.ends_at }}
        - Trial end: {{ subscription.trial_ends_at }}
        - Payment method: {{ subscription.payment_method }}
        - Status: {{ subscription.status }}

        You can reactivate your membership anytime from your profile page.

        If you have any questions, feel free to contact us.

        Best regards,
        {{ app.name }}
    ",
];
