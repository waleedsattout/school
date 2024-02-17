<?php
namespace App\Controllers;

use App\Controllers\BaseController;

class BackupDb extends BaseController
{
    public function index()
    {
    $db = db_connect();
    try {
            $dump = new Mysqldump('mysql:host='.$db->hostname.';dbname='.$db->database, $db->username, $db->password);
            $dump->start(__DIR__.'/../../school.sql');
            Session()->setFlashdata('success', 'تم عمل نسخة احتياطية بنجاح');
            return redirect()->to(site_url('/',env('protocol')).'./../../school.sql');
        } catch (\Exception $th) {
            Session()->setFlashdata('error', $th->getMessage());
            return redirect()->to('/');
        }

    }
}