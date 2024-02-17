<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class checkDb implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $db = db_connect();
        if (!$db->tableExists('students'))
            return redirect()->to('startup');
    }
    //--------------------------------------------------------------------
    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {

    }
}