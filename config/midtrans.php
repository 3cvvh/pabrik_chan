<?php
return  [
    "merchant_id" => env("MIDTRANS_MERCHANT_ID", "G448010771"),
    "client_key" => env("MIDTRANS_CLIENT_KEY", "Mid-client-IhWH5U7LksPTS0N_"),
    "server_key" => env("MIDTRANS_SERVER_KEY", "Mid-server-cppRZYH3WwdXfiDpEzwxvp56"),
    "is_production" => env("MIDTRANS_IS_PRODUCTION", false),
    "is_sanitized" => env("MIDTRANS_IS_SANITIZED", true),
    "is_3ds" => env("MIDTRANS_IS_3DS", true),
];
