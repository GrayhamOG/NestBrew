<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SanitizeInput
{
    // Fields that should NOT be sanitized (passwords, tokens, etc.)
    protected array $except = [
        'password',
        'password_confirmation',
        '_token',
    ];

    public function handle(Request $request, Closure $next): Response
    {
        $input = $request->all();
        $this->sanitize($input);
        $request->merge($input);

        return $next($request);
    }

    protected function sanitize(array &$data): void
    {
        foreach ($data as $key => &$value) {
            if (in_array($key, $this->except)) {
                continue;
            }

            if (is_array($value)) {
                $this->sanitize($value);
            } elseif (is_string($value)) {
                // Strip all HTML tags to prevent XSS
                $value = strip_tags($value);
                // Trim whitespace
                $value = trim($value);
                // Convert special characters to HTML entities as an extra layer
                $value = htmlspecialchars($value, ENT_QUOTES | ENT_HTML5, 'UTF-8', false);
            }
        }
    }
}