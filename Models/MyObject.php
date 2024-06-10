<?php
namespace PhpCupcakes\Models; 

use PhpCupcakes\DAL\VanillaCupcakeDAL;

class MyObject
{
    public $id;
    public $name;
    public $description;

    public static $propertyMetadata = [
        'id' => ['type' => 'INT', 
            'length' => 11, 
            'extra' => 'AUTO_INCREMENT PRIMARY KEY', 
            'isSearchable'=> '0', 
            'searchableByAdmin'=> '0',  
            'isForm' => true,
            'userFriendlyName' => 'id',
            'formfield' => 'Hidden', 
            'placeholder' => null,
            'sortbyAsc' => false,
            'sortbyDesc' => false],
        'name' => ['type' => 'VARCHAR', 
            'length' => 255, 
            'isSearchable'=> '1', 
            'searchableByAdmin'=> '1',  
            'isForm' => true,
            'userFriendlyName' => 'name',
            'formfield' => 'Text', 
            'placeholder' => 'choose a name',
            'sortbyAsc' => true,
            'userFriendlySortAsc' => 'name a-z',
            'sortbyDesc' => true,
            'userFriendlySortDesc' => 'name z-a'],
        'description' => ['type' => 'TEXT', 
            'isSearchable'=> '1', 
            'searchableByAdmin'=> '1', 
            'isForm' => true,
            'userFriendlyName' => 'description',
            'formfield' => 
            'Textarea', 
            'placeholder' => 'write a description',
            'sortbyAsc' => false,
            'sortbyDesc' => false],
        'CREATED_AT' => ['type' => 'DATETIME',
            'extra' => 'DEFAULT CURRENT_TIMESTAMP',
            'isSearchable'=> '0', 
            'searchableByAdmin'=> '0',
            'isForm' => false,
            'sortbyAsc' => false,
            'sortbyDesc' => false]
    ];

    public static function getTableName()
    {
        return 'objects';
    }
    public static function getUserFriendlyName()
    {
        return 'My&nbsp;Object';
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
    public static function findAllPaginateSorted($currentPage, $itemsPerPage)
    {
        return VanillaCupcakeDAL::findAllPaginateSorted(__CLASS__, $currentPage, $itemsPerPage);
    }
    public static function getTotalofAll()
    {
        return VanillaCupcakeDAL::getTotalofAll(__CLASS__);
    }
    public static function searchOneTable($searchQuery, $columnName, $currentPage = 1, $itemsPerPage = 10) 
    {
        return VanillaCupcakeDAL::searchOneTable(__CLASS__, $searchQuery, $columnName, $currentPage = 1, $itemsPerPage = 10);
    }
    public static function delete($id)
    {
        VanillaCupcakeDAL::delete(__CLASS__, $id);
    }
}