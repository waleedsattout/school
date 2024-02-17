<?php

namespace App\Filters;

use App\Libraries\Tokens;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class Api implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $token = new Tokens();
        if(!$token->checkToken()){
            echo json_encode(['message'=>'Envalid token', 'status'=>'bad']);
            http_response_code(404);
            die();
        }
    }
    //--------------------------------------------------------------------
    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
       
    }
}