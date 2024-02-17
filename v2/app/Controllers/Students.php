<?php

namespace App\Controllers;

class Students extends BaseController
{
    protected $settings;
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        return redirect()->to($this->viewData['locale'] . '/students/manage_student');
    }

    public function manageStudent()
    {
        return view(
            'frontend/index',
            [
                'title' => 'إدارة الطلاب',
                'page_name' => 'manage_student',
                'from' => 'students',
                'subjects' => $this->sub->get_subjects(),
                'students' => $this->std->getStudents(),
                'classes' => $this->cls->getClasses()
            ] + $this->viewData
        );
    }

    public function editStudentMarks()
    {
        if (!empty($_POST)) {
            $marks1 = implode(
                ',',
                [
                    (int) $this->request->getPost('sh1'),
                    (int) $this->request->getPost('hom1'),
                    (int) $this->request->getPost('test1'),
                    (int) $this->request->getPost('fin1')
                ]
            );
            $marks2 = implode(
                ',',
                [
                    (int) $this->request->getPost('sh2'),
                    (int) $this->request->getPost('hom2'),
                    (int) $this->request->getPost('test2'),
                    (int) $this->request->getPost('fin2')
                ]
            );
            $this->std->editStdMarks(
                $this->request->getPost('id'),
                $this->request->getPost('Name'),
                $marks1 . '-' . $marks2
            );
            return $this->manageStudent();
        }
    }

    public function deleteStudent($id = null)
    {
        $this->std->delStd($id);
        return redirect()->to(base_url($this->viewData['locale'] . '/students/manage_student'));
    }

    public function editStudent()
    {
        if (!empty($_POST)) {
            $this->std->editStd(
                $this->request->getPost('id'),
                $this->request->getPost('firstName'),
                $this->request->getPost('lastName'),
                $this->request->getPost('fatherName'),
                $this->request->getPost('motherName'),
                $this->request->getPost('dob'),
                $this->request->getPost('section'),
                $this->request->getPost('class')
            );
            return $this->manageStudent();
        }
    }

    public function hideStudent($id = null)
    {
        if (!empty($_POST)) {
            $this->std->hideStudents(json_decode((string)$this->request->getPost('data')));
            $this->session->setFlashdata('success', 'تمت المهمة بنجاح.');
            return redirect()->to(base_url($this->viewData['locale'] . '/students/manage_student'));
        }
        if ($id != null) {
            if ($this->std->hideStudent($id))
                return 'تم إخفاء الطالبة بنجاح';
            else
                return $this->manageStudent();
        }
    }

    public function addStudent()
    {
        if (!empty($_POST)) {
            $this->std->addStd(
                $this->request->getPost('firstName'),
                $this->request->getPost('lastName'),
                $this->request->getPost('fatherName'),
                $this->request->getPost('motherName'),
                $this->request->getPost('dob'),
                $this->session->get('class'),
                $this->request->getPost('section')
            );
            $this->session->setFlashdata('success', 'تم إضافة طالب بنجاح.');
            return $this->manageStudent();
        }
    }

    public function editBehav()
    {
        if (!empty($_POST)) {
            $this->std->editBehav(json_decode((string) $this->request->getPost('data'), true));
            $this->session->setFlashdata('success', 'تم تعديل السلوك بنجاح');
            return redirect()->to(base_url($this->viewData['locale'] . '/students/certificate'));
        }
        return view(
            'frontend/index',
            [
                'page_name' => 'edit_behav',
                'from' => 'students',
                'title' => 'تعديل السلوك',
                'sections' => $this->sub->get_sec($this->cls->getClassSections($this->session->get('class'))),
                'students' => $this->db->table('students')->where('class', $this->session->get('class'))->get()->getResultArray(),
                'subjects' => $this->sub->get_subjects(),
                'data' => $this->std->getBehav(),
                'classes' => $this->cls->getClasses()
            ] + $this->viewData
        );
    }

    public function editAbsent()
    {
        if (!empty($_POST)) {
            $this->std->editAbsent(json_decode((string) $this->request->getPost('data'), true));
            $this->session->setFlashdata('success', 'تم تعديل الغياب بنجاح');
            return redirect()->to(base_url($this->viewData['locale'] . '/students'));
        }
        return view(
            'frontend/index',
            [
                'page_name' => 'edit_absent',
                'from' => 'students',
                'title' => 'تعديل الغياب',
                'sections' => $this->sub->get_sec($this->cls->getClassSections($this->session->get('class'))),
                'students' => $this->db->table('students')->where('class', $this->session->get('class'))->orderBy('id')->get()->getResultArray(),
                'subjects' => $this->sub->get_subjects(),
                'classes' => $this->cls->getClasses(),
                'data' => $this->std->getAbsent()
            ] + $this->viewData
        );
    }

    /**
     * Download all certificates as Exsel files.
     */
    public function cert()
    {
        $this->session->get('class') == 'c12' ? $this->std->c12_cert() : $this->std->c10_cert();
    }

    public function certificate($id = null)
    {
        if ($id == null)
            return redirect()->to(base_url($this->viewData['locale'] . '/students'));

        $builder = $this->db->table('subjects_' . $this->session->get('class'));
        $sec1 = $builder->where('sem', '1')->countAllResults();
        $sec2 = $builder->where('sem', '2')->countAllResults();
        return view('frontend/index', [
            'title' => 'الجلاء المدرسي',
            'from' => 'students',
            'page_name' => 'custom_certificate',
            'subData' => $this->sub->get_subject_data(),
            'subData1' => $this->sub->get_subject_data(null, 1),
            'subData2' => $this->sub->get_subject_data(null, 2),
            'stdData' => $this->std->getStudentData($id),
            'stdMarks' => $this->std->getStudentMarks($id),
            'sec1' => $sec1,
            'sh' => $this->sub->get_sec()[$this->std->getStudentData($id)['section']],
            'sec2' => $sec2,
            'status' => '1',
            'Class' => $this->cls->getClassByName($this->session->get('class'), false)['arabic'],
            'classes' => $this->cls->getClasses(),
            'showFasel2' => $this->settings->getShowFasel2(),
            'actualAttendance1' => $this->settings->getActualAttendance(1),
            'actualAttendance2' => $this->settings->getActualAttendance(2),
            'year' => $this->settings->getYear(),
        ] + $this->viewData);
    }

    public function temp()
    {
        echo '<pre>';
        var_export($this->std->getRanks());
        echo '</pre>';
    }
}
