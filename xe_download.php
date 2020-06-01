<?php

require_once('./xe_commons.php');

?>

<h3>Ressources Xia :</h3>

<?php
$count = 0;
foreach ($xia_themes as $theme) {
  echo "    <div class=\"checkbox\">\n";

  $replace = '_' . $theme . '.html';
  $compiled_file_name = preg_replace('/\.svg/', $replace, $got_url['url']);

  if (file_exists('compiled/'.$compiled_file_name)) {
		$count++;
		$download_link = BASE_URI . 'download.php?id=' . $got_file_id . '&token=' . $got_token . '&download=true&download_xe=' . $theme;
    echo "<a href='$download_link'>$theme</a>&nbsp;";
  }

	echo "\n    </div>\n";
}

if ($count == 0)
	echo "<p>Aucune ressource créée pour le moment...</p>\n";


?>
