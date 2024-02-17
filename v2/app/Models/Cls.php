<?php

namespace App\Models;

use CodeIgniter\Model;

class Cls extends Model
{
    protected $forge = "";
    protected $db = "";
    protected $session = "";

    public function __construct()
    {
        $this->forge = \Config\Database::forge();
        $this->db = db_connect();
        $this->session = session();
    }

    /**
     * Get the `class name`.
     * @param string $cls The class name code. like: _c10_.
     * @param boolean $nameOnly whether to return only the class name or all the class data.
     * @return string|array The class name, or the class data based on $nameOnly.
     */
    public function getClassByName($cls, $NameOnly = true)
    {
        if ($NameOnly)
            return $this->db->table('classes')->getWhere(['name' => $cls])->getResultArray()[0]['name'];
        else
            return $this->db->table('classes')->getWhere(['name' => $cls])->getResultArray()[0];
    }

    /**
     * Delete a class from the database.
     * @return void
     */
    public function deleteClass($id)
    {
        $name = $this->getClassByName($id);

        $this->forge->dropTable('subjectsmarks_' . $name, true);
        $this->forge->dropTable('students_' . $name, true);
        $this->forge->dropTable('subjects_' . $name, true);

        $builder = $this->db->table('classes');
        $builder->delete(['name' => $name]);
    }

    /**
     * Get all classes data.
     * @return array Of objects [[id => 1, ],]
     */
    public function getClasses()
    {
        $classes = $this->db->table('classes')->get()->getResult();
        $data = [];
        foreach ($classes as $key => $value) {
            $data[$key] = $value;
        }
        return $data;
    }

    /**
     * Get class' sections based on its name `c10`
     * @return int the number of sections
     */
    public function getClassSections($className)
    {
        $classes = $this->getClasses();
        foreach ($classes as $class) {
            if ($class->name == $className)
                return (int)$class->sections;
        }
    }

    /**
     * Add a class, then create a table for its subjects and subjects' marks.
     */
    public function addClass($id, $name, $arabic, $sections)
    {
        $builder = $this->db->table('classes');

        $builder->insert([
            'class_id' => $id,
            'name' => $name,
            'arabic' => $arabic,
            'sections' => $sections,
        ]);

        $this->forge->addField(
            [
                'id' => [
                    'type' => 'INT',
                    'constraint' => 7,
                    'auto_increment' => true,
                ],
                'studentID' => [
                    'type' => 'INT',
                ],
            ]
        );
        $this->forge->addKey('id', true);
        $this->forge->createTable('subjectsmarks_' . $name);

        $this->forge->addField(
            [
                'id' => [
                    'type' => 'INT',
                    'constraint' => 7,
                    'auto_increment' => true,
                ],
                'name' => [
                    'type' => 'longtext',
                ],
                'arabic' => [
                    'type' => 'longtext',
                ],
                'tutor' => [
                    'type' => 'longtext',
                ],
                'max' => [
                    'type' => 'INT',
                ],
                'min' => [
                    'type' => 'INT',
                ],
                'priority' => [
                    'type' => 'INT',
                ],
                'header' => [
                    'type' => 'longtext',
                ],
            ]
        );
        $this->forge->addKey('id', true);
        $this->forge->createTable('subjects_' . $name);
    }

    /**
     * 
    */
    public function editClass($id, $class_id, $name, $arabic, $sections)
    {
        $builder = $this->db->table('classes');
        $builder->where('id', $id);
        return $builder->update([
            'class_id' => $class_id,
            'name' => $name,
            'arabic' => $arabic,
            'sections' => $sections
        ]);
    }
}
