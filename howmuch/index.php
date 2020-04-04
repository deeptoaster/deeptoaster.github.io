<?
$config = array(
  'host' => 'docs.google.com',
  'port' => 443,
  'path' => '/spreadsheets/d/e/2PACX-1vR9CXcrxfkPTUlannj7GQGXRbxaN3LCmcjDc0zvKwpm_is2Khy630Ru4_X6r3in_ZB_YqKpgzCOXssp/pub?gid=1831278462&single=true&output=csv'
);

if (isset($_GET['of'])) {
  $handle = fsockopen('ssl://' . $config['host'], $config['port']);
  fwrite($handle, "GET $config[path] HTTP/1.1\r\n");
  fwrite($handle, "Host: $config[host]\r\n");
  fwrite($handle, "Connection: Close\r\n\r\n");

  while (!feof($handle)) {
    $row = str_getcsv(trim(fgets($handle), ','));

    if (strtolower($row[0]) == $_GET['of']) {
      echo $row[8];
    }
  }

  fclose($handle);
}
?>
