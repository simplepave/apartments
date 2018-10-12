<?php

/**
 *
 */

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['author'], $_POST['phone'])) {
    $author  = esc_attr(substr($_POST['author'], 0, 64));
    $phone = substr($_POST['phone'], 0, 64);
    $comment = isset($_POST['comment'])? substr($_POST['comment'], 0, 250): false;
    $from_data = isset($_POST['from-data'])? $_POST['from-data']: false;
    $to_data = isset($_POST['to-data'])? $_POST['to-data']: false;
    $subject = isset($_POST['subject'])? esc_attr($_POST['subject']): '';

    $to = get_option('admin_email');
    $subject   = get_bloginfo('name') .' '. $subject;

    $headers = [
        'MIME-Version: 1.0',
        'From: ' . $author . '<' . get_option('admin_email') . '>',
        'Content-Type: text/html; charset="' . get_option('blog_charset') . '"',
    ];

    $message = '';
    $message .= '<b>Имя:</b> ' . $author . '<br />';
    $message .= '<b>Телефон:</b> ' . $phone . '<br />';
    $message .= $from_data?'<b>Дата от:</b> ' . $from_data . '<br />': '';
    $message .= $to_data?'<b>Дата до:</b> ' . $to_data . '<br />': '';
    $message .= $comment? '<br /><b>Комментарий:</b> ' . str_replace('\n', '<br />', $comment): '';

    if (wp_mail($to, $subject, $message, $headers)) {
        $json['response'] = true;
        $json['message'] = 'Сообщение успешно отправлено!';
    } else {
        $json['response'] = false;
        $json['message'] = 'Ошибка, попробуйте позже!';
    }

    echo json_encode($json);
    exit();
}