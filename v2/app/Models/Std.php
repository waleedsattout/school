<?php

namespace App\Models;

use CodeIgniter\Model;
use \App\Models\Sub;

require ROOTPATH . 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\IOFactory;

class Std extends Model
{
    protected $forge = "";
    protected $db = "";
    protected $session = "";
    protected $cls = "";
    protected $settings = "";

    public function __construct()
    {
        $this->forge = \Config\Database::forge();
        $this->db = db_connect();
        $this->session = session();
        $this->cls = new Cls();
        $this->settings = new Setting();
    }

    /**
     * mohasselah محصلة
     * @param mixed $id student id.
     * @param mixed $subId subject id.
     * @return array [amli1, final1, amli2, final2]
     */
    function getSumWithFinal($id, $subId = 1)
    {
        $stdMarks = $this->getStudentMarks($id);
        if ($stdMarks == null) return [];
        $stdMarks = $stdMarks[0];
        $sub = new Sub();
        $subData = $sub->get_subject_data($subId);

        $marks = explode('-', $stdMarks[$subData['name']]);
        $term1 = explode(',', $marks[0]);
        $term2 = explode(',', $marks[1]);

        $amli1 = $term1[0] + $term1[1] + $term1[2];
        $amli2 = $term2[0] + $term2[1] + $term2[2];

        return [$amli1, $term1[3], $amli2, $term2[3]];
    }

    /**
     * Get subjects marks sum with / without behav.
     * @param int $id student id.
     * @param bool $bool if you want it with behav set it to TRUE.
     * @param bool $onlyFinals this is just for `c12` certificates and ranks.
     * @return array|int
     */
    function getSubjectsMarksSum($id = null, $bool = false, $onlyFinals = false)
    {
        $sub = new Sub();
        $sum1 = 0;
        $sum2 = 0;
        $finals = 0;
        foreach ($sub->get_subjects() as $sub) {
            $arr = $this->getSumWithFinal($id, $sub['id']);
            if ($arr == null) continue;
            $finals += $arr[1];
            $sum1 += ceil(($arr[0] + $arr[1]) / 2);
            $sum2 += ceil(($arr[2] + $arr[3]) / 2);
        }
        if ($bool) {
            $stdData = $this->getStudentData($id);
            $sum1 += explode('-', $stdData['behav'])[0];
            $sum2 += explode('-', $stdData['behav'])[1];
        }

        return $onlyFinals ? $finals : [$sum1, $sum2];
    }

    /**
     * Get all students
     * @param bool $allStudents set it to `True` if you want the students from all over the classes.
     * @param string $select the column you want to select
     * @param array $where where statement like [ => ]
     * @param int $hide set it to 1 if you want to get the hidden students as well
     * @return array|null if there are students, otherwise `null` will be returned.
     */
    public function getStudents($allStudents = false, $select = '*', $where = [], $hide = 0, $orderBy = 'avg', $sort = 'DESC')
    {
        $builder = $this->db->table('students')->select($select)->orderBy($orderBy, $sort);
        if ($allStudents)
            $builder->where(['hide' => $hide] + $where);
        else
            $builder->where(['hide' => $hide, 'class' => $this->session->get('class')] + $where);
        $result = $builder->get()->getResultArray();
        if (count($result) > 0)
            return $result;
        return null;
    }

    /**
     * Update students Avg to get their order when printing the Certificates.
     */
    function updateAvg()
    {
        $class = $this->session->get('class');
        $ids = $this->getStudents(false, 'id');
        foreach ($ids as $id) {
            if ($class == 'c12') {
                $totalMarks = $this->getSubjectsMarksSum($id, true, true);
            } else {
                $totalMarks = $this->getSubjectsMarksSum($id, true);
                $totalMarks = ceil(($totalMarks[0] + $totalMarks[1]) / 2);
            }
            $builder = $this->db->table('students')->where('class', $this->session->get('class'));
            $builder
                ->where('id', $id)
                ->update(['avg' => $totalMarks]);
        }
        $this->updateRank();
    }

    /**
     * Update students Rank to get their order when printing the Certificates.
     */
    function updateRank()
    {
        $sections = $this->cls->getClassSections($this->session->get('class'));
        for ($sections; $sections != 0; $sections--) {
            $i = 1;
            $ids = $this->getStudents(false, 'id', ['section' => $sections]);
            if ($ids == null) continue;
            foreach ($ids as $id) {
                $builder = $this->db->table('students')->where('class', $this->session->get('class'));
                $builder
                    ->where('id', $id)
                    ->update(['rank' => $i]);
                $i++;
            }
        }
    }

    /**
     * Edit students Behavior
     */
    function editBehav($data)
    {
        $builder = $this->db->table('students')->where('class', $this > session()->get('class'))->orderBy("id", "asc");
        foreach ($data as $key => $value) {
            $data = [
                'behav' => $value
            ];
            $builder->where('id', $key);
            $builder->update($data);
        }
    }

    /**
     * Edit students Absent
     */
    function editAbsent($data)
    {
        $builder = $this->db->table('students')->where('class', $this->session->get('class'))->orderBy("id", "asc");
        foreach ($data as $key => $value) {
            $data = [
                'absent' => $value
            ];
            $builder->where('id', $key);
            $builder->update($data);
        }
    }

    /**
     * 
     */
    public function getRanks()
    {
        $ids = $this->getStudents(false, 'id');
        $return = [];
        foreach ($ids as $id)
            $return[$id['id']] = $this->getStudents(false, 'rank', ['id' => $id])[0]['rank'];
        return $return;
    }

    /**
     * 
     */
    public function getStudentData($id)
    {
        $query = $this->getStudents(false, '*', ['id' => $id]);
        if ($query == null || count($query) <= 0)
            return -1;
        $query = $query[0];
        $data = [];
        foreach ($query as $key => $value)
            $data[$key] = $value;
        return $data;
    }

    /**
     * Get students marks based on their id.
     * @param int $stdId the id of the student.
     * @return array|null array of students marks, otherwise null will be returned
     */
    public function getStudentMarks($stdId = null)
    {
        $builder = $this->db->table('subjectsmarks_' . $this->session->get('class'))->orderBy("studentID", "asc");
        $data = [];
        if ($stdId == null) {
            $query = $builder->get()->getResultArray();
            foreach ($query as $key => $value) {
                $data[$value['studentID']] = \array_diff_key($value, ['id' => "xy", 'studentID' => '']);
            }
        } else {
            $query = $builder->where('studentID', $stdId)->get()->getResultArray();
            foreach ($query as $key => $value) {
                $data[$key] = $value;
            }
            $data = \array_diff_key($data, ['id' => "xy", 'studentID' => '']);
        }
        if (count($data) > 0)
            return $data;
        return null;
    }

    /**
     * 
     */
    public function hideStudent($id = null)
    {
        if ($id == null)
            return false;
        $builder = $this->db->table('students');
        $builder->where('id', $id);
        $builder->update(['hide' => 1]);
        return true;
    }

    /**
     * 
     */
    public function hideStudents($students)
    {
        foreach ($students as $id => $hide) {
            $builder = $this->db->table('students');
            $builder->where('id', $id);
            $builder->update(['hide' => "$hide"]);
        }
        return true;
    }

    /**
     * 
     */
    public function addStd($firstName, $lastName, $fatherName, $motherName, $dob, $class, $section = null)
    {
        $builder = $this->db->table('students');
        $data = [
            'firstName' => $firstName,
            'lastName' => $lastName,
            'fatherName' => $fatherName,
            'motherName' => $motherName,
            'dob' => $dob,
            'section' => $section,
            'class' => $class,
            'hide' => 0
        ];
        $builder->insert($data);
        $builder = $this->db->table('subjectsMarks_' . $class);
        $id = $this->db->insertID();
        $tables = ['subjectsmarks_c10', 'subjectsmarks_c11', 'subjectsmarks_c12'];
        for ($i = 0; $i < count($tables); $i++)
            $this->db->table($tables[$i])->insert(['studentID' => $id]);
    }

    /**
     * 
     */
    public function editStd($id, $firstName, $lastName, $fatherName, $motherName, $dob, $section = null)
    {
        if ($id == null) {
            $this->session->setFlashdata('error', 'لم يتم تعديل بيانات الطالبة، بسبب حدوث خطأ.');
            return redirect()->to(base_url($this->viewData['locale'] . '/students/manage_student'));
        }
        $data = [
            'firstName' => $firstName,
            'lastName' => $lastName,
            'fatherName' => $fatherName,
            'motherName' => $motherName,
            'dob' => $dob,
            'section' => $section
        ];
        $builder = $this->db->table('students')->where('class', $this->session->get('class'));
        $builder->where('id', $id);
        $builder->update($data);
        $this->session->setFlashdata('success', 'تم تعديل بيانات الطالب.');
        return redirect()->to(base_url($this->viewData['locale'] . '/students/manage_student'));
    }

    /**
     * 
     */
    public function delStd($id = null)
    {
        $builder = $this->db->table('students')->where('class', $this->session->get('class'));
        if ($builder->where('id', $id)->countAllResults() == 0 || $id == null) {
            $this->session->setFlashdata('error', 'لم يتم حذف الطالبة، بسبب حدوث خطأ ما.');
            return redirect()->to(base_url($this->viewData['locale'] . '/students/manage_student'));
        }
        $builder->delete(['id' => $id]);
        $tables = ['subjectsmarks_c10', 'subjectsmarks_c11', 'subjectsmarks_c12'];
        foreach ($tables as $table) {
            $builder = $this->db->table($table);
            $builder->delete(['studentID' => $id]);
        }
        $this->session->setFlashdata('success', 'تم حذف الطالب بنجاح');
    }

    /**
     * Returns names of students based on ids.
     *
     * @param array|string $tableName
     *
     * @return 
     *
     */
    public function id2name($ids = null)
    {
        $builder = $this->db->table('students')->where('class', $this->session->get('class'));
        if ($ids == null) {
            // return $builder->get()->getResultArray();
        } else if (is_array($ids)) {
            $names = [];
            foreach ($ids as $key => $id) {
                $query = $builder->where('id', $id)->get()->getResultArray()[0];
                $names[] = $query['firstName'] . ' ' . $query['lastName'];
            }
            return $names;
        } else {
            $query = $builder->where('id', $ids)->get()->getResultArray()[0];
            return ['name' => $query['firstName'] . ' ' . $query['lastName']];
        }
        return [];
    }

    /**
     * 
     */
    public function editStdMarks($id, $subjectName, $marks)
    {
        if ($id == null) {
            $this->session->setFlashdata('error', 'لم يتم تعديل بيانات الطالبة، بسبب حدوث خطأ.');
            return redirect()->to(base_url($this->viewData['locale'] . '/students/manage_student'));
        }

        $builder = $this->db->table('subjectsmarks_' . $this->session->get('class'));
        $builder->where('studentID', $id);
        $builder->update(["$subjectName" => $marks]);
        $this->session->setFlashdata('success', 'تم تعديل علامة الطالبة.');
        return redirect()->to(base_url($this->viewData['locale'] . '/students/manage_student'));
    }

    /**
     * 
     */
    public function getBehav()
    {
        $data = [];
        $builder = $this->db->table('students')->where('class', $this->session->get('class'));
        $q = $builder->get()->getResultArray();
        foreach ($q as $key => $value) {
            $data += [
                $value['id'] => [
                    "name" => $value['firstName'] . " " . $value['lastName'],
                    "behav" => $value['behav']
                ]
            ];
        }
        return $data;
    }

    /**
     * @param bool $bool: set it to true if you want to get only absent with id, otherwise you will get id with full name and absent.
     * @return array retuen array with students and thier absents. 
     */
    public function getAbsent($bool = false)
    {
        $data = [];
        $q = $this->getstudents(false, '*', ['class' => $this->session->get('class')], 0, 'id', 'asc');
        foreach ($q as $key => $value) {
            if ($bool) {
                $data[$value['id']] = $value['absent'];
            } else {
                $data += [
                    $value['id'] => [
                        "name" => $value['firstName'] . " " . $value['lastName'],
                        "absent" => $value['absent']
                    ]
                ];
            }
        }
        return $data;
    }

    /**
     * Those are my custom functions for certificates, 
     *      if you want to use them feel free to use them, 
     *      if you want to make your own,
     * please have a lot of fun :sad:
     */

    /**
     * Export all students' certificates of c10 and c11 to Excel files in a zip file. 
     */
    public function c10_cert()
    {
        helper('convert_ar');
        if (strpos(getcwd(), 'public') == false)
            chdir('public');
        helper('filesystem');
        delete_files('certificates', true);

        $subj = new Sub();

        $sections = $this->cls->getClassSections($this->session->get('class'));

        for ($sections; $sections > 0; $sections--) {
            $spreadsheet = IOFactory::load(getcwd() . '/c10.xlsx');
            $ids = $this->getStudents(false, 'id', ['class' => $this->session->get('class'), 'section' => (int) $sections]);
            if (empty($ids))
                continue;
            foreach ($ids as $id) {
                $id = $id['id'];
                $stdData = $this->getStudentData($id);
                $clonedWorksheet = clone $spreadsheet->getSheet(0);
                $clonedWorksheet->setTitle($stdData['firstName'] . ' ' . $stdData['lastName']);
                $spreadsheet->addSheet($clonedWorksheet);

                $spreadsheet->setActiveSheetIndex($spreadsheet->getIndex($clonedWorksheet));
                $worksheet = $spreadsheet->getActiveSheet();
                $year = explode('-', $this->settings->getYear());
                $worksheet->setTitle($stdData['firstName'] . ' ' . $stdData['lastName']);
                $worksheet->setCellValue('Q2',  to_ar_num($year[0]) . ' / ' . to_ar_num($year[1]));
                $worksheet->setCellValue('B4', $stdData['firstName'] . ' ' . $stdData['lastName']);
                $worksheet->setCellValue('D4', $stdData['fatherName']);
                $worksheet->setCellValue('G4', $stdData['motherName']);
                $worksheet->setCellValue('H4', $worksheet->getCell('H4') . ' ' . $this->cls->getClassByName($this->session->get('class'), false)['arabic']);
                $worksheet->setCellValue('Q4', $subj->get_sec()[$stdData['section']]);
                $final1 = $final2 = 0;
                $final1A = $final2B = 0;
                $rowIndex = 8;

                $subData = $subj->get_subject_data();
                foreach ($subData as $sub) {
                    if ($rowIndex == 13) {
                        $minMax = $subj->getSubjectsMaxMinSum(1);
                        $worksheet->setCellValue('C' . $rowIndex, $minMax[0]);
                        $worksheet->setCellValue('G' . $rowIndex, $final1);
                        $worksheet->setCellValue('H' . $rowIndex, convert($final1));
                        $worksheet->setCellValue('L' . $rowIndex, $final2);
                        $worksheet->setCellValue('M' . $rowIndex, convert($final2));
                        $worksheet->setCellValue('N' . $rowIndex, ($final1 + $final2));
                        $worksheet->setCellValue('O' . $rowIndex, ceil(($final1 + $final2) / 2));
                        $worksheet->setCellValue('P' . $rowIndex, convert(ceil(($final1 + $final2) / 2)));
                        $worksheet->setCellValue('Q' . $rowIndex, $minMax[1]);
                        $final1A = $final1;
                        $final2B = $final2;
                        $final1 = $final2 = 0;
                        $rowIndex++;
                    }
                    if ($rowIndex == 19 && $this->session->get('class') == 'c11') {
                        $worksheet->insertNewRowBefore($rowIndex + 1);
                        $lastColumn = $worksheet->getHighestColumn();
                        for ($col = 'A'; $col <= $lastColumn; ++$col) {
                            $style = $worksheet->getStyle($col . '19');
                            $worksheet->duplicateStyle($style, $col . '20');
                        }
                    }

                    $sumWithFinal = $this->getSumWithFinal($id, $sub['id']);
                    $worksheet->setCellValue('B' . $rowIndex, $sub['arabic']);
                    $worksheet->setCellValue('C' . $rowIndex, $sub['max']);
                    $worksheet->setCellValue('D' . $rowIndex, $sumWithFinal[0]);
                    $worksheet->setCellValue('E' . $rowIndex, $sumWithFinal[1]);
                    $worksheet->setCellValue('F' . $rowIndex, ($sumWithFinal[0] + $sumWithFinal[1]));
                    $worksheet->setCellValue('G' . $rowIndex, ceil(($sumWithFinal[0] + $sumWithFinal[1]) / 2));
                    $worksheet->setCellValue('H' . $rowIndex, convert(ceil(($sumWithFinal[0] + $sumWithFinal[1]) / 2)));
                    $worksheet->setCellValue('I' . $rowIndex, $sumWithFinal[2]);
                    $worksheet->setCellValue('J' . $rowIndex, $sumWithFinal[3]);
                    $worksheet->setCellValue('K' . $rowIndex, ($sumWithFinal[2] + $sumWithFinal[3]));
                    $worksheet->setCellValue('L' . $rowIndex, ceil(($sumWithFinal[2] + $sumWithFinal[3]) / 2));
                    $worksheet->setCellValue('M' . $rowIndex, convert(ceil(($sumWithFinal[2] + $sumWithFinal[3]) / 2)));
                    $worksheet->setCellValue('N' . $rowIndex, (ceil(($sumWithFinal[0] + $sumWithFinal[1]) / 2) + ceil(($sumWithFinal[2] + $sumWithFinal[3]) / 2)));
                    $worksheet->setCellValue('O' . $rowIndex, ceil((ceil(($sumWithFinal[0] + $sumWithFinal[1]) / 2) + ceil(($sumWithFinal[2] + $sumWithFinal[3]) / 2)) / 2));
                    $worksheet->setCellValue('P' . $rowIndex, convert(ceil((ceil(($sumWithFinal[0] + $sumWithFinal[1]) / 2) + ceil(($sumWithFinal[2] + $sumWithFinal[3]) / 2)) / 2)));
                    $worksheet->setCellValue('Q' . $rowIndex, $sub['min']);
                    $final1 += ceil(($sumWithFinal[0] + $sumWithFinal[1]) / 2);
                    $final2 += ceil(($sumWithFinal[2] + $sumWithFinal[3]) / 2);
                    if (ceil(($sumWithFinal[0] + $sumWithFinal[1]) / 2) < (int) $sub['min']) {
                        $worksheet->getCell('G' . $rowIndex)->getStyle()->getFont()->setUnderline('single');
                        $worksheet->getCell('G' . $rowIndex)->getStyle()->getFont()->getColor()->setARGB('FF0000');
                    }
                    if (ceil((ceil(($sumWithFinal[0] + $sumWithFinal[1]) / 2) + ceil(($sumWithFinal[2] + $sumWithFinal[3]) / 2)) / 2) < (int) $sub['min']) {
                        $worksheet->getCell('O' . $rowIndex)->getStyle()->getFont()->setUnderline('single');
                        $worksheet->getCell('O' . $rowIndex)->getStyle()->getFont()->getColor()->setARGB('FF0000');
                    }
                    $rowIndex++;
                }
                $minMax = $subj->getSubjectsMaxMinSum(2);
                $worksheet->setCellValue('C' . $rowIndex, $minMax[0]);
                $worksheet->setCellValue('G' . $rowIndex, $final1);
                $worksheet->setCellValue('H' . $rowIndex, convert($final1));
                $worksheet->setCellValue('L' . $rowIndex, $final2);
                $worksheet->setCellValue('M' . $rowIndex, convert($final2));
                $worksheet->setCellValue('N' . $rowIndex, ($final1 + $final2));
                $worksheet->setCellValue('O' . $rowIndex, ceil(($final1 + $final2) / 2));
                $worksheet->setCellValue('P' . $rowIndex, convert(ceil(($final1 + $final2) / 2)));
                $worksheet->setCellValue('Q' . $rowIndex++, $minMax[1]);

                $final1A += $final1;
                $final2B += $final2;
                $minMax = $subj->getSubjectsMaxMinSum();
                $worksheet->setCellValue('C' . ($rowIndex), $minMax[0]);
                $worksheet->setCellValue('G' . ($rowIndex), $final1A);
                $worksheet->setCellValue('H' . ($rowIndex), convert($final1A));
                $worksheet->setCellValue('L' . ($rowIndex), ($final2B));
                $worksheet->setCellValue('M' . ($rowIndex), convert($final2B));
                $worksheet->setCellValue('N' . ($rowIndex), ($final1A + $final2B));
                $worksheet->setCellValue('O' . ($rowIndex), ceil(($final1A + $final2B) / 2));
                $worksheet->setCellValue('P' . ($rowIndex), convert(ceil(($final1A + $final2B) / 2)));
                $worksheet->setCellValue('Q' . ($rowIndex++), $minMax[1]);

                $behav = explode('-', $stdData['behav']);
                $worksheet->setCellValue('C' . ($rowIndex), 200);
                $worksheet->setCellValue('G' . ($rowIndex), $behav[0]);
                $worksheet->setCellValue('H' . ($rowIndex), convert($behav[0]));
                $worksheet->setCellValue('L' . ($rowIndex), ($behav[1]));
                $worksheet->setCellValue('M' . ($rowIndex), convert($behav[1]));
                $worksheet->setCellValue('N' . ($rowIndex), ($behav[0] + $behav[1]));
                $worksheet->setCellValue('O' . ($rowIndex), ceil(($behav[0] + $behav[1]) / 2));
                $worksheet->setCellValue('P' . ($rowIndex), convert(ceil(($behav[0] + $behav[1]) / 2)));
                $worksheet->setCellValue('Q' . ($rowIndex++), 140);

                $worksheet->setCellValue('C' . ($rowIndex), $minMax[0] + 200);
                $worksheet->setCellValue('G' . ($rowIndex), $final1A + $behav[0]);
                $worksheet->setCellValue('H' . ($rowIndex), convert($final1A + $behav[0]));
                $worksheet->setCellValue('L' . ($rowIndex), ($final2B + $behav[1]));
                $worksheet->setCellValue('M' . ($rowIndex), convert($final2B + $behav[1]));
                $worksheet->setCellValue('N' . ($rowIndex), ($final1A + $final2B + $behav[0] + $behav[1]));
                $worksheet->setCellValue('O' . ($rowIndex), ceil(($final1A + $final2B + $behav[0] + $behav[1]) / 2));
                $worksheet->setCellValue('P' . ($rowIndex), convert(ceil(($final1A + $final2B + $behav[0] + $behav[1]) / 2)));
                $worksheet->setCellValue('Q' . ($rowIndex++), $minMax[1] + 140);

                $absent = $stdData['absent'];
                $absent1 = explode('-', $absent)[0];
                $absent2 = explode('-', $absent)[1];
                $i = $this->session->get('class') == 'c11' ? 27 : 26;
                $worksheet->setCellValue('C' . $i, $this->settings->getActualAttendance(1));
                $worksheet->setCellValue('D' . $i, explode(',', $absent1)[0]);
                $worksheet->setCellValue('F' . $i, explode(',', $absent1)[1]);
                $worksheet->setCellValue('C' . ($i + 1), $this->settings->getActualAttendance(2));
                $worksheet->setCellValue('D' . ($i + 1), explode(',', $absent2)[0]);
                $worksheet->setCellValue('F' . ($i + 1), explode(',', $absent2)[1]);
                $worksheet->setCellValue('C' . ($i + 2), $this->settings->getActualAttendance(1) + $this->settings->getActualAttendance(2));
                $worksheet->setCellValue('D' . ($i + 2), explode(',', $absent1)[0] + explode(',', $absent2)[0]);
                $worksheet->setCellValue('F' . ($i + 2), explode(',', $absent1)[1] + explode(',', $absent2)[1]);

                $worksheet->setCellValue('M' . ($i + 1), $worksheet->getCell('M' . ($i + 1)) . ' ' . to_ar_num($stdData['rank']));

                $ranges = ['C8:G23', 'I8:L23', 'N8:O23', 'Q8:Q23', 'C26:F28'];
                foreach ($ranges as $range) {
                    $format = $spreadsheet->getActiveSheet()->getStyle($range)->getNumberFormat();
                    $format->setFormatCode('[$-,206]0');
                }
                $worksheet->setCellValue('H29', 'في    /     / ' . to_ar_num($year[1]) . 'م');
                $worksheet->setCellValue('N29', 'في    /     / ' . to_ar_num($year[1]) . 'م');
                if ($this->settings->getShowFasel2() == 0)
                    foreach ($worksheet->getRowIterator(8, 23) as $row)
                        foreach ($row->getCellIterator('I', 'P') as $cell)
                            $cell->setValue('');
            }

            $spreadsheet->removeSheetByIndex(0);

            $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
            $writer->save('certificates/Certificates_' . $sections . '.xlsx');
        }

        $zip = new \ZipArchive();
        if ($zip->open('certificates_' . $this->session->get('class') . '.zip', \ZipArchive::CREATE | \ZipArchive::OVERWRITE)) {
            foreach (get_filenames('certificates', true) as $filePath) {
                $path = explode(DIRECTORY_SEPARATOR, $filePath);
                $zip->addFile($filePath, $path[count($path) - 1]);
            }
            $zip->close();
        }

        header('Content-Type: application/zip');
        header('Content-Disposition: attachment;filename=' . basename('certificates_' . $this->session->get('class') . '.zip'));
        header('Content-Length: ' . filesize('certificates_' . $this->session->get('class') . '.zip'));
        header('Cache-Control: max-age=0');
        readfile('certificates_' . $this->session->get('class') . '.zip');
        exit;
    }

    /**
     * Export all students' certificates of c12 to Excel files in a zip file. 
     */
    public function c12_cert()
    {
        helper('convert_ar');
        $subj = new Sub();
        if (strpos(getcwd(), 'public') == false)
            chdir('public');

        helper('filesystem');
        delete_files('certificates', true);

        $sections = $this->cls->getClassSections('c12');

        for ($sections; $sections > 0; $sections--) {
            $template = IOFactory::load(getcwd() . '/c12.xlsx');
            $ids = $this->getStudents(false, 'id', ['class' => 'c12', 'section' => (int) $sections]);
            foreach ($ids as $id) {
                $stdData = $this->getStudentData($id);

                $worksheet = clone $template->getSheet(0);
                $worksheet->setTitle($stdData['firstName'] . ' ' . $stdData['lastName']);
                $template->addSheet($worksheet);
                $worksheet->setCellValue('A4', 'الاسم: ' . $stdData['firstName'] . ' ' . $stdData['lastName']);

                $worksheet->setCellValue('B4', 'والدها: ' . $stdData['fatherName']);
                $worksheet->setCellValue('F4', 'والدتها: ' . $stdData['motherName']);
                $worksheet->setCellValue('R4', $subj->get_sec()[$this->getStudentData($id)['section']]);

                $subData = $subj->get_subject_data();
                $amli1 = $final1 = $amli2  = $sum = 0;
                $rowIndex = 7;

                foreach ($subData as $sub) {
                    $sumWithFinal = $this->getSumWithFinal($id, $sub['id']);
                    $worksheet->setCellValue('A' . $rowIndex, $sub['arabic']);
                    $worksheet->setCellValue('B' . $rowIndex, to_ar_num($sub['max']));
                    $worksheet->setCellValue('C' . $rowIndex, to_ar_num($sumWithFinal[0]));
                    $worksheet->setCellValue('D' . $rowIndex, convert($sumWithFinal[0]));
                    $worksheet->setCellValue('G' . $rowIndex, to_ar_num($sumWithFinal[1]));
                    $worksheet->setCellValue('H' . $rowIndex, convert($sumWithFinal[1]));
                    $worksheet->setCellValue('K' . $rowIndex, to_ar_num($sumWithFinal[2]));
                    $worksheet->setCellValue('L' . $rowIndex, convert($sumWithFinal[2]));
                    $worksheet->setCellValue('O' . $rowIndex, to_ar_num($sumWithFinal[0] + $sumWithFinal[1] + $sumWithFinal[2]));
                    $worksheet->setCellValue('P' . $rowIndex, to_ar_num(ceil(($sumWithFinal[0] + $sumWithFinal[1] + $sumWithFinal[2]) / 3)));
                    $worksheet->setCellValue('Q' . $rowIndex, convert(ceil(($sumWithFinal[0] + $sumWithFinal[1] + $sumWithFinal[2]) / 3)));
                    if (ceil(($sumWithFinal[1])) < (int) $sub['min']) {
                        $worksheet->getCell('G' . $rowIndex)->getStyle()->getFont()->setUnderline('single');
                        $worksheet->getCell('G' . $rowIndex)->getStyle()->getFont()->getColor()->setARGB('FF0000');
                    }
                    if (ceil((ceil(($sumWithFinal[0] + $sumWithFinal[1]) / 2) + ceil(($sumWithFinal[2] + $sumWithFinal[3]) / 2)) / 2) < (int) $sub['min']) {
                        $worksheet->getCell('P' . $rowIndex)->getStyle()->getFont()->setUnderline('single');
                        $worksheet->getCell('P' . $rowIndex)->getStyle()->getFont()->getColor()->setARGB('FF0000');
                    }
                    $rowIndex++;
                    $amli1 += $sumWithFinal[0];
                    $final1 += $sumWithFinal[1];
                    $amli2 += $sumWithFinal[2];
                    $sum += ($sumWithFinal[0] + $sumWithFinal[1] + $sumWithFinal[2]);
                }

                $worksheet->setCellValue('B' . $rowIndex, to_ar_num($subj->getSubjectsMaxMinSum()[0]));
                $worksheet->setCellValue('C' . $rowIndex, to_ar_num($amli1));
                $worksheet->setCellValue('D' . $rowIndex, convert($amli1));
                $worksheet->setCellValue('G' . $rowIndex, to_ar_num($final1));
                $worksheet->setCellValue('H' . $rowIndex, convert($final1));
                $worksheet->setCellValue('K' . $rowIndex, to_ar_num($amli2));
                $worksheet->setCellValue('L' . $rowIndex, convert($amli2));
                $worksheet->setCellValue('O' . $rowIndex, to_ar_num($sum));
                $worksheet->setCellValue('P' . $rowIndex, to_ar_num(ceil($sum / 3)));
                $worksheet->setCellValue('Q' . $rowIndex++, convert(ceil($sum / 3)));

                $behav = explode('-', $stdData['behav']);

                $worksheet->setCellValue('B' . $rowIndex, to_ar_num(200));
                $worksheet->setCellValue('C' . $rowIndex, to_ar_num($behav[0]));
                $worksheet->setCellValue('D' . $rowIndex, convert($behav[0]));
                $worksheet->setCellValue('G' . $rowIndex, to_ar_num($behav[0]));
                $worksheet->setCellValue('H' . $rowIndex, convert($behav[0]));
                $worksheet->setCellValue('K' . $rowIndex, to_ar_num($behav[1]));
                $worksheet->setCellValue('L' . $rowIndex, convert($behav[1]));
                $worksheet->setCellValue('O' . $rowIndex, to_ar_num($behav[0] + $behav[1]));
                $worksheet->setCellValue('P' . $rowIndex, to_ar_num(ceil(($behav[0] + $behav[1]) / 2)));
                $worksheet->setCellValue('Q' . $rowIndex++, convert(ceil(($behav[0] + $behav[1]) / 2)));

                $worksheet->setCellValue('B' . $rowIndex, to_ar_num(200 + $subj->getSubjectsMaxMinSum()[0]));
                $worksheet->setCellValue('C' . $rowIndex, to_ar_num($amli1 + $behav[0]));
                $worksheet->setCellValue('D' . $rowIndex, convert($amli1 + $behav[0]));
                $worksheet->setCellValue('G' . $rowIndex, to_ar_num($final1 + $behav[0]));
                $worksheet->setCellValue('H' . $rowIndex, convert($final1 + $behav[0]));
                $worksheet->setCellValue('K' . $rowIndex, to_ar_num($amli2 + $behav[1]));
                $worksheet->setCellValue('L' . $rowIndex, convert($amli2 + $behav[1]));
                $worksheet->setCellValue('P' . $rowIndex, to_ar_num(ceil((ceil(($behav[0] + $behav[1]) / 2) + ceil($sum / 3)) / 2)));
                $worksheet->setCellValue('Q' . $rowIndex, convert((ceil(($behav[0] + $behav[1]) / 2) + ceil($sum / 3))));

                $absent1_1 = explode(',', explode('-', $stdData['absent'])[0])[0]; // مبرر فصل أول 
                $absent1_2 = explode(',', explode('-', $stdData['absent'])[0])[1]; // غير مبرر فصل أول
                $absent2_1 = explode(',', explode('-', $stdData['absent'])[1])[0]; // مبرر فصل ثاني
                $absent2_2 = explode(',', explode('-', $stdData['absent'])[1])[1]; // غير مبرر فصل ثاني

                $actualAttendance1 = $this->settings->getActualAttendance(1); // الدوام الفعلي فصل أول
                $actualAttendance2 = $this->settings->getActualAttendance(2); // الدوام الفعلي فصل ثاني

                $worksheet->setCellValue('B24', to_ar_num($actualAttendance1));
                $worksheet->setCellValue('B25', to_ar_num($actualAttendance2));
                $worksheet->setCellValue('B26', to_ar_num($actualAttendance1 + $actualAttendance2));

                $worksheet->setCellValue('C24', to_ar_num($actualAttendance1 - $absent1_1 - $absent1_2));
                $worksheet->setCellValue('C25', to_ar_num($actualAttendance2 - $absent2_1 - $absent2_2));
                $worksheet->setCellValue('C26', to_ar_num($actualAttendance1 - $absent1_1 - $absent1_2 + $actualAttendance2 - $absent2_1 - $absent2_2));

                $worksheet->setCellValue('D24', to_ar_num($absent1_1));
                $worksheet->setCellValue('D25', to_ar_num($absent2_1));
                $worksheet->setCellValue('D26', to_ar_num($absent1_1 + $absent2_1));

                $worksheet->setCellValue('F24', to_ar_num($absent1_2));
                $worksheet->setCellValue('F25', to_ar_num($absent2_2));
                $worksheet->setCellValue('F26', to_ar_num($absent1_2 + $absent2_2));

                $year = explode('-', $this->settings->getYear());
                $worksheet->setCellValue('U2', 'العام الدراسي: ' . to_ar_num($year[1]) . ' / ' . to_ar_num($year[0]));
                $worksheet->setCellValue('U27', 'في    /     / ' . to_ar_num($year[1]) . 'م');
                $worksheet->setCellValue('H27', 'في    /     / ' . to_ar_num($year[1]) . 'م');

                $worksheet->setCellValue('P24', to_ar_num($stdData['rank']));

                $ranges = ['B7:C21', 'G7:G21', 'K7:K21', 'O7:O20', 'P7:P21'];
                foreach ($ranges as $range) {
                    $format = $template->getActiveSheet()->getStyle($range)->getNumberFormat();
                    $format->setFormatCode('[$-,206]0');
                }

                if ($this->settings->getShowFasel2() == 0)
                    foreach ($worksheet->getRowIterator(7, 21) as $row)
                        foreach ($row->getCellIterator('K', 'Q') as $cell)
                            $cell->setValue('');
            }

            $template->removeSheetByIndex(0);
            $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($template);
            $writer->save('certificates/Certificates_' . $sections . '.xlsx');
        }

        $zip = new \ZipArchive();
        if ($zip->open('certificates_' . $this->session->get('class') . '.zip', \ZipArchive::CREATE | \ZipArchive::OVERWRITE))
            foreach (get_filenames('certificates', true) as $filePath)
                $zip->addFile($filePath, explode('\\', $filePath)[count(explode('\\', $filePath)) - 1]);
        $zip->close();
        header('Content-Type: application/zip');
        header('Content-Disposition: attachment;filename=' . basename('certificates_' . $this->session->get('class') . '.zip'));
        header('Content-Length: ' . filesize('certificates_' . $this->session->get('class') . '.zip'));
        header('Cache-Control: max-age=0');
        readfile('certificates_' . $this->session->get('class') . '.zip');
        exit;
    }
}
