<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class Locale implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $expectedLocale = null;
        $segments = $request->getUri()->getSegments();
        $supportedLocales = $request->config->supportedLocales;
        $skipCheckingForLocaleIn = [
            '/get',
            '/BackupDb',
            '/change_class',
        ];

        if (count($segments) > 0) {
            $expectedLocale = $segments[0];
        }

        if (in_array($expectedLocale, $segments)) {
            \Config\Services::language()->setLocale($expectedLocale);
            session()->set('language', $expectedLocale);
        } else {
            foreach ($skipCheckingForLocaleIn as $word)
                if (str_contains($request->getUri()->getPath(), $word))
                    return;

            if (session()->get('language') == null) {
                \Config\Services::language()->setLocale('ar');
                session()->set('language', 'ar');
            }
            return redirect()->to('/' . $supportedLocales[0]);
        }
    }
    //--------------------------------------------------------------------
    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
    }
}
