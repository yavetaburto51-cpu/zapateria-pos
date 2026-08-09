<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;

class SecurityLogger
{
    /**
     * Log a security event with structured JSON format.
     */
    public static function log(string $event, string $message, array $context = [], string $level = 'info'): void
    {
        $payload = array_merge([
            'timestamp_utc' => now('UTC')->toIso8601String(),
            'event' => $event,
            'ip' => request()->ip(),
            'user_id' => auth()->id() ?? 'guest',
            'user_email' => auth()->user()?->email ?? null,
            'user_agent' => request()->userAgent(),
            'url' => request()->fullUrl(),
            'message' => $message,
        ], $context);

        Log::channel('single')->log($level, "[SECURITY_AUDIT] " . json_encode($payload, JSON_UNESCAPED_UNICODE));
    }
}
