<?php 

namespace PrettyLinkTree\Models; 
 
use PhpCupcakes\DAL\VanillaCupcakeDAL; 
 
class LinkTree 
{ 
    public $id; 
    public $icon; 
  //  public $icon_class; 
    public $icon_color; 
    public $font_size; 
    public $url; 

    public $sortOrder;

    public $CREATED_AT; 
 
    public static $propertyMetadata = [ 
        'id' => ['type' => 'INT', 
            'length' => 11, 
            'extra' => 'AUTO_INCREMENT PRIMARY KEY', 
            'isSearchable'=> false, 
            'searchableByAdmin'=> true, 
            'isForm' => true, 
            'display' => false, 
            'userFriendlyName' => 'id', 
            'formfield' => 'Hidden', 
            'placeholder' => null, 
            'sortbyAsc' => false, 
            'sortbyDesc' => false], 
        'icon' => ['type' => 'VARCHAR', 
                'length' => 255, 
               'isSearchable'=> 'false', 
               'searchableByAdmin'=> 'false', 
               'isForm' => true, 
               'isLink' => true, 
               'display' => true, 
               'userFriendlyName' => 'font awesome icon class', 
               'formfield' => 'text', 
               'placeholder' => '', 
               'sortbyAsc' => false, 
               'userFriendlySortAsc' => '', 
               'sortbyDesc' => false, 
               'userFriendlySortDesc' => ''], 
  /*      'icon_class' => ['type' => 'VARCHAR', 
'length' => 255, 
               'isSearchable'=> 'false', 
               'searchableByAdmin'=> 'false', 
               'isForm' => true, 
               'isLink' => false, 
               'display' => true, 
               'userFriendlyName' => 'icon class', 
               'formfield' => 'text', 
               'placeholder' => 'fa-solid', 
               'sortbyAsc' => false, 
               'userFriendlySortAsc' => '', 
               'sortbyDesc' => false, 
               'userFriendlySortDesc' => ''], */
        'icon_color' => ['type' => 'VARCHAR', 
'length' => 255,
               'isSearchable'=> 'false', 
               'searchableByAdmin'=> '', 
               'isForm' => true, 
               'isLink' => false, 
               'display' => true, 
               'userFriendlyName' => 'icon color', 
               'formfield' => 'color', 
               'placeholder' => '#000', 
               'sortbyAsc' => false, 
               'userFriendlySortAsc' => '', 
               'sortbyDesc' => false, 
               'userFriendlySortDesc' => ''], 
        'font_size' => ['type' => 'VARCHAR', 
'length' => 255, 
               'isSearchable'=> 'false', 
               'searchableByAdmin'=> 'false', 
               'isForm' => true, 
               'isLink' => false, 
               'display' => true, 
               'userFriendlyName' => 'font size', 
               'formfield' => 'text', 
               'placeholder' => '36px', 
               'sortbyAsc' => false, 
               'userFriendlySortAsc' => '', 
               'sortbyDesc' => false, 
               'userFriendlySortDesc' => ''], 
                'url' => ['type' => 'VARCHAR', 
                'length' => 255, 
               'isSearchable'=> 'true', 
               'searchableByAdmin'=> 'true', 
               'isForm' => true, 
               'isLink' => true, 
               'display' => true, 
               'userFriendlyName' => 'url', 
               'formfield' => 'text', 
               'placeholder' => 'url', 
               'sortbyAsc' => true, 
               'userFriendlySortAsc' => '', 
               'sortbyDesc' => false, 
               'userFriendlySortDesc' => ''], 
            'sortOrder' => ['type' => 'INT', 
                'length' => 11, 
                'isSearchable'=> false, 
                'searchableByAdmin'=> true, 
                'isForm' => true, 
                'display' => false, 
                'userFriendlyName' => 'sortOrder', 
                'formfield' => 'text', 
                'placeholder' => null, 
                'sortbyAsc' => true, 
                'userFriendlySortAsc' => 'sort',
                'sortbyDesc' => false],
        'CREATED_AT' => ['type' => 'TIMESTAMP', 
            'extra' => 'DEFAULT CURRENT_TIMESTAMP NOT NULL', 
            'isSearchable'=> false, 
            'searchableByAdmin'=> false, 
            'isForm' => false, 
            'display' => false, 
            'sortbyAsc' => true, 
            'userFriendlySortAsc' => 'oldest', 
            'sortbyDesc' => true, 
            'userFriendlySortDesc' => 'newest'] 
    ]; 
 
    public static function getTableName() 
    { 
        return 'linktree'; 
    } 
 
    public static function getUserFriendlyName() 
    { 
        return 'Link&nbsp;Tree'; 
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
 
    public static function findAllSortedAuto()

{
    return VanillaCupcakeDAL::findAllSortedAuto(__class__, $orderBy = ['sortOrder' => 'ASC']);
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
