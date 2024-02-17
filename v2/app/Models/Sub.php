<?php

namespace App\Models;

use App\Models\Cls as ModelsCls;
use App\Models\Std as ModelsStd;
use CodeIgniter\Model;

class Sub extends Model
{
    protected $forge = "";
    protected $db = "";
    protected $std = "";
    protected $cls = "";
    protected $session = "";

    public function __construct()
    {
        $this->forge = \Config\Database::forge();
        $this->db = \Config\Database::connect();
        $this->session = session();
        $this->std = new ModelsStd();
        $this->cls = new ModelsCls();
    }

    /**
     * Get subjects max and min sum
     * @return array
     */
    public function getSubjectsMaxMinSum($sem = '')
    {
        $max = $min = 0;
        foreach ($this->get_subjects() as $sub) {
            if ($sem == 1 && $sub['sem'] != 1)
                continue;
            if ($sem == 2 && $sub['sem'] != 2)
                continue;
            $max += $sub["max"];
            $min += $sub["min"];
        }
        return [$max, $min];
    }


    // ============
    // we are here.
    // ============

    public function add_sub($colName, $colNameArabic, $tutor, $max, $min)
    {
        $fields = [
            $colName => [
                'type' => 'LONGTEXT',
                'default' => '0,0,0,0-0,0,0,0'
            ],
        ];
        $this->forge->addColumn('subjectsmarks_' . $this->session->get('class'), $fields);
        $builder = $this->db->table('subjects_' . $this->session->get('class'));
        $data = [
            'name' => $colName,
            'arabic' => $colNameArabic,
            'tutor' => $tutor,
            'max' => $max,
            'min' => $min
        ];
        $builder->insert($data);
    }

    public function edit_sub($id, $name, $arabic, $tutor, $prio, $max, $min)
    {
        if ($id == null) {
            $this->session->setFlashdata('error', 'لم يتم تعديل بيانات المادة، بسبب حدوث خطأ.');
            return redirect()->to(base_url($this->viewData['locale'] . 'subjects/manage_subject'));
        }
        $data = [
            'name' => $name,
            'arabic' => $arabic,
            'tutor' => $tutor,
            'priority' => $prio,
            'max' => $max,
            'min' => $min
        ];
        $builder = $this->db->table('subjects_' . $this->session->get('class'));
        $builder->where('id', $id);
        $builder->update($data);
        $this->session->setFlashdata('success', 'تم تعديل بيانات المادة.');
        return redirect()->to(base_url($this->viewData['locale'] . '/students/manage_student'));
    }

    public function del_sub($id)
    {
        $builder = $this->db->table('subjects_' . $this->session->get('class'));
        $colName = $builder->where(['id' => $id])->get()->getResult()[0]->name;
        $this->forge->dropColumn('subjectsmarks_' . $this->session->get('class'), $colName);
        $builder->delete(['id' => $id]);
    }

    public function get_subject_data($id = null, $sem = null)
    {
        $builder = $this->db->table('subjects_' . $this->session->get('class'));
        $data = [];
        if ($id == null && $sem == null) {
            return $builder->get()->getResultArray();
        } else if ($id != null) {
            $query = $builder->where('id', $id)->get()->getResultArray()[0];
            foreach ($query as $key => $value) {
                $data[$key] = $value;
            }
            return $data;
        } else {
            $query = $builder->where('sem', $sem)->get()->getResultArray();
            foreach ($query as $key => $value) {
                $data[$key] = $value;
            }
            return $data;
        }
    }

    //من أجل المحصلة
    public function get_sum($id = null, $sec = null)
    {
        $class = $this->session->get('class');
        $builder = $this->db->table('subjectsmarks_' . $class)->orderBy("studentID", "asc");
        $data = [];
        if ($id == null) {
            // return $builder->get()->getResultArray();
        } else {
            $name = $this->db->table('subjects_' . $class)->where('id', $id)->get()->getResultArray()[0]['name'];
            $query = $builder->select($name)->get()->getResultArray();
            $query1 = $builder->select('studentID')->get()->getResultArray();
            $i = 0;
            foreach ($query as $key => $value) {
                $std = $this->std->getStudents(false, '*', ['id' => $query1[$i]['studentID']], 0);
                if ($std != null) {
                    $std = $std[0];
                    if ($sec != null)
                        if ($sec == $std['section'])
                            $data[$this->std->id2name($query1[$i]['studentID'])['name']] = $value[$name];
                }
                $i++;
            }
            return $data;
        }
    }

    public function sub_name($id = null, $lang = 'arabic')
    {
        $data = [];
        if ($id == null) {
            // return $builder->get()->getResultArray();
        } else {
            if ($lang == 'arabic') {
                $name = $this->db->table('subjects_' . $this->session->get('class'))->where('id', $id)->get()->getResultArray()[0]['arabic'];
                return $name;
            } else {
                $name = $this->db->table('subjects_' . $this->session->get('class'))->where('id', $id)->get()->getResultArray()[0]['name'];
                return $name;
            }
        }
    }

    public function get_subjects()
    {
        $builder = $this->db->table('subjects_' . $this->session->get('class'));
        return $builder->get()->getResultArray();
    }

    //subject id
    public function fake_sum($id = null, $sec = null)
    {
        if ($id == null) {
            // return $builder->get()->getResultArray();
        } else {
            $builder = $this->db->table('subjectsmarks_' . $this->session->get('class'))->orderBy("studentID", "asc");
            $data = [];
            $name = $this->sub_name($id, 'name');
            $query = $builder->select($name)->get()->getResultArray();
            $query1 = $builder->select('studentID')->get()->getResultArray();
            $i = 0;
            foreach ($query as $key => $value) {
                $stdData = $this->std->getStudentData($query1[$i]['studentID']);
                if ($stdData === -1) {
                    $i++;
                    continue;
                } else if ($stdData['section'] == $sec) {
                    $data[] = [
                        'name' => $this->std->id2name($query1[$i]['studentID'])['name'],
                        'marks' => $value[$name],
                        'id' => $stdData['id'],
                    ];
                }
                $i++;
            }
            return $data;
        }
    }

    public function get_sec($count = '3')
    {
        if ($count == '1') {
            $name = [
                1 => 'الأولى',
            ];
        } else if ($count == '2') {
            $name = [
                1 => 'الأولى',
                2 => 'الثانية',
            ];
        } else {
            $name = [
                1 => 'الأولى',
                2 => 'الثانية',
                3 => 'الثالثة'
            ];
        }
        return $name;
    }

    public function order()
    {

        return redirect()->to(base_url($this->viewData['locale'] . '/students/manage_student'));
    }
}
