<?php

namespace Frederico\Weather\App\Controller;

use Frederico\Weather\App\App\View;


class PageNotFoundController
{

    function index()
    {
        View::render(
            'NotFound_404',
            ["title" => "Pajina La Existe"]
        );
    }
}
