<?php
return [
    'subject' => 'Your trial at {{ company.name }} has been upgraded',

    'html_template' => '
        <p>Dear {{ user.first_name }},</p>
        <p><br></p>
        <p>We are happy to inform you that your trial at {{ company.name }} has now been upgraded to a full membership!</p>
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

        <p>You can now enjoy all the benefits of your membership. Log in to explore all the features and opportunities.</p>
        <p><br></p>
        <p>If you have any questions, please feel free to contact us anytime.</p>
        <p><br></p>
        <p>Best regards,</p>
        <p>{{ company.name }}</p>
    ',

    'text_template' => "
        Dear {{ user.first_name }},

        We are happy to inform you that your trial at {{ company.name }} has now been upgraded to a full membership!

        Membership details:
        - Name: {{ subscription.name }}
        - Plan: {{ plan.title }}
        - Start date: {{ subscription.starts_at }}
        - End date: {{ subscription.ends_at }}
        - Trial end: {{ subscription.trial_ends_at }}
        - Payment method: {{ subscription.payment_method }}
        - Status: {{ subscription.status }}

        You can now enjoy all the benefits of your membership. Log in to explore all the features and opportunities.

        If you have any questions, please feel free to contact us anytime.

        Best regards,
        {{ company.name }}
    ",
];
