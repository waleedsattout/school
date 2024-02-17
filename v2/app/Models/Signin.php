<?php

namespace App\Models;

use CodeIgniter\Model;
use App\Libraries\Tokens;

class Signin extends Model
{
    protected $db = "";
    protected $session = "";
    protected $cls = "";

    public function __construct()
    {
        $this->db = db_connect();
        $this->cls = new Cls();
        $this->session = session();
    }
    /**
     * @param string $username
     * @param string $password
     */
    function validateLogin($username, $password)
    {
        if ($this->db->table('users')->where(['username' => $username])->countAllResults() > 0) {
            $data = $this->db->table('users')->where(['username' => $username, 'password' => sha1($password)]);
            if ($data->countAllResults() > 0) {
                $row = $data->get()->getResultArray()[0];
                if ($row['access'] == 'all') {
                    if ($this->db->table('classes')->countAll() > 0)
                        $cl = $this->cls->getClasses()[0]->name;
                    else
                        $cl = null;
                } else {
                    $cl = $row['access'];
                }

                $this->session->set('user_id', $row['id']);
                $this->session->set('logged_in', true);
                $this->session->set('role', $row['role']);
                $this->session->set('class', $cl);
                $this->session->set('session_exp', (time() + 3600));
                $token = new Tokens();
                $_SESSION['jwt'] = $token->setToken();
                $this->session->markAsTempdata('jwt', 100);
                return $row['username'];
            } else {
                $this->session->setFlashdata('error', 'لقد أدخلت كلمة مرور خاطئة');
                return redirect()->to('/login');
            }
        } else {
            $this->session->setFlashdata('error', 'لقد أدخلت بيانات خاطئة');
            return redirect()->to('login');
        }
    }
}
