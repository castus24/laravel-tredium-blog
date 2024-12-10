<?php

return [
    'reset-password' => [
        'greeting' => 'Здравствуйте!',
        'subject' => 'Восстановление пароля',
        'reason' => 'Для восстановления доступа к вашему профилю <strong>Tredium</strong> <a href=":resetUrl">перейдите по ссылке</a> и придумайте новый пароль.',
        'action' => 'Сбросить пароль',
        'expire' => 'Срок действия этой ссылки для сброса пароля истекает через :count минут.',
        'note' => 'Если вы не запрашивали сброс пароля, никаких дальнейших действий не требуется.',
        'salutation' => 'С уважением и заботой, команда <a href="' . env('FRONT_URL') . '">Tredium</a>',
    ],
    'verify-email' => [
        'greeting' => 'Здравствуйте!',
        'subject' => 'Подтверждение адреса электронной почты',
        'reason' => 'Вы получили это письмо, потому что мы получили запрос на изменение адреса электронной почты вашей учетной записи.',
        'type' => 'Введите 6-значный секретный код:',
        'salutation' => 'С уважением и заботой, команда <a href="' . env('FRONT_URL') . '">Tredium</a>',
    ],
];
