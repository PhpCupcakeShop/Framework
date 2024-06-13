# CRUD Operations with PhpCupcakeShop

> [!TIP]
> 
> This is not a guide to using php, it goes over the Classes and functions used in the data access layer, along with the Model files, used in preforming CRUD operations with PhpCupcakeShop. For a more comprehensive guide to make each full page, checkout the ViewsCRUD.md file.

> [!NOTE]
> All PHP code should be wrapped in "`<?php`" & "`?>`" tags unless otherwise wrapped in the short hand echo tag "`<?=`" "`?>`".

### Loading the autoloader:

> `require_once $_SERVER['DOCUMENT_ROOT'] . '/Framework/autoload.php';`

 Every page requires the autoloader found at Framework/autoload.php.

## First we will work with the create operation:

### Load your Model File:

>  `use Objects\Models\MyObject;`

> [!NOTE]
> 
> These are to be placed in the models folder, under a Directory of your choosing, and then again in a folder named Models.  The first part of the Class namespace is the directory name of your choosing, then 'Models', then the name of the Class and File without the extension.

Every time a Class is used with an autoloader the `use` statement can load it according to the autoloaders instructions. So include this in any page the Class is used.

### Using forms:

When making the forms it works well with the model files to make the post values tableName-columnName. So for example if the table is 'objects' and the column is 'name': `<input type="text" name="objects-name" placeholder="enter a name for your object">`

### Uploading to the database:

To create a new table row, start with creating an instance of  your object:

> `$myObject = new MyObject();`

For each column name add this to the object:

> `$myObject->name = $_POST['object-name'];`

Save your object to the database:

>  `$myObject->save();`

> [!NOTE]
> 
> It is not neccessary to make a table ahead of your first database entry.

 Load the id of the row just entered:

> `lastInsertId = myObject->id;`

### Advanced:

To make the pages reusable, or to keep up with a changing model file, you can recursively place the forms (see Form Helper MD file when built) and insertion:

> `foreach (MyObject::$propertyMetadata as $columnName => $metadata) {`

> `$tableName = MyObject::getTableName();`

> `if ($columnName == 'id') {} else {`

> `$myObject->$columnName = $_POST[$tableName . '-' . $columnName];`

> `}`

> `}`

## Next we will work with viewing the table data:

### Viewing all information:

Load the objects:

> `$objects = MyObject::findAll();`

Start a loop:

> `foreach ($objects as $object) {` 
> 
> `//place the code below here`
> 
> `}`

Display each object by column name within the loop:

> `<?= htmlspecialchars($object->name) ?>`

> [!TIP]
> 
> Be sure to encase in the htmlspecialchars function.

### Viewing one row:

Loading an object based on id:

> `$object = MyObject::find($id);`

Display each column: 

> `<?= htmlspecialchars($object->name) ?>`

## Updating to the database:

Start with finding the object to update:

> `$myObject = MyObject::find($id);`

For each column name add to the object:

> `$myObject->name = $_POST['object-name'];`

Save your object to the database:

> `$myObject->save();`

 Load the id of the row just updated:

> `$lastInsertId = $myObject->id;`

## Deleting from the database:

Find the object to delete:

> `$myObject = $MyObject::find($id);`

Delete the object:

> `$myObject->($id);`

# Extra:

## Restricting pages:

Add the following to any page that you would like a user to be in "edit mode" to view.

> [!NOTE]
> 
> I will be working on OAuth modules and each module will come with its own auth file.

> `use PhpCupcakeShop\Config\ConfigVars; //only add this to a page once`
> 
> `require_once ConfigVars::getFrameworkSrc().'/EditMode/auth.inc.php';`

## Adding a Security Token:

Hide the following in any form:

> `<input type="hidden" name="csrf_token" value="<?=  $_SESSION['csrf_token']  ?>`

Then on the confirmation page include the following before any CRUD functions:

> `if ($_SERVER['REQUEST_METHOD'] === 'POST') {`

> `if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {`

> `// CSRF token is invalid, reject the request`

> `http_response_code(400);`

> `echo "Invalid CSRF token";`

> `exit;`

> `}`

> `}`

# Advanced:

It is possible to load the column information from the rows recursively, with little code if there are many columns. It doesn't allow for much customization. Here is an example with post data:

> foreach (MyObject::propertyMetadata as columnName => $metadata) {`

> `$tableName = MyObject::getTableName();`

> `if ($columnName == 'id') {} else {`

> `$myObject->$columnName = $_POST[$tableName . '-' . $columnName];`

> `}`

> `}`

Also see the Form Helper File for an easy way to load forms with knowing the input type. (This is stored in the Model File.)

> `foreach (MyObject::$propertyMetadata as $columnName => $metadata) {`

> `$tableName = MyObject::getTableName();`

> `$renderFormField = 'render' . $metadata['formfield'];`

> `$placeholder = $metadata['placeholder'];`

> `echo FormHelper::$renderFormField($tableName . '-' . $columnName, '', ['class' => 'form-control', 'placeholder'=> $placeholder]);`

> `}`


