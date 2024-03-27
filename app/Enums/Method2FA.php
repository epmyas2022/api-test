<?php
namespace App\Enums;

enum Method2FA: string {
    case SMS = 'sms';
    case EMAIL = 'email';
    case GOOGLE_AUTH = 'google_auth';
}
