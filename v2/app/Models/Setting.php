<?php

namespace App\Models;

use CodeIgniter\Model;

class Setting extends Model
{
    protected $forge = "";
    protected $db = "";
    protected $std = "";
    protected $session = "";

    public function __construct()
    {
        $this->forge = \Config\Database::forge();
        $this->db = db_connect();
        $this->session = session();
    }

    function getYear()
    {
        return $this->db->table('settings')->select('*')->where('name', 'date')->get()->getResultArray()[0]['value'];
    }

    function setYear($year)
    {
        if (strlen($year) == 9 && $year[4] == '-')
            $this->db->table('settings')->select('*')->where('name', 'date')->update(['value' => $year]);
    }
    function getActualAttendance($fasel)
    {
        return $this->db->table('settings')->select('*')->where('name', 'actualAttendance' . $fasel)->get()->getResultArray()[0]['value'];
    }

    function setActualAttendance($fasel, $attend)
    {
        $this->db->table('settings')->select('*')->where('name', 'actualAttendance' . $fasel)->update(['value' => $attend]);
    }
    
    function getShowFasel2()
    {
        return $this->db->table('settings')->select('*')->where('name', 'showFasel2')->get()->getResultArray()[0]['value'];
    }

    function setShowFasel2($value)
    {
        $this->db->table('settings')->select('*')->where('name', 'showFasel2')->update(['value' => $value]);
    }

    function setClassesOrder($value)
    {
        $this->db->table('settings')->select('*')->where('name', 'classes_arrangement')->update(['value' => "$value"]);
    }
    
    function getClassesOrder()
    {
        $value = $this->db->table('settings')->select('*')->where('name', 'classes_arrangement')->get()->getResultArray()[0]['value'];
        $arr = explode('-', $value);
        $result = [];
        foreach ($arr as $key => $value) {
            if ($value == $arr[count($arr) - 1]) {
                $result[$value] = 'exit';
            } else {
                $result[$value] = $arr[$key + 1];
            }
        }
        return $result;
    }
}
