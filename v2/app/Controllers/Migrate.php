<?php

namespace App\Controllers;

use App\Models\Cls;
use App\Models\Sub;
use App\Models\Std;
use App\Models\Mig;

class Migrate extends BaseController
{
  protected $session = "";
  protected $std = "";
  protected $sub = "";
  protected $cls = "";
  protected $mig = "";
  protected $db = "";
  public function __construct()
  {
    $this->forge = \Config\Database::forge();
    $this->session = session();
    $this->std = new Std();
    $this->sub = new Sub();
    $this->cls = new Cls();
    $this->mig = new Mig();
    $this->db = db_connect();
  }

  /**
   * Check for existence of tables and primary keys
   */
  function quickCheck()
  {
    $this->mig->checkPrimaryKeys();
    $this->mig->checkDatabases();

    $this->session->setFlashdata('success', 'تم التأكد من عدم وجود أخطاء جوهرية في الوقع.');
    return redirect()->to(base_url($this->viewData['locale'] . '/students/manage_student'));
  }


  function migrateStudentsData()
  {
    $this->mig->migrateStudentsData();
    $this->session->setFlashdata('success', 'تم نقل بيانات الطالبات بنجاح.');
    return redirect()->to(base_url($this->viewData['locale'] . '/students/manage_student'));
  }






  // ============
  // we are here.
  // ============

  public function hide()
  {
    $stds = $this->std->getStudents(false, '*', [], 1, 'id', 'asc');
    $stds += $this->std->getStudents(false, '*', [], 0, 'id', 'asc');
    return view(
      'frontend/index',
      [
        'title' => 'Hide',
        'from' => 'start',
        'stds' => $stds,
        'page_name' => 'hide'
      ] + $this->viewData
    );
  }

  public function importData()
  {
    if (!empty($_POST)) {
      $data = json_decode((string) $this->request->getPost('data'));
      $type = $this->request->getPost('type');
      $this->mig->importData($data, $type);
    }
    return view(
      'frontend/index',
      [
        'title' => 'استيراد',
        'page_name' => 'migrate',
        'from' => 'start',
        'subjects' => $this->sub->get_subjects(),
        'classes' => $this->cls->getClasses()
      ] + $this->viewData
    );
  }

  function promoteStudents()
  {
    if (!empty($_POST)) {
      $this->mig->promoteStudents(json_decode((string)$this->request->getPost('data')));
      $this->session->setFlashdata('success', 'تم ترفيع الطالبات');
      return redirect()->to(base_url('/students/manage_student'));
    }
  }

  // no usage for this for now 
  //FIXME:
  function backupDatabases()
  {
    return view(
      'frontend/index',
      [
        'title' => 'إنجاح الطالبات',
        'page_name' => 'successors',
        'from' => 'migrate',
        'subjects' => $this->sub->get_subjects(),
        'students' => $this->std->getStudents(),
        'classes' => $this->cls->getClasses()
      ] + $this->viewData
    );
  }
}
