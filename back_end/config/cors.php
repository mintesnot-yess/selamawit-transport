<?php

return [
    "paths" => ["api/*", "sanctum/csrf-cookie", "login", "register"],
    "allowed_methods" => ["*"],
    "allowed_origins" => ["*"], // For development only
    "allowed_origins_patterns" => [],
    "allowed_headers" => ["*"],
    "exposed_headers" => [],
    "max_age" => 0,
    "supports_credentials" => false,
];
