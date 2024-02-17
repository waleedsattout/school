<?php

namespace App\Controllers;

use App\Models\Std;
use App\Models\Sub;
use App\Models\Cls;

class Modals extends BaseController
{

    protected $forge = "";
    protected $db = "";
    protected $std = "";
    protected $sub = "";
    protected $cls = "";
    protected $session = "";

    public function __construct()
    {
        $this->forge = \Config\Database::forge();
        $this->db = db_connect();
        $this->std = new Std();
        $this->sub = new Sub();
        $this->cls = new Cls();
        $this->session = session();
    }

    public function addStudent()
    {
        return view(
            'modals/add_student',
            [
                'classes' => $this->cls->getClasses(),
                'sections' => $this->sub->get_sec($this->cls->getClassSections($this->session->get('class'))),
            ] + $this->viewData
        );
    }

    public function addSum($subject, $section, $sem)
    {
        return view(
            'modals/add_sum',
            [
                'subject' => $this->sub->sub_name($subject),
                'class' => $this->cls->getClassByName($this->session->get('class')),
                'section' => '',
                'sem' => ($sem == '1' ? 'الأول' : ($sem == '2' ? 'الثاني' : '')),
                'data' => $this->sub->fake_sum($subject, $section),
                'max' => (int) $this->sub->get_subject_data($subject)['max'],
                'classes' => $this->cls->getClasses()
            ] + $this->viewData
        );
    }

    public function editStudent($id = null)
    {
        return view(
            'modals/edit_student',
            [
                'stdData' => $this->std->getStudentData($id),
                'classes' => $this->cls->getClasses(),
                'sections' => $this->sub->get_sec($this->cls->getClassSections($this->session->get('class'))),
            ] + $this->viewData
        );
    }

    public function editStudentMarks($id = null, $sub = null)
    {
        return view(
            'modals/edit_student_marks',
            [
                'stdMarks' => $this->std->getStudentMarks($id)[$sub],
                'stdData' => $this->std->getStudentData($id),
                'name' => $sub
            ] + $this->viewData
        );
    }

    public function addEditSubject($id = null)
    {
        if ($id != null) {
            $type = 'edit';
            $data = $this->sub->get_subject_data($id);
        } else {
            $type = 'add';
            $data = [
                'id' => '',
                'name' => '',
                'arabic' => '',
                'tutor' => '',
                'max' => '',
                'min' => '',
                'priority' => '',
                'sem' => '',
                'header' => ''
            ];
        }
        return view(
            'modals/add_edit_subject',
            [
                'classes' => $this->cls->getClasses(),
                'data' => $data,
                'type' => $type,
            ] + $this->viewData
        );
    }

    public function editClass($name = null)
    {
        return view(
            'modals/add_edit_class',
            [
                'data' => $this->cls->getClassByName($name, false),
                'type' => 1,
            ] + $this->viewData
        );
    }

    public function addClass()
    {
        $data = array(
            'id' => '',
            'class_id' => '',
            'name' => '',
            'arabic' => '',
            'sections' => ''
        );

        return view(
            'modals/add_edit_class',
            [
                'type' => 0,
                'data' => $data,
                'classes' => $this->cls->getClasses()
            ] + $this->viewData
        );
    }

    public function showClasses()
    {
        return view(
            'modals/show_classes',
            [
                'title' => 'show_classes',
                'from' => 'classes',
                'classes' => $this->cls->getClasses()
            ] + $this->viewData
        );
    }

    public function manageStudent($id = '')
    {
        if ($id == '') {
            session()->setFlashdata('error', 'يجب اختيار طالبة أولاً.');
            return redirect()->to('students/manage_student');
        }
        return view(
            'modals/manage_student',
            [
                'title' => 'إدارة الطلاب',
                'page_name' => 'manage_student',
                'from' => 'students',
                'subData' => $this->sub->get_subject_data(),
                'students' => $this->std->getStudents(),
                'classes' => $this->cls->getClasses(),
                'stdMarks' => $this->std->getStudentMarks($id),
                'stdData' => $this->std->getStudentData($id),
                'sections' => $this->sub->get_sec($this->cls->getClassSections($this->session->get('class'))),
            ] + $this->viewData
        );
    }
}
