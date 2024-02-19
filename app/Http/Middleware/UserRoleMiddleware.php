<?php

namespace App\Http\Middleware;

use App\Models\RolePermission;
use App\Models\route;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route as FacadesRoute;
use Symfony\Component\HttpFoundation\Response;

class UserRoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // $uri = $request->route()->uri;
        $routeName = FacadesRoute::currentRouteName();  
        $CleanRouteName = str_replace(['.', ':'], ['_', '_'], $routeName);
        $role_id = session('LoggedUser'); // Handle potentially missing session data

        if ($role_id) {
            // dd($role_id);
            $allowedRoutes = Route::whereIn('id', RolePermission::where('role_id', $role_id)->pluck('route_id'))
                ->pluck('route')
                ->toArray();
            // dd($allowedRoutes);
            if (in_array($CleanRouteName, $allowedRoutes)) {
                return $next($request);
            }
        }
        $page = explode('/', $CleanRouteName)[0];
        // Handle both unauthorized access and missing session:
        return redirect()->to('login')->with('access', 'You are not authorized to access the '.$page.' page');
        // return view('unauthorized',compact('uri'));
    }

    // public function handle(Request $request, Closure $next): Response
    // {
    //     // Define public routes that do not require permission
    //     $publicRoutes = ['/', 'login', 'register', 'products', 'getLogin'];

    //     // Get the URI of the current request
    //     $uri = $request->route()->uri;

    //     // Check if the URI is in the public routes, if so, allow the request to proceed
    //     if (in_array($uri, $publicRoutes)) {
    //         return $next($request);
    //     }

    //     // Get the role_id from the session
    //     $role_id = session('role_id') ?? '';


    //     if ($role_id) {
    //         // Retrieve the allowed routes for the given role_id
    //         $allowedRoutes = RolePermission::where('role_id', $role_id)->get();

    //         foreach ($allowedRoutes as $allowedRoute) {
    //             // Get the allowed URI for each route
    //             $allowedUri = $allowedRoute->uri;
    //             dd($allowedUri);


    //             // Check if the URI has more than two segments
    //             if (count(explode('/', $uri)) > 2) {
    //                 // Check if the allowed URI is present in the current URI
    //                 if (strstr($uri, $allowedUri)) {

    //                     return $next($request);
    //                 }
    //             } else {
    //                 // Check if the current URI matches the allowed URI
    //                 if ($uri === $allowedUri) {
    //                     return $next($request);
    //                 }
    //             }
    //         }

    //         // If the URI is not allowed for the role, redirect to 'Notfound'
    //         return redirect()->to('getLogin');
    //     } else {
    //         // If there is no role_id in the session, redirect to 'Notfound'
    //         return redirect()->to('getLogin');
    //     }
    // }
    // public function handle(Request $request, Closure $next , $role): Response
    // {

    //     if (Auth::check() && Auth::user()->role == $role) {
    //         abort(403, 'You are not authorized to access this page');
    //     }
    //     return $next($request);
    // }
}
