<?php

function createGenericTable($id = "", $class = "", $dataSource)
{
    $htmlTable = "<table id='$id' class='$class'>";
    $htmlTable = $htmlTable . "<thead><tr>";

    foreach ($dataSource["header"] as $head_value) {
        $htmlTable = $htmlTable . "<th>" . $head_value . "</th>";
    }
    $htmlTable = $htmlTable . "</tr></thead>";

    $htmlTable = $htmlTable . "<tbody>";
    foreach ($dataSource["body"] as $row) {
        $htmlTable = $htmlTable . "<tr>";
        foreach ($row as $cell) {
            $htmlTable = $htmlTable . " <td>" . $cell . "</td>";
        }
        $htmlTable = $htmlTable . "</tr>";
    }
    $htmlTable = $htmlTable . "</tbody>";

    $htmlTable = $htmlTable . "</table>";
    return $htmlTable;
}

function createCheckboxList($id = "", $class = "", $name = "", $dataSource)
{
    /*
    $dataSource = array(
        "data" => array(
            "key1" => "value1",
            "key2" => "value2",
            "key3" => "value3",
            "key4" => "value4",
            "key5" => "value5",
        ),
        "selected" => array(
            "key1" => "value1",
            "key4" => "value4",
        )
    );
    */

    $html = "<ul class='$class' id='$id'>";
    if (array_key_exists("data", $dataSource) && sizeof($dataSource["data"]) > 0) {
        foreach ($dataSource["data"] as $key => $value) {
            if (array_key_exists("selected", $dataSource) && array_key_exists($key, $dataSource["selected"])) {
                $html = $html . "<li><input  checked='true' type='checkbox'  name='$name' value='" . $value . "'><label>" . $key . "</label>";
            } else {
                $html = $html . "<li><input type='checkbox'  name='$name' value='" . $value . "'><label>" . $key . "</label>";
            }
        }
    }
    return $html = $html . "</ul>";
}

function createList($list_id = "", $list_class = "", $list_item_class = "", $dataSource)
{
    /*
    $dataSource = array(
        "id" => "data",
        "id" => "data",
    );
    */
    $html = "<ul class='$list_class' id='$list_id'>";
    if ( sizeof($dataSource) > 0) {
        foreach ($dataSource as $key => $value) {
           $html = $html . "<li id='$key' class='$list_item_class'>$value</li>";
        }
    }
    return $html = $html . "</ul>";
}

function createTreeviewRadioList($id = "", $class = "", $name = "", $dataSource = array(), $selectedValue = "")
{
    /*
    $dataSource = array(
     array(
            "id" => "1",
            "label" => "item 1",
            "children" => array(
                "2" => array(
                    "id" => "2",
                    "label" => "item 2",
                    "children" => array()
                ),
                "3" => array(
                    "id" => "3",
                    "label" => "item 3",
                    "children" => array()
                )
            )
    )
    );*/

    $html = "<ul class='$class' id='$id'>";
    foreach ($dataSource as $value) {
        if ($value["id"] == $selectedValue) {
            $html = $html . "<li><input  checked='true' type='radio'  name='$name' value='" . $value["id"] . "'><label>" . $value["label"] . "</label>";
        } else {
            $html = $html . "<li><input type='radio'  name='$name' value='" . $value["id"] . "'><label>" . $value["label"] . "</label>";
        }

        if (sizeof($value["children"]) > 0) {
            $html = $html . "<ul>";
            foreach ($value["children"] as $child) {
                $html = $html . createTreeviewRadioChild($name, $child, $selectedValue);
            }
            $html = $html . "</ul>";
        }
    }
    return $html = $html . "</ul>";
}

function createTreeviewRadioChild($name = "", $value = array(), $selectedValue = "")
{
    $html = "";
    if ($value["id"] == $selectedValue) {
        $html = $html . "<li><input  checked='true' type='radio'  name='$name' value='" . $value["id"] . "'><label>" . $value["label"] . "</label>";
    } else {
        $html = $html . "<li><input type='radio'  name='$name' value='" . $value["id"] . "'><label>" . $value["label"] . "</label>";
    }

    if (sizeof($value["children"]) > 0) {
        $html = $html . "<ul>";
        foreach ($value["children"] as $child) {
            $html = $html . createTreeviewRadioChild($name, $child, $selectedValue);
        }
        $html = $html . "</ul>";
    }
    return $html;
}

function createDropdownList($id = "", $name = "", $class = "", $style = "", $display_size = "1", $dataSource)
{
    /*
    $dataSource = array(
        "data" => array(
            "label1" => "value1",
            "label2" => "value2",
            "label3" => "value3",
            "label4" => "value4",
            "label5" => "value5",
        ),
        "selected" => array(
            "label1" => "value1",
            "label2" => "value4",
        )
    );
    */

    $html = "<select id='" . $id . "' name='" . $name . "' class='$class' style='$style' size='$display_size'>";
    if (sizeof($dataSource["data"]) > 0) {
        foreach ($dataSource["data"] as $key => $value) {
            if (array_key_exists("selected", $dataSource) &&  in_array($value, $dataSource["selected"])) {
                $html = $html . "<option  value='" . $value . "' selected>" . $key . "</option>";
            } else {
                $html = $html . "<option  value='" . $value . "'>" . $key . "</option>";
            }
        }
    }
    return $html = $html . "</select>";
}

function createMultipleDropdownList($id = "", $name = "", $class = "", $style = "", $dataSource)
{
    /*
    $dataSource = array(
        "data" => array(
            "label1" => "value1",
            "label2" => "value2",
            "label3" => "value3",
            "label4" => "value4",
            "label5" => "value5",
        ),
        "selected" => array(
            "label1" => "value1",
            "label2" => "value4",
        )
    );
    */

    $html = "<select multiple id='" . $id . "' name='" . $name . "' class='$class' style='$style'>";
    if (!empty($dataSource) && sizeof($dataSource["data"]) > 0) {
        foreach ($dataSource["data"] as $key => $value) {
            if (array_key_exists("selected", $dataSource) &&  in_array($value, $dataSource["selected"])) {
                $html = $html . "<option  value='" . $key . "' selected>" . $value . "</option>";
            } else {
                $html = $html . "<option  value='" . $key . "'>" . $value . "</option>";
            }
        }
    }
    return $html = $html . "</select>";
}

function createImage($imageUrl, $class, $width, $height, $border = 0)
{
    return "<img border='$border' width='$width' height='$height' class='$class' src='" . $imageUrl . "' />";
}

?>
