<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class Auth implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        if (count($request->uri->getSegments()) == 0)
            return redirect()->to($request->config->supportedLocales[0] . '/');

        $locale = $request->uri->getSegments()[0];

        $current = (string)current_url(true)
            ->setHost('')
            ->setScheme('')
            ->stripQuery('token');

        $routes = [
            '/' . $locale . '/login',
            '/' . $locale . '/validate_login',
            '/' . $locale . '/logout',
            route_to('login'),
            route_to('validate_login'),
            route_to('logout')
        ];

        if (in_array((string)$current, $routes)) {
            if (session()->get('logged_in')) {
                session()->setFlashdata('success', "لقد سجلت دخولك مسبقاً.");
                if ($current != previous_url() && str_contains(previous_url(), $locale)) {
                    if (redirect()->back()->headers()['Location']->getValue() != previous_url())
                        return redirect()->back();
                    return redirect()->to($locale . '/students/manage_student');
                }
            }
        } else {
            if (session()->get('logged_in') !== true) {
                session()->setFlashdata('error', "يجب تسجيل الدخول قبل استخدام الموقع.");
                return redirect()->to($request->config->supportedLocales[0] . '/login');
            }
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
    }
}
