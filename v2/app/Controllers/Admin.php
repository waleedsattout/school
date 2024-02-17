<?php

namespace App\Controllers;

class Admin extends BaseController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
    }

    public function change($env = 'p')
    {
        $file = __DIR__ . '/../../' . (($env == "p") ? "production" : "development");
        $newfile = __DIR__ . '/../../.env';
        if (!copy($file, $newfile)) {
            session()->setFlashdata("error", "failed to copy ");
        } else {
            session()->setFlashdata("success", "copied");
        }
        return redirect()->to("$this->viewData['locale'] ./");
    }
}
