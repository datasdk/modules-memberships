<?php
return [
    'subject' => 'Your membership with {{ company.name }} has been renewed',

    'html_template' => '
        <p>Dear {{ user.first_name }},</p>
        <p><br></p>
        <p>Good news! Your membership with {{ company.name }} has been renewed automatically.</p>
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

        <p>We look forward to another great period with you as a member. You can always view details about your membership on your profile.</p>
        <p><br></p>
        <p>Thank you for continuing to be part of our community.</p>
        <p><br></p>
        <p>Kind regards,</p>
        <p>{{ company.name }}</p>
    ',

    'text_template' => "
        Dear {{ user.first_name }},

        Good news! Your membership with {{ company.name }} has been renewed automatically.

        Membership details:
        - Name: {{ subscription.name }}
        - Plan: {{ plan.title }}
        - Start date: {{ subscription.starts_at }}
        - End date: {{ subscription.ends_at }}
        - Trial end: {{ subscription.trial_ends_at }}
        - Payment method: {{ subscription.payment_method }}
        - Status: {{ subscription.status }}

        We look forward to another great period with you as a member. You can always view details about your membership on your profile.

        Thank you for continuing to be part of our community.

        Kind regards,
        {{ company.name }}
    ",
];
