# A GUIDE TO CRUD IN THE VIEWS

### The Following File explains the parts of the View Files based on the Model File and how to build them.

> [!TIP]
> 
> For a less extensive more technical guide, check out the CRUDOperations.md file.

> [!NOTE]
> This will not be a guide to using HTML on the page, just how to implement the PHP Classess and Methods of the framework.

> [!NOTE]
> Replace "MyObject" with the name of your own Class files/Class.

> [!NOTE]
> All PHP code should be wrapped in "`<?php`" & "`?>`" tags unless otherwise wrapped in the short hand echo tag "`<?=`" "`?>`".

# Every Page

### Load the Autoloader

> `require_once $_SERVER['DOCUMENT_ROOT'] . '/Framework/autoload.php';`

### Load Your Google Analytics Code

> `use PhpCupcakes\Config\Analytics;`

> `<?= Analytics::Google() ?>`

### Using the ConfigVars Class to Load Stylesheets

> `use PhpCupcakes\Config\ConfigVars;`

> `<link rel="stylesheet" href="<?= ConfigVars::getWWW() ?>/assets/css/styles.css">`

### Load the neccessary Class for the Following Three

> `use PhpCupcakes\Helpers\LoadHtml;`

### Loading Views\includes\header.phtml

> `<?php`

> `$h1 = 'My Website';`

> `echo LoadHtml::loadInclude('header', ['h1' => $h1]);`

> `?>`

### Loading Views\includes\searchform.phtml

> `echo LoadHtml::loadInclude('searchform');`

### Loading the Views\includes\nav.phtml

> `<?= LoadHtml::loadInclude('nav'); ?>`

## Edit Mode

> `use PhpCupcakes\EditMode\EditLink;`

> `echo EditLink::displayEditModeNav();`

> `echo EditLink::displayEditLink();`

## Displaying Edit Mode Icons

> Load the font awesome icons

> `<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" crossorigin="anonymous" />`

> Load the editmode component from Views

> `echo LoadHtml::loadComponent('editmode/displayEdit', ['id' => $object->id, 'type' => 'MyObject']);`

# Any Restricted Page

> Typically the create, edit, and delete of the CRUD operations.

> `require_once ConfigVars::getFrameworkSrc().'/EditMode/auth.inc.php';`

# CSRF Tokens

> These will be hidden in any form:

> `?><input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>"><?php`

> Then asked for on the form confirmation page:

> `if ($_SERVER['REQUEST_METHOD'] === 'POST') {`

> `if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {`

> `// CSRF token is invalid, reject the request`

> `http_response_code(400);`

> `echo "Invalid CSRF token";`

> `exit;`

> `}`

> `}`

# addMyObject.phtml

### Loading the FormHelper

> `use PhpCupcakes\Helpers\FormHelper;`

### Opening the form

> `echo FormHelper::renderFormOpen('added', 'post', ['class' => 'form-horizontal']);`

### Loading your Model

> `use PhpCupcakes\Models\MyObject;`

### Using the FormHelper For All the Form Fields Specified in the Model File in the Models Dir

> [!TIP]
> If having difficulty with foreach loop used to render the form field, start with editMyObject.phtml below.

> `foreach (MyObject::$propertyMetadata as $columnName => $metadata) {`

> `$tableName = MyObject::getTableName();`

> `$renderFormField = 'render' . $metadata['formfield'];`

> `$placeholder = $metadata['placeholder'];`

> `echo FormHelper::$renderFormField($tableName . '-' . $columnName, '', ['class' => 'form-control', 'placeholder'=> $placeholder]);`

> `}`

### Rendering the Submit Button with the form helper

> `echo FormHelper::renderSubmit('Submit', 'submit', ['class' => 'btn btn-primary']);`

### Closing the form

> `echo FormHelper::renderFormClose();`

# MyObjectAdded.phtml

### Load the model Class

> `use PhpCupcakes\Models\MyObject;`

### Create a new instance of your model Class

> `$myObject = new MyObject();`

### Create a foreach loop to fill all Model columns except id

> `foreach (MyObject::$propertyMetadata as $columnName => $metadata) {`

> `$tableName = MyObject::getTableName();`

> `if ($columnName == 'id') {} else {`

> `$myObject->$columnName = $_POST[$tableName . '-' . $columnName];`

> `}`

> `}`

### Save the Table Row to the Database

> `$myObject->save();`

### Get the id of the Last Inserted Row

> `$lastInsertId = $myObject->id;`

### Create a Link to the Object for the User

> `<p>MyObject successfully inserted into the database.`

> `<a href="<?= ConfigVars::getSiteUrl() ?>/MyObject/view/<?= $lastInsertId ?>">View your object here</a>.`

> `</p>`

# MyObjectAll.phtml

### Load the Pagination Helper

> `use PhpCupcakes\Helpers\PaginationHelper;`

### Get any Current Pagination Parameters with Help from the Pagination Helper

> `list($currentPage, $itemsPerPage) = PaginationHelper::getPaginationParams();`

### Load Your Model Class File

> `use PhpCupcakes\Models\MyObject;`

### Get Objects for this Page Based on Parameters

> `$objects = MyObject::findAllPaginated($currentPage, $itemsPerPage);`

## Objects Loop

### Start the Loop

> `foreach ($objects as $object) {`

### Start the Renderer

> `ob_start();`

### Display Object Parameters Based on Your Table Column Values (example shown)

> Displaying the object name: 

> `<?= htmlspecialchars($object->name) ?>`

> Passing to a url to be viewed on its own (be sure to load ConfigVars if using the getSiteUrl Function):

> `<a href="<?= ConfigVars::getSiteUrl() ?>/MyObject/view/<?= $object->id ?>"><?= htmlspecialchars($object->name) ?></a>`

> Displaying the Object Description

> `<?= htmlspecialchars($object->description) ?>`

### Display the Edit Mode Icons from the Edit Mode Section Above

### End the Renderer and Capture the Rendered Info into a Variable

> `$displayObject = ob_get_clean();`

### Display the Rendered Info

> `echo $displayObject;`

### Get the Total Number of Objects For the Pagination Algorithm

> `$totalObjects = MyObject::getTotalofAll();`

### Display Pagination Links With Given Parameters

> `PaginationHelper::displayPaginationLinks($totalObjects, $currentPage, $itemsPerPage);`

# MyObject.phtml

### Load the Model/Class File

> `use PhpCupcakes\Models\MyObject;`

### Get the Specified Object From the URL

> `$object = MyObject::find($_GET['id']);`

### Start Renderer

> `ob_start();`

### Display Object Parameters Based On Your Table Column Values (example shown for MyObjectAll.phtml)

### Display the Edit Mode Icons from The Edit Mode Section Above

### End the Renderer and Capture the Rendered Info into a Variable

> `$displayObject = ob_get_clean();`

### Display the Rendered Info

> `echo $displayObject;`

### Add a Back Button for Easier Navigation (optional)

> `<a href="#" onclick="history.back()">back</a>`

# editMyObject.phtml

> [!TIP]
> This one will go through each form field instead of foreach loop like above in addMyObject.phtml.

### Load the Class/Model file

> `use PhpCupcakes\Models\MyObject;`

### Load the Specific Object By id From the URL

> `$object = MyObject::find($_GET['id']);`

### Start the Renderer

> `ob_start();`

### Open the Form With Proper URL Routing

> `echo FormHelper::renderFormOpen(ConfigVars::getSiteUrl().'/MyObject/update/'.$object->id, 'post', ['class' => 'form-horizontal']);`

## Build the Form

> [!NOTE]
> Fill these into be the column values for your own database table built with the Model File.

### Add the id as a Form Parameter

> `echo FormHelper::renderHidden('id', $_GET['id']);`

### Add the name as a Form Parameter

> `echo FormHelper::renderInput('text', 'objects-name', htmlspecialchars($object->name), ['class' => 'form-control']);`

### Add the description as a Form Parameter

> `echo FormHelper::renderTextarea('objects-description', htmlspecialchars($object->description), ['class' => 'form-control']);`

### Render the Submit Button

> `echo FormHelper::renderSubmit('Submit', 'submit', ['class' => 'btn btn-primary']);`

### Close the Form

> `echo FormHelper::renderFormClose();`

### End the Renderer and Capture the Rendered Info into a Variable

> `$displayObject = ob_get_clean();`

### Display the Rendered Info

> `echo $displayObject;`

### Add a Back Button for Easier Navigation (optional)

> `<a href="#" onclick="history.back()">back</a>`

# MyObjectUpdated.phtml

> [!TIP]
> This one will go through each post value instead of foreach loop as in MyObjectAdded.phtml.

### Load the Model/Class File

> `use PhpCupcakes\Models\MyObject;`

### Load the Object (table row) By id

> `$myObject = MyObject::find($_GET['id']);`

### Set the id By Post Value

> `$myObject->id = $_POST['id'];`

### Post All Other Parameters

> [!Important]
> Fill in according to your own database table names and columns.

> `$myObject->name = $_POST['objects-name'];`

> `$myObject->description = $_POST['objects-description'];`

### Save to the Database

> `$myObject->save();`

### Get the id

> `$lastInsertId = $myObject->id;`

### Link to the Object For the User

> `<p>MyObject successfully updated in the database. <a href="<?= ConfigVars::getSiteUrl() ?>/MyObject/view/<?= $lastInsertId ?>">View your object here</a>.</p>`

# deleteMyObject.phtml

### Load the Model/Class File

> `use PhpCupcakes\Models\MyObject;`

### Find the Object to Delete

> `$myObject = MyObject::find($_GET['id']);`

### Delete the Object

> `$myObject->delete($_GET['id']);`

### Confirm to the User

> `echo 'MyObject object deleted.';`

### Add a Link to the Most Appropriate Location after Deletion

> `<span>[<a href="<?= ConfigVars::getWWW() ?>">back home</a>]</span>`