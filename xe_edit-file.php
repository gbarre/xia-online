<?php

require_once('./xe_commons.php');

?>


<div class="file_data">
  <h3>Xia Extend !</h3>
  <label>Themes :</label>


<?php

foreach ($xia_themes as $theme) {
  echo "    <div class=\"checkbox\">\n";

  $replace = '_' . $theme . '.html';
  $compiled_file_name = preg_replace('/\.svg/', $replace, $row['url']);
  $compiled_file_exist = file_exists('./compiled/'.$compiled_file_name);

  $xe_link = "edit-file.php?file_id=" . filter_var($this_file_id,FILTER_VALIDATE_INT) . "&xe_create=" . $theme;

  if ($compiled_file_exist) {
    if ($_GET['xe_create'] == "unlink_".$theme) {
      unlink('./compiled/'.$compiled_file_name);
      $xe_prefix = "🔨";
    } else {
      $xe_prefix = "❌";
      $xe_link = preg_replace("/$theme/", "unlink_".$theme, $xe_link);
    }
  } else {
    if (in_array($_GET['xe_create'], $xia_themes) && $_GET['xe_create'] == $theme) {
      /* Do compilation
       * xia --input upload/files/file_name.svg --output compiled/ --theme $theme
       * sed -i 's/https:\/\/cdnjs.cloudflare.com\/ajax\/libs\/labjs\/2.0.3\/LAB.min.js/https:\/\/xia.dane.ac-versailles.fr\/demo\/napoleon\/js\/LAB.min.js/g' \
       * file_name_$theme.html
       */
      $xia_command = 'xia --input upload/files/' . $row['url'] . ' --output compiled/ --quality 3 --theme ' . $theme;
      $xia = shell_exec($xia_command);
      $sed = shell_exec('sed -i \'s/https:\/\/cdnjs.cloudflare.com\/ajax\/libs\/labjs\/2.0.3\/LAB.min.js/https:\/\/xia.dane.ac-versailles.fr\/demo\/napoleon\/js\/LAB.min.js/g\' compiled/' . $compiled_file_name);
      $xe_prefix = "❌";
      $xe_link = preg_replace("/$theme/", "unlink_".$theme, $xe_link);
    } else {
      $xe_prefix = "🔨";
    }
  }
  echo "<a href='" . $xe_link . "'>" . $xe_prefix . "</a>&nbsp;";

  if (file_exists('./compiled/'.$compiled_file_name)) {
    $download_link = BASE_URI . 'download.php?id=' . $this_file_id . '&token=' . $row['public_token'] . '&download=true&download_xe=' . $theme;
    echo "<a href='$download_link'>";
  }

  echo $theme;
  
  if (file_exists('./compiled/'.$compiled_file_name))
    echo "</a>";

  echo "\n    </div>\n";
}

?>

</div>
