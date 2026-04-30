<?php
function send_mail(string $to, string $subject, string $message): bool {
    return mail($to, $subject, $message);
}
