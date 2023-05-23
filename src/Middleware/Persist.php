<?php

namespace BrainBoxLabs\PersistQuery\Middleware;

use Closure;
use Illuminate\Http\Request;

class Persist
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next, ...$methods)
    {
        $response = $next($request);

        if (method_exists($response, 'status') && $response->status() == 302) {
            $target_url = $this->stripQuery($response->headers->get('location'));

            $target_path = trim(parse_url($target_url, PHP_URL_PATH), '/');
            $key = $this->generateKeyFrom($target_path);

            if ($this->canRestoreRedirectQueryParameters($key, $target_url)) {
                $response->headers->set('location', $this->getRestoredUrl($key, $target_url));
            }

            return $response;
        }

        if ( ! in_array($request->route()->getActionMethod(), $methods)) {
            return $response;
        }

        $key = $this->generateKeyFrom($request->path());

        if ($this->canRestoreQueryParameters($key)) {
            session()->reflash();
            
            return redirect($this->getRestoredUrl($key, $request->url()));
        }

        session()->put($key, $request->query());

        return $response;
    }

    private function canRestoreQueryParameters($key)
    {
        $previous_url = $this->stripQuery(url()->previous());
        $current_url  = $this->stripQuery(url()->current());

        $current_url_query = parse_url(url()->full(), PHP_URL_QUERY);

        return $current_url != $previous_url && !empty(session()->get($key)) && empty($current_url_query);
    }

    private function canRestoreRedirectQueryParameters($key, $target_url)
    {
        $previous_url = $this->stripQuery(url()->previous());

        return $target_url == $previous_url && !empty(session()->get($key));
    }

    private function generateKeyFrom($path)
    {
        return sprintf('retained_query_parameters.%s', str_replace('/', '_', $path));
    }

    private function stripQuery($url)
    {
        return explode('?', $url)[0];
    }

    private function getRestoredUrl($key, $destination_url) 
    {
        return vsprintf('%s?%s', [
            $destination_url,
            http_build_query(session()->pull($key)),
        ]);
    }
}
