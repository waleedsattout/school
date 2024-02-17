<?php

namespace App\Models;

use App\Controllers\Students;
use CodeIgniter\Model;

class Mig extends Model
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
        $this->std = new Std();
    }

    /**
     * Check database tables (classes, users, students) and make ones if not exists.
     * Then check if the default value of (behav, absent) is correct or no.
     * @return bool true if everything done ok. otherwise throws an error.
     */
    function checkDatabases()
    {
        if (!$this->db->tableExists('classes')) {
            $fields = [
                'id' => [
                    'type' => 'int',
                    'null' => False,
                    'auto_increment' => TRUE
                ],
                'class_id' => [
                    'type' => 'int',
                    'null' => False
                ],
                'name' => [
                    'type' => 'longtext',
                    'null' => False
                ],
                'arabic' => [
                    'type' => 'longtext',
                    'null' => False
                ],
            ];
            $this->forge->addField($fields);
            $this->forge->addKey('id', TRUE);
            $this->forge->createTable('classes', true);
        }
        if (!$this->db->tableExists('users')) {
            $fields = [
                'id' => [
                    'type' => 'int',
                    'null' => False,
                    'auto_increment' => TRUE
                ],
                'username' => [
                    'type' => 'longtext',
                    'null' => False
                ],
                'password' => [
                    'type' => 'longtext',
                    'null' => False
                ],
                'role' => [
                    'type' => 'int',
                    'null' => False
                ],
                'access' => [
                    'type' => 'longtext',
                    'null' => False
                ],
            ];
            $this->forge->addField($fields);
            $this->forge->addKey('id', TRUE);
            $this->forge->createTable('users', true);
        }
        if (!$this->db->tableExists('students')) {
            $this->makeStudentsTable();
        }
        $fieldData = $this->db->getFieldData('students');
        foreach ($fieldData as $fieled) {
            if ($fieled->name == 'behav')
                if ($fieled->default != '0-0')
                    $this->db->query('ALTER TABLE `students` CHANGE `behav` `behav` LONGTEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT "0-0";');
            if ($fieled->name == 'absent')
                if ($fieled->default != '0,0-0,0')
                    $this->db->query('ALTER TABLE `students` CHANGE `absent` `absent` LONGTEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT "0,0-0,0";');
        }
        return true;
    }

    /**
     * Check primary key in each table if exists, if not it sets it to <b>id</b>
     */
    function checkPrimaryKeys()
    {
        foreach ($this->db->listTables() as $table) {
            $fields = $this->db->getFieldData($table);
            $noIdColumnFound = true;
            foreach ($fields as $field) {
                if ($field->name == 'id') {
                    $noIdColumnFound = false;
                    if ($field->primary_key != 1) {
                        $this->db->query("ALTER TABLE $table MODIFY COLUMN id INT NOT NULL AUTO_INCREMENT PRIMARY KEY;");
                    } else {
                        $this->db->query("ALTER TABLE $table MODIFY COLUMN id INT NOT NULL AUTO_INCREMENT;");
                    }
                }
            }
            if ($noIdColumnFound == true) {
                $this->db->query("ALTER TABLE $table ADD COLUMN id INT NOT NULL AUTO_INCREMENT PRIMARY KEY;");
            }
        }
    }

    /**
     * Make _students_ table based on old tables (students_c10, students_c11, students_c12)
     */
    function makeStudentsTable()
    {
        if (!$this->db->tableExists('students')) {
            $this->db->query("UPDATE students_c10 SET id = id + 1000;");
            $this->db->query("UPDATE students_c11 SET id = id + 2000;");
            $this->db->query("UPDATE students_c12 SET id = id + 3000;");

            $this->db->query("UPDATE subjectsmarks_c10 SET studentID = studentID + 1000;");
            $this->db->query("UPDATE subjectsmarks_c11 SET studentID = studentID + 2000;");
            $this->db->query("UPDATE subjectsmarks_c12 SET studentID = studentID + 3000;");

            $this->db->query('CREATE TABLE IF NOT EXISTS students AS SELECT id, firstName, lastName, fatherName, motherName, dob, class, section, behav, avg, rank, absent, hide FROM ( SELECT id, firstName, lastName, fatherName, motherName, dob, "c10" AS class, section, behav, avg, rank, absent, 0 AS hide FROM students_c10 UNION ALL SELECT id, firstName, lastName, fatherName, motherName, dob, "c11" AS class, section, behav, avg, rank, absent, 0 AS hide FROM students_c11 UNION ALL SELECT id, firstName, lastName, fatherName, motherName, dob, "c12" AS class, section, behav, avg, rank, absent, 0 AS hide FROM students_c12 ) AS t;');

            $fields = $this->db->getFieldData('students');
            if ($fields[0]->name == 'id')
                if ($fields[0]->primary_key != 1)
                    $this->db->query("ALTER TABLE students ADD PRIMARY KEY (id);");
        }
    }

    /**
     * Copy students data from `students_c~~` to `students` table. This will overwrite the existing data.
     */
    function migrateStudentsData()
    {
        $students = $this->db->query("select * from students_" . $this->session->get('class'))->getResultArray();
        foreach ($students as $student) {
            $this->db->table('students')->update([
                "firstName" => $student['firstName'],
                "lastName" => $student['lastName'],
                "fatherName" => $student['fatherName'],
                "motherName" => $student['motherName'],
                "dob" => $student['dob'],
                "section" => $student['section'],
                "behav" => $student['behav'],
                "avg" => $student['avg'],
                "rank" => $student['rank'],
                "absent" => $student['absent'],
            ], [
                'id' => $student['id']
            ]);
        }
    }




    // ============
    // we are here.
    // ============

    function importData($data, $type)
    {
        if ($type == 'students') {
            foreach ($data as $std) {
                $st = [
                    'firstName' => $std->firstName,
                    'lastName' => $std->lastName,
                    'fatherName' => $std->fatherName,
                    'motherName' => $std->motherName,
                    'class' => $std->class,
                    'section' => $std->section,
                    'dob' => $std->dob,
                    'hide' => 0
                ];
                $this->db->table('students')->insert($st);
            }
        } else {
            // foreach ($data as $row) {
            //     $builder = $db->table('subjectsmarks_c11');
            //     $builder->set('darebea', $row->darebea);
            //     $builder->where('studentID', $row->studentID);
            //     $builder->update();
            // }
        }
    }

    /**
     * Promote all students from the current class to a higher one, except those whose id is passed in.
     * @param json $data this contains the id and the name of the student who will not be promoted.
     */
    function promoteStudents($data)
    {
        $ids = [];
        foreach ($data as $std) {
            array_push($ids, $std->id);
        }
        $classes = [
            'c12' => 'end',
            'c11' => 'c12',
            'c10' => 'c11'
        ];
        $students = $this->std->getStudents(false, 'id', ['class' => $this->session->get('class')]);
        foreach ($students as $std) {
            if (in_array($std['id'], $ids))
                continue;
            $this->db->table('students')->where(['id' => $std['id']])->update(['class' => $classes[$this->session->get('class')]]);
        }
    }
}
