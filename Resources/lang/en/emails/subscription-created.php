<?php
return [
    'subject' => 'Congratulations on your membership at {{ app.name }}',

    'html_template' => '
        <p>Dear {{ user.first_name }},</p>
        <p><br></p>
        <p>Congratulations on your membership at {{ app.name }}! We are excited to welcome you and hope you enjoy being part of the community.</p>
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

        <p>You can find information about the membership terms and other details on our website.</p>
        <p><br></p>
        <p>If you have any questions or need assistance, you are always welcome to contact us.</p>
        <p><br></p>

        <p>Best regards,</p>
        <p>{{ app.name }}</p>
    ',

    'text_template' => "
        Dear {{ user.first_name }},

        Congratulations on your membership at {{ app.name }}! We are excited to welcome you and hope you enjoy being part of the community.

        Membership details:
        - Name: {{ subscription.name }}
        - Plan: {{ plan.title }}
        - Start date: {{ subscription.starts_at }}
        - End date: {{ subscription.ends_at }}
        - Trial end: {{ subscription.trial_ends_at }}
        - Payment method: {{ subscription.payment_method }}
        - Status: {{ subscription.status }}

        You can find information about the membership terms and other details on our website.

        If you have any questions or need assistance, you are always welcome to contact us.

        Best regards,
        {{ app.name }}
    ",
];
