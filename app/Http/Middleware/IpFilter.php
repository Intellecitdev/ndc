<?php

namespace App\Http\Middleware;

use App\Models\IpAudit;
use App\Models\IpFilter as IpFilterRule;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Admin > IP Filtering: active blacklist entries are refused; when any active
 * whitelist entry exists, only whitelisted IPs get in. Refusals go to IP Auditing.
 */
class IpFilter
{
    public function handle(Request $request, Closure $next): Response
    {
        $rules = IpFilterRule::where('is_active', true)->get(['ip_address', 'type']);
        $ip = $request->ip();

        $reason = null;
        if ($rules->where('type', 'blacklist')->contains('ip_address', $ip)) {
            $reason = 'Blacklisted';
        } elseif ($rules->where('type', 'whitelist')->isNotEmpty() && ! $rules->where('type', 'whitelist')->contains('ip_address', $ip)) {
            $reason = 'Not Whitelisted';
        }

        if ($reason) {
            IpAudit::record($reason);
            abort(403, 'Your IP address is not allowed to access this system.');
        }

        return $next($request);
    }
}
