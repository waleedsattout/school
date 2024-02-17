<?php
namespace App\Controllers;

require_once ROOTPATH . 'vendor/autoload.php';


class WLP extends BaseController
{

    public function __construct()
    {
        parent::__construct();
    }

    public function students()
    {
        if (!empty($_GET['class']) && $_GET['class'] != '')
            session()->set('class', $_GET['class']);
        return $this->response
            ->setStatusCode(200)
            ->setJson(json_encode($this->std->getStudents(), JSON_UNESCAPED_UNICODE));
    }

    public function classes()
    {
        if (!empty($_GET['class']) && $_GET['class'] != '')
            session()->set('class', $_GET['class']);
        return $this->response
            ->setStatusCode(200)
            ->setJson(json_encode($this->cls->getClasses(), JSON_UNESCAPED_UNICODE));
    }

    public function subjects()
    {
        if (!empty($_GET['class']) && $_GET['class'] != '')
            session()->set('class', $_GET['class']);
        return $this->response
            ->setStatusCode(200)
            ->setJson(json_encode($this->sub->get_subjects(), JSON_UNESCAPED_UNICODE));
    }

    public function sections()
    {
        if (!empty($_GET['class']) && $_GET['class'] != '')
            session()->set('class', $_GET['class']);
        $count = $this->cls->getClassSections(session()->get('class'));
        if ($count == '1') {
            $name = [
                [
                    'id' => 1,
                    'name' => 'الأولى',
                ]
            ];
        } else if ($count == '2') {
            $name = [
                [
                    'id' => 1,
                    'name' => 'الأولى',
                ],
                [
                    'id' => 2,
                    'name' => 'الثانية',
                ]
            ];
        } else {
            $name = [
                [
                    'id' => 1,
                    'name' => 'الأولى',
                ],
                [
                    'id' => 2,
                    'name' => 'الثانية',
                ],
                [
                    'id' => 3,
                    'name' => 'الثالثة',

                ]
            ];
        }
        return $this->response
            ->setStatusCode(200)
            ->setJson(json_encode($name, JSON_UNESCAPED_UNICODE));
    }
}