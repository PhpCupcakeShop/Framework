<?php

namespace GeoBsnsMod\Models; 
 
use PhpCupcakes\DAL\VanillaCupcakeDAL; 
 
class Locations 
{ 
    public $id; 
    public $store_number; 
    public $location_name; 
    public $gmaps_coord; 
    public $addressln1; 
    public $addressln2; 
    public $city; 
    public $state_prov; 
    public $country; 
    public $zip; 
    public $CREATED_AT; 
 
    public static $propertyMetadata = [ 
        'id' => ['type' => 'INT', 
            'length' => 11, 
            'extra' => 'AUTO_INCREMENT PRIMARY KEY', 
            'isSearchable'=> false, 
            'searchableByAdmin'=> false, 
            'isForm' => true, 
            'display' => false, 
            'userFriendlyName' => 'id', 
            'formfield' => 'Hidden', 
            'placeholder' => null, 
            'sortbyAsc' => false, 
            'sortbyDesc' => false], 
        'store_number' => ['type' => 'VARCHAR',
                'length' => 255, 
               'extra' => '', 
               'isSearchable'=> true, 
               'searchableByAdmin'=> true, 
               'isForm' => true, 
               'isLink' => false, 
               'display' => true, 
               'userFriendlyName' => '#', 
               'formfield' => 'TEXT', 
               'placeholder' => 'enter an identifier such as a store number', 
               'sortbyAsc' => true, 
               'userFriendlySortAsc' => 'store # asc', 
               'sortbyDesc' => true, 
               'userFriendlySortDesc' => 'store # desc'], 
        'location_name' => ['type' => 'VARCHAR',
                'length' => 255, 
               'extra' => '', 
               'isSearchable'=> true, 
               'searchableByAdmin'=> true, 
               'isForm' => true, 
               'isLink' => true, 
               'display' => true, 
               'userFriendlyName' => 'Store Location', 
               'formfield' => 'TEXT', 
               'placeholder' => 'enter the name of your store location', 
               'sortbyAsc' => true, 
               'userFriendlySortAsc' => 'name a-z', 
               'sortbyDesc' => true, 
               'userFriendlySortDesc' => 'name z-a'], 
        'gmaps_coord' => ['type' => 'VARCHAR',
                'length' => 255, 
               'extra' => '', 
               'isSearchable'=> false, 
               'searchableByAdmin'=> true, 
               'isForm' => true, 
               'isLink' => false, 
               'display' => false, 
               'userFriendlyName' => 'Location Coordinates', 
               'formfield' => 'TEXT', 
               'placeholder' => 'enter the coordinates for the location ex:', 
               'sortbyAsc' => false, 
               'userFriendlySortAsc' => '', 
               'sortbyDesc' => false, 
               'userFriendlySortDesc' => ''], 
        'addressln1' => ['type' => 'VARCHAR',
                'length' => 255, 
               'extra' => '', 
               'isSearchable'=> true, 
               'searchableByAdmin'=> true, 
               'isForm' => true, 
               'isLink' => false, 
               'display' => true, 
               'userFriendlyName' => 'Address Line 1', 
               'formfield' => 'TEXT', 
               'placeholder' => 'enter address line 1', 
               'sortbyAsc' => false, 
               'userFriendlySortAsc' => '', 
               'sortbyDesc' => false, 
               'userFriendlySortDesc' => ''], 
        'addressln2' => ['type' => 'VARCHAR',
                'length' => 255, 
               'extra' => '', 
               'isSearchable'=> true, 
               'searchableByAdmin'=> true, 
               'isForm' => true, 
               'isLink' => false, 
               'display' => true, 
               'userFriendlyName' => 'Address Line 2', 
               'formfield' => 'TEXT', 
               'placeholder' => 'enter address line 2 if applicable', 
               'sortbyAsc' => false, 
               'userFriendlySortAsc' => '', 
               'sortbyDesc' => false, 
               'userFriendlySortDesc' => ''], 
        'city' => ['type' => 'VARCHAR',
                'length' => 255, 
               'extra' => '', 
               'isSearchable'=> true, 
               'searchableByAdmin'=> true, 
               'isForm' => true, 
               'isLink' => false, 
               'display' => true, 
               'userFriendlyName' => 'City', 
               'formfield' => 'TEXT', 
               'placeholder' => 'enter the city', 
               'sortbyAsc' => true, 
               'userFriendlySortAsc' => 'city a-z', 
               'sortbyDesc' => true, 
               'userFriendlySortDesc' => 'city z-a'], 
        'state_prov' => ['type' => 'VARCHAR',
                'length' => 255, 
               'extra' => '', 
               'isSearchable'=> true, 
               'searchableByAdmin'=> true, 
               'isForm' => true, 
               'isLink' => false, 
               'display' => true, 
               'userFriendlyName' => 'State or Province', 
               'formfield' => 'TEXT', 
               'placeholder' => 'enter the location state or province', 
               'sortbyAsc' => true, 
               'userFriendlySortAsc' => 'state a-z', 
               'sortbyDesc' => true, 
               'userFriendlySortDesc' => 'state z-a'], 
        'country' => ['type' => 'VARCHAR',
                'length' => 255, 
               'extra' => '', 
               'isSearchable'=> true, 
               'searchableByAdmin'=> true, 
               'isForm' => true, 
               'isLink' => false, 
               'display' => true, 
               'userFriendlyName' => 'Country', 
               'formfield' => 'TEXT', 
               'placeholder' => 'enter locations country', 
               'sortbyAsc' => true, 
               'userFriendlySortAsc' => 'country a-z', 
               'sortbyDesc' => true, 
               'userFriendlySortDesc' => 'country z-a'], 
        'zip' => ['type' => 'VARCHAR', 
                'length' => 255,
               'extra' => '', 
               'isSearchable'=> true, 
               'searchableByAdmin'=> true, 
               'isForm' => true, 
               'isLink' => false, 
               'display' => true, 
               'userFriendlyName' => 'Zip', 
               'formfield' => 'TEXT', 
               'placeholder' => 'enter the zip code', 
               'sortbyAsc' => true, 
               'userFriendlySortAsc' => 'zip asc', 
               'sortbyDesc' => true, 
               'userFriendlySortDesc' => 'zip desc'], 
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
        return 'business_location_module'; 
    } 
 
    public static function getUserFriendlyName() 
    { 
        return 'Business Location'; 
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
