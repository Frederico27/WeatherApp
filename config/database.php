<?php

function getDatabaseConfig(): array
{

    return [
        "database" => [
            "test" => [

                "url" => "mysql:host=localhost:3306;dbname=weatherapp_test",
                "username" => "root",
                "password" => ""
            ],
            "prod" => [

                "url" => "mysql:host=localhost:3306;dbname=weatherapp",
                "username" => "root",
                "password" => ""
            ]
        ]
    ];
}
