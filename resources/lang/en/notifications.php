<?php

return [
    'reset-password' => [
        'greeting' => 'Hello!',
        'subject' => 'Reset Your Password',
        'reason' => 'We received a request to reset the password for your account. Click the <a href=":resetUrl">link</a> below to reset your password.',
        'action' => 'Reset Password',
        'expire' => 'This link will expire in :count minutes.',
        'note' => 'If you did not request a password reset, no further action is required.',
        'salutation' => 'Best regards, <a href="' . env('FRONT_URL') . '">Tredium</a>',
    ],
    'verify-email' => [
        'greeting' => 'Hello!!',
        'subject' => 'Email Verification',
        'reason' => 'You are receiving this email because we have received a request to change your account email address.',
        'type' => 'Enter your 6-digit secret code:',
        'salutation' => 'Best regards, <a href="' . env('FRONT_URL') . '">Tredium</a>',
    ],
];
