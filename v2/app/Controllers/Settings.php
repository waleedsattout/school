<?php

namespace App\Controllers;

use App\Models\Cls;
use App\Models\Sub;
use App\Models\Std;
use App\Models\Mig;
use App\Models\Setting;

class Settings extends BaseController
{
  protected $session = "";
  protected $std = "";
  protected $sub = "";
  protected $cls = "";
  protected $mig = "";
  protected $db = "";
  protected $settings = "";
  public function __construct()
  {
    $this->forge = \Config\Database::forge();
    $this->session = session();
    $this->std = new Std();
    $this->sub = new Sub();
    $this->cls = new Cls();
    $this->mig = new Mig();
    $this->settings = new Setting();
    $this->db = db_connect();
  }

  function index()
  {
    return $this->settings();
  }

  function settings()
  {
    if (!empty($_POST)) {
      $this->settings->setYear($this->request->getPost('year'));
      $this->settings->setActualAttendance(1, $this->request->getPost('actualAttendance1'));
      $this->settings->setActualAttendance(2, $this->request->getPost('actualAttendance2'));
      $this->settings->setShowFasel2($this->request->getPost('showFasel2'));
      $this->settings->setClassesOrder($this->request->getPost('classesOrder'));
      $this->session->setFlashdata('success', 'تم تعديل الإعدادات بنجاح');
      return redirect()->to(base_url('settings'));
    } else {
      //FIXME:
      // if (array_key_exists('', $this->settings->getClassesOrder()))
      //   return $this->setClassOrder();;
      return view(
        'frontend/index',
        [
          'page_name' => 'settings',
          'from' => 'settings',
          'title' => 'الإعدادات',
          'year' => $this->settings->getYear(),
          'actualAttendance1' => $this->settings->getActualAttendance(1),
          'actualAttendance2' => $this->settings->getActualAttendance(2),
          'showFasel2' => $this->settings->getShowFasel2(),
          'classesOrder' => $this->settings->getClassesOrder(),
        ] + $this->viewData
      );
    }
  }

  function setClassOrder()
  {
    return view(
      'frontend/index',
      [
        'page_name' => 'class_order',
        'from' => 'settings',
        'title' => 'ترتيب الصفوف',
        'classes' => $this->cls->getClasses(),
      ] + $this->viewData
    );
  }
}


//c10-c11-c12