<?
$config = array(
  'google_host' => 'docs.google.com',
  'google_path' => '/spreadsheets/d/e/2PACX-1vR9CXcrxfkPTUlannj7GQGXRbxaN3LCmcjDc0zvKwpm_is2Khy630Ru4_X6r3in_ZB_YqKpgzCOXssp/pub?gid=1831278462&single=true&output=csv',
  'ifttt_host' => 'maker.ifttt.com'
);

include(__DIR__ . '/../config.php');

if (isset($_GET['of'])) {
  $google =
      fsockopen('ssl://' . $config['google_host'], 443);
  fwrite($google, "GET $config[google_path] HTTP/1.1\r\n");
  fwrite($google, "Host: $config[google_host]\r\n");
  fwrite($google, "Connection: Close\r\n\r\n");

  while (!feof($google)) {
    $row = str_getcsv(trim(fgets($google), ','));

    if (strtolower($row[0]) == $_GET['of']) {
      echo $row[8];
    }
  }

  fclose($google);
}
?>
