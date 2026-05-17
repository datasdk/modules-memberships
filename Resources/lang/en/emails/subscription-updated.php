<?php
return [
    'subject' => 'Your membership at {{ app.name }} has been updated',

    'html_template' => '
        <p>Dear {{ user.first_name }},</p>
        <p><br></p>
        <p>We hereby confirm that your membership at {{ app.name }} has been updated. The changes are effective immediately.</p>
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

        <p>You can view the updated details and terms on your profile page.</p>
        <p><br></p>

        <p>If you have any questions or need assistance, please do not hesitate to contact us.</p>
        <p><br></p>
        <p>Best regards,</p>
        <p>{{ app.name }}</p>
    ',

    'text_template' => "
        Dear {{ user.first_name }},

        We hereby confirm that your membership at {{ app.name }} has been updated. The changes are effective immediately.

        Membership details:
        - Name: {{ subscription.name }}
        - Plan: {{ plan.title }}
        - Start date: {{ subscription.starts_at }}
        - End date: {{ subscription.ends_at }}
        - Trial end: {{ subscription.trial_ends_at }}
        - Payment method: {{ subscription.payment_method }}
        - Status: {{ subscription.status }}

        You can view the updated details and terms on your profile page.

        If you have any questions or need assistance, please do not hesitate to contact us.

        Best regards,
        {{ app.name }}
    ",
];
