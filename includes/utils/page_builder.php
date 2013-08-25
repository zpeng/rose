<?php

function outputHTMLStart($page_title = "", $js_deps = array(), $css_deps = array())
{
    echo "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\"
       \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\"><html><head>";

    echo "<title>" . $page_title . "</title>";

    echo output_js_tag($js_deps);
    echo output_css_tag($css_deps);

    echo "</head><body>";
}

function outputHTMLEnd()
{
    echo "</body></html>";
}

function output_js_tag($js_deps)
{
    foreach ($js_deps as $js) {
        if (is_array($js) && sizeof($js) > 0) {
            output_js_tag($js);
        } else {
            echo "<script type=\"text/javascript\" src=\"" . SERVER_URL . $js . "\"></script>";
        }
    }
}

function output_css_tag($css_deps)
{
    foreach ($css_deps as $css) {
        if (is_array($css) && sizeof($css) > 0) {
            output_css_tag($css);
        } else {
            echo  "<link rel=\"stylesheet\" type=\"text/css\" href=" . SERVER_URL . $css . " />";
        }
    }
}

function outputDependencies($key_array = [], $js_deps)
{
    $dep_list = [];
    // load deps from config
    foreach ($key_array as $key) {
        if (array_key_exists($key, $js_deps)) {
            $dep_list = array_merge($dep_list, $js_deps[$key]);
        }
    }

    // add server_url to each deps
    $count = 0;
    foreach ($dep_list as $dep) {
        $dep_list[$count] = SERVER_URL . $dep_list[$count];
        ++$count;
    }
    echo "'" . implode("','", $dep_list) . "'";
}

?>