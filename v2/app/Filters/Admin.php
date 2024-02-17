<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class Admin implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        if (session()->get('role') != 1) {
            session()->setFlashdata('error', "لست مخولاً بالدخول إلى هذه الصفحة.");
            return redirect()->to('/');
        } else if (session()->get('session_exp') - time() < 0) {
            session()->setFlashdata('error', "لقد انتهت مدة الجلسة، الرجاء تسجيل الدخول مرة أخرى.");
            return redirect()->to('login');
        }
    }

    //--------------------------------------------------------------------
    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
    }
}
