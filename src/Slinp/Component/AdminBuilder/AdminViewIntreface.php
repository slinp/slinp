<?php

namespace \home\daniel\www\dantleech\slinp\src\Slinp\Component\AdminBuilder;

use Symfony\Component\HttpFoundation\Request;

interface AdminViewIntreface
{
    public function setAdmin(Admin $admin);

    public function handleRequest(Request $request);
}
