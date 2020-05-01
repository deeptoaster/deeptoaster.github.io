<?
$config = array(
  'google_host' => 'docs.google.com',
  'google_path' => '/spreadsheets/d/e/2PACX-1vR9CXcrxfkPTUlannj7GQGXRbxaN3LCmcjDc0zvKwpm_is2Khy630Ru4_X6r3in_ZB_YqKpgzCOXssp/pub?gid=1831278462&single=true&output=csv',
  'ifttt_event' => 'notify',
  'ifttt_host' => 'maker.ifttt.com'
);

include(__DIR__ . '/../config.php');

if (isset($_GET['of'])) {
  $google =
      fsockopen('ssl://' . $config['google_host'], 443);
  fwrite($google, "GET $config[google_path] HTTP/1.1\r\n");
  fwrite($google, "Host: $config[google_host]\r\n\r\n");
  fwrite($google, "Connection: close\r\n\r\n");
  $of = $_GET['of'];

  if (substr($of, -3) == ' is') {
    $of = substr($of, 0, -3);
  }

  if (substr($of, -4) == ' are') {
    $of = substr($of, 0, -4);
  }

  while (!feof($google)) {
    $row = str_getcsv(trim(fgets($google), ','));

    if (strtolower($row[0]) == $of) {
      $path = "/trigger/$config[ifttt_event]/with/key/$config[ifttt_key]";
      $content = "{\"value1\": \"$row[8] $row[9]\"}";
      $length = strlen($content);
      $ifttt = fsockopen('ssl://' . $config['ifttt_host'], 443);
      fwrite($ifttt, "POST $path HTTP/1.1\r\n");
      fwrite($ifttt, "Host: $config[ifttt_host]\r\n");
      fwrite($ifttt, "Connection: close\r\n");
      fwrite($ifttt, "Content-Type: application/json\r\n");
      fwrite($ifttt, "Content-Length: $length\r\n\r\n");
      fwrite($ifttt, "$content\r\n\r\n");

      while (!feof($ifttt)) {
        fgets($ifttt);
      }

      fclose($ifttt);
    }
  }

  fclose($google);
}
?>
