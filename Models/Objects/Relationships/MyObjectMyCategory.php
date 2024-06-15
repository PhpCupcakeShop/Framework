<?php
namespace Objects\Relationships; 

use PhpCupcakes\DAL\RelationalDAL;
use PhpCupcakes\DAL\VanillaCupcakeDAL;

class MyObjectMyCategory
{
    public $id;

    public $objects_id;

    public $categories_id;

    private $relationshipName = 'objects_categories';

    public static $propertyMetadata = [
        'id' => ['type' => 'INT', 
            'length' => 11, 
            'extra' => 'AUTO_INCREMENT PRIMARY KEY', 
            'isSearchable'=> false, 
            'searchableByAdmin'=> true],
        'objects_id' => ['type' => 'INT', 
                'length' => 11,
                'isSearchable'=> false, 
                'searchableByAdmin'=> true],
        'categories_id' => ['type' => 'INT', 
                    'length' => 11, 
                    'isSearchable'=> false, 
                    'searchableByAdmin'=> true],    
    ];

    public static function getTableNames($entity)
    {   
        switch ($entity) {
            case 'objects':
                return 'objects';
            break;
            case 'categories':
                return 'categories';
            break; 
        }
    }
    public static function getEntityIdColumnName($entity)
    {   
        switch ($entity) {
            case 'objects':
                return 'objects_id';
            break;
            case 'categories':
                return 'categories_id';
            break; 
        }
    }
    public static function getTableName()
    {
        return 'object_categories';
    }
    public static function getUserFriendlyName()
    {
        return 'My&nbsp;Object Categories';
    }
    public function save()
    {
       
        VanillaCupcakeDAL::save($this);
   
    }

    public static function getRelatedMyObjects($objects_id)
    {
        return VanillaCupcakeDAL::getRelatedEntities(__CLASS__, $objects_id, 'objects', 'categories');
    }
    
    public static function getRelatedMyCategories($categories_id)
    {
        return VanillaCupcakeDAL::getRelatedEntities(__CLASS__, $categories_id, 'categories', 'objects');
    }
    
}