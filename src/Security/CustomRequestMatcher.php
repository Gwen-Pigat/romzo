<?php

namespace App\Security;

use Symfony\Component\HttpFoundation\Request;

class CustomRequestMatcher
{

    private CONST ROUTES = [
        "app_admin",
        "app_admin_login_call",
    ];

    public function matches(Request $request): bool
    {
        if(in_array($request->get("_route"), self::ROUTES)){
            return false;
        }
        return true;
    }

}
