<?php
namespace PhpCupcakes\Models; 

use PhpCupcakes\DAL\VanillaCupcakeDAL;

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
       
            VanillaCupcakeDAL::save($this);
   
    }

    public static function find($id)
    {
        return VanillaCupcakeDAL::find(__CLASS__, $id);
    }

    public static function findAll()
    {
        return VanillaCupcakeDAL::findAll(__CLASS__);
    }
    public static function findAllPaginated($currentPage, $itemsPerPage)
    {
        return VanillaCupcakeDAL::findAllPaginated(__CLASS__, $currentPage, $itemsPerPage);
    }
    public static function getTotalofAll()
    {
        return VanillaCupcakeDAL::getTotalofAll(__CLASS__);
    }

    public static function getTotalofSearch($searchTerm, $column = null)
    {
        return VanillaCupcakeDAL::getTotalofSearch(__CLASS__, $searchTerm, $column);
    }

    public static function search($searchTerm, $column = null, $currentPage = 1, $itemsPerPage = 10)
    {
        return VanillaCupcakeDAL::search(__CLASS__, $searchTerm, $column, $currentPage, $itemsPerPage);
    }
    public static function delete($id)
    {
        VanillaCupcakeDAL::delete(__CLASS__, $id);
    }
}