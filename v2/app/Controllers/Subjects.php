<?php

namespace App\Controllers;

class Subjects extends BaseController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        return redirect()->to(base_url($this->viewData['locale'] . '/subjects/add_sum'));
    }

    public function delSubject($id = null)
    {
        $this->sub->del_sub($id);
        $this->session->setFlashdata('success', 'تم حذف المادة بنجاح.');
        return redirect()->to(base_url($this->viewData['locale'] . '/subjects/manage_subject'));
    }

    public function addEditSubject()
    {
        if (!empty($_POST)) {
            if ($this->request->getPost('type') === 'add') {
                $this->sub->add_sub(
                    $this->request->getPost('name'),
                    $this->request->getPost('arabic'),
                    $this->request->getPost('tutor'),
                    $this->request->getPost('max'),
                    $this->request->getPost('min')
                );
                $this->session->setFlashdata('success', 'تم إضافة المادة بنجاح.');
            } else if ($this->request->getPost('type') === 'edit') {
                $this->sub->edit_sub(
                    $this->request->getPost('id'),
                    $this->request->getPost('name'),
                    $this->request->getPost('arabic'),
                    $this->request->getPost('tutor'),
                    $this->request->getPost('prio'),
                    $this->request->getPost('max'),
                    $this->request->getPost('min'),
                );
            }
        }
        return redirect()->to(base_url($this->viewData['locale'] . '/subjects/manage_subject'));
    }

    /*
    المحصلة
    */
    public function sum($id = null, $sec = null, $sem = null)
    {
        return view('frontend/index', [
            'title' => 'المحصلة',
            'page_name' => 'custom_sum',
            'Class' => $this->cls->getClassByName($this->session->get('class')),
            'sec' => $this->sub->get_sec()[$sec ?? 1],
            'sem' => $sem,
            'from' => 'subjects',
            'subData' => $this->sub->get_subject_data($id),
            'sub' => $this->sub->sub_name($id),
            'status' => ($id == null) ? '0' : '1',
            'subjects' => $this->sub->get_subjects(),
            'moh' => $this->sub->get_sum($id, $sec),
            'classes' => $this->cls->getClasses(),
            'sections' => $this->sub->get_sec($this->cls->getClassSections($this->session->get('class'))),
        ] + $this->viewData);
    }

    public function manageSubject($id = null)
    {
        return view('frontend/index', [
            'title' => 'إدارة مادة',
            'page_name' => 'manage_subjects',
            'from' => 'subjects',
            'status' => ($id == null) ? '0' : '1',
            'subjects' => $this->sub->get_subjects(),
            'classes' => $this->cls->getClasses()

        ] + $this->viewData);
    }

    public function add_sum()
    {
        $class = $this->session->get('class');
        if (!empty($_POST)) {
            $name = $this->sub->sub_name($this->request->getPost('sub'), 'name');
            $index = ($this->request->getPost('sem') == '1') ? 1 : 0;

            $builder = $this->db->table('subjectsmarks_' . $class)->orderBy("studentID", "asc");
            $arr = array_keys(json_decode((string)$this->request->getPost('data'), true));
            $i = 0;
            foreach ($arr as $key => $value) {
                $marks = $builder->select($name)->where('studentID', $value)->get()->getResultArray()[0];
                $mark = explode('-', $marks[$name])[$index];
                if ($index == 1) {
                    $data = [
                        $name => json_decode((string)$this->request->getPost('data'), true)[$value] . '-' . $mark
                    ];
                } else {
                    $data = [
                        $name => $mark . '-' . json_decode((string)$this->request->getPost('data'), true)[$value]
                    ];
                }
                $builder1 = $this->db->table('subjectsmarks_' . $class);
                $builder1->where('studentID', $value);
                $builder1->update($data);
                $i++;
            }
            $this->session->setFlashdata('success', 'تم تعديل إضافة المحصلة بنجاح.');
            $this->std->updateAvg();
            return redirect()->to(base_url($this->viewData['locale'] . '/subjects/add_sum'));
        } else if (!$_GET) {
            return view(
                'frontend/index',
                [
                    'page_name' => 'add_sum',
                    'from' => 'subjects',
                    'title' => 'إضافة محصلة',
                    'sections' => $this->sub->get_sec($this->cls->getClassSections($class)),
                    'students' => $this->std->getStudents(),
                    'subjects' => $this->sub->get_subjects(),
                    'classes' => $this->cls->getClasses()
                ] + $this->viewData
            );
        }
    }

    //TODO:
    public function order()
    {
        if (!empty($_POST)) {
        } else {
            return view('frontend/index', [
                'page_name' => 'order',
                'from' => 'subjects',
                'title' => 'ترتيب المواد',
                'subjects' => $this->sub->get_subjects(),
                'classes' => $this->cls->getClasses()
            ] + $this->viewData);
        }
    }
}
