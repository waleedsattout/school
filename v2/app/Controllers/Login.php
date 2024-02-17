<?php

namespace App\Controllers;

use App\Models\Signin;

class Login extends BaseController
{
    protected $sign;
    public function __construct()
    {
        parent::__construct();
        $this->sign = new Signin();
    }

    public function index()
    {
        return view(
            'frontend/index',
            [
                'page_name' => 'login',
                'from' => 'login',
                'title' => 'تسجيل الدخول',
                'classes' => $this->cls->getClasses()
            ] + $this->viewData
        );
    }

    public function logout()
    {
        $this->session->destroy();
        return redirect()->to('ar/login');
    }

    public function validate_login()
    {
        if (!empty($_POST)) {
            $username = $this->request->getPost('userName');
            $password = (string)$this->request->getPost('password');
            $username = $this->sign->validateLogin($username, $password);

            $this->session->setFlashdata('success', 'مرحبا بك ' . $username);
            return redirect()->to(base_url($this->viewData['locale'] . '/students/manage_student'));
        }
    }
}
