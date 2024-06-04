<?php
namespace PhpCupcakes\Models; 

use PhpCupcakes\DAL\CupcakeDAL;

class MyObject
{
    public $id;
    public $name;
    public $description;

    public static $propertyMetadata = [
        'id' => ['type' => 'INT', 'length' => 11, 'extra' => 'AUTO_INCREMENT PRIMARY KEY', 'isSearchable'=> '0', 'searchableByAdmin'=> '1', 'formfield' => 'Hidden', 'placeholder' => ''],
        'name' => ['type' => 'VARCHAR', 'length' => 255, 'isSearchable'=> '1', 'searchableByAdmin'=> '1', 'formfield' => 'Text', 'placeholder' => 'choose a name'],
        'description' => ['type' => 'TEXT', 'isSearchable'=> '1', 'searchableByAdmin'=> '1', 'formfield' => 'Textarea', 'placeholder' => 'write a description']
    ];

    public static function getTableName()
    {
        return 'objects';
    }

    public function save()
    {
       
            CupcakeDAL::save($this);
   
    }

    public static function find($id)
    {
        return CupcakeDAL::find(__CLASS__, $id);
    }

    public static function findAll()
    {
        return CupcakeDAL::findAll(__CLASS__);
    }
    public static function findAllPaginated($currentPage, $itemsPerPage)
    {
        return CupcakeDAL::findAllPaginated(__CLASS__, $currentPage, $itemsPerPage);
    }
    public static function getTotalofAll()
    {
        return CupcakeDAL::getTotalofAll(__CLASS__);
    }

    public static function getTotalofSearch($searchTerm, $column = null)
    {
        return CupcakeDAL::getTotalofSearch(__CLASS__, $searchTerm, $column);
    }

    public static function search($searchTerm, $column = null, $currentPage = 1, $itemsPerPage = 10)
    {
        return CupcakeDAL::search(__CLASS__, $searchTerm, $column, $currentPage, $itemsPerPage);
    }
    public static function delete($id)
    {
        CupcakeDAL::delete(__CLASS__, $id);
    }
}