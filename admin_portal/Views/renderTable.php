<?php 
    use PhpCupcakes\Helpers\FormHelper;
    ?>

<table border="2">
<thead><tr>
    <?php foreach ($fieldNames as $fieldName) { ?>
    <th><?= $fieldName ?></th>
    <?php } ?>
<th>edit</th><th>delete</th></tr></thead>
<tbody>
<?php foreach ($data as $row) { ?>
    <tr>
    <?php foreach ($row as $key => $value) { ?>
        <td><?= $value ?></td>
        <?php } ?>
    <td><button id="edit-btn-<?= $row[
        "id"
    ] ?>" class='edit-btn' data-id='<?= $row[
"id"
] ?>'>Edit</button></td>
    <td><button class='delete-btn' data-id='<?= $row[
        "id"
    ] ?>'>Delete</button></td>
    </tr>
    <tr class='edit-form-row-<?= $row["id"] ?>' data-id='<?= $row[
"id"
] ?>'>
    <form class='edit-form' data-id='<?= $row["id"] ?>'>
        <?php foreach ($fieldNames as $fieldName) {

            $metadata = $className::$propertyMetadata[$fieldName];
            $type = $metadata["formfield"];
            ?>
            <td>
                <?php
                if ($fieldName == "id") {
                } else {
                     ?>
                    <label for='<?= $fieldName ?>'><?= $fieldName ?>:</label>
                    <?php
                }
                $formFunction = "render" . $type;
                echo FormHelper::$formFunction(
                    $fieldName,
                    $row[$fieldName],
                    ["" => "required"]
                );
                ?>
            </td>
            <?php
        } ?>
        <td colspan="2"><button type='submit' class='btn btn-primary'>Save</button></td>
    </form>
    </tr>
    <?php } ?>
</tbody>
</table>


<script>
  let toggleCustomFieldLink = document.getElementById('edit-btn-<?= $row[
      "id"
  ] ?>');
  let customFieldElement = document.getElementById('edit-form-row-<?= $row[
      "id"
  ] ?>');
    toggleCustomFieldLink.addEventListener('click', function(event) {
      isCustomFieldVisible = !isCustomFieldVisible;
      customFieldElement.style.display = isCustomFieldVisible ? 'block' : 'none';
})
</script>