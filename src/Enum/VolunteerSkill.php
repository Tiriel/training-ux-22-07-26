<?php

namespace App\Enum;

enum VolunteerSkill: string
{
    case REGISTRATION = 'registration';
    case TECHNICAL_SUPPORT = 'technical';
    case CATERING = 'catering';
    case SECURITY = 'security';
    case PHOTOGRAPHY = 'photography';

    public function getLabel(): string
    {
        return match($this) {
            self::REGISTRATION => 'Registration',
            self::TECHNICAL_SUPPORT => 'Technical Support',
            self::CATERING => 'Catering',
            self::SECURITY => 'Security',
            self::PHOTOGRAPHY => 'Photography',
        };
    }
}
