<?php

namespace App\Controllers;

class Classes extends BaseController
{

    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        return redirect()->to(base_url($this->viewData['locale'] . '/classes/manage_classes'));
    }

    public function manageClasses()
    {
        return view(
            'frontend/index',
            [
                'page_name' => 'manage_classes',
                'title' => 'إدارة الصفوف',
                'from' => 'classes',
                'classes' => $this->cls->getClasses()
            ] + $this->viewData
        );
    }

    public function addClass()
    {
        $this->cls->addClass(
            $this->request->getPost('id'),
            $this->request->getPost('name'),
            $this->request->getPost('arabic'),
            $this->request->getPost('sections'),
        );
        $this->session->setFlashdata('success', 'تم إضافة الصف بنجاح.');
        return redirect()->to(base_url($this->viewData['locale'] . '/subjects/manage_subject'));
    }

    public function editClass()
    {
        if (
            $this->cls->editClass(
                $this->request->getPost('id'),
                $this->request->getPost('class_id'),
                $this->request->getPost('name'),
                $this->request->getPost('arabic'),
                $this->request->getPost('sec')
            )
        ) {
            $this->session->setFlashdata('success', 'تم تعديل بيانات الصف.');
            return redirect()->to(base_url($this->viewData['locale'] . '/classes/manage_classes'));
        }
        $this->session->setFlashdata('error', 'لم يتم تعديل بيانات الصف.');
        return redirect()->to(base_url($this->viewData['locale'] . '/classes/manage_classes'));
    }

    public function deleteClass($id)
    {
        $this->cls->deleteClass($id);
        $this->session->setFlashdata('success', 'تم حذف الصف.');
        return redirect()->to(base_url($this->viewData['locale'] . '/classes/manage_classes'));
    }

    public function changeClass($class = 'c12')
    {
        try {
            $this->session->set('class', $class);
            echo session()->get('class');
            header("HTTP/1.1 200 Done Greatly");
            exit;
        } catch (\CodeIgniter\Exceptions\PageNotFoundException $e) {
            echo 'Caught exception: UnKnown Error Code';
            header("HTTP/1.1 501 " . 'Caught exception: ',  $e->getMessage(), "\n");
            exit;
        }
    }
}
