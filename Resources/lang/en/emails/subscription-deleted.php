<?php
return [
    'subject' => 'Your membership at {{ app.name }} has been deleted',

    'html_template' => '
        <p>Dear {{ user.first_name }},</p>
        <p><br></p>
        <p>We confirm that your membership at {{ app.name }} has been deleted. We’re sorry to see you go and hope to welcome you back in the future.</p>
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

        <p>All your data is handled in accordance with our privacy policy.</p>
        <p><br></p>

        <p>If you have any questions, feel free to contact us.</p>
        <p><br></p>

        <p>Best regards,</p>
        <p>{{ app.name }}</p>
    ',

    'text_template' => "
        Dear {{ user.first_name }},

        We confirm that your membership at {{ app.name }} has been deleted. We’re sorry to see you go and hope to welcome you back in the future.

        Membership details:
        - Name: {{ subscription.name }}
        - Plan: {{ plan.title }}
        - Start date: {{ subscription.starts_at }}
        - End date: {{ subscription.ends_at }}
        - Trial end: {{ subscription.trial_ends_at }}
        - Payment method: {{ subscription.payment_method }}
        - Status: {{ subscription.status }}

        All your data is handled in accordance with our privacy policy.

        If you have any questions, feel free to contact us.

        Best regards,
        {{ app.name }}
    ",
];
