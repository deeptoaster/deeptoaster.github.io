<?
$config = array(
  'google_host' => 'docs.google.com',
  'google_path' =>
      '/spreadsheets/d/e/2PACX-1vRNxE3dj-KVDKAuqzZLvXAV4Stx06UqxcpbVOP0ajqxUawYGUV97rL-Y-EBJjQGCcuuKrWaLDVgRdBj/pub?gid=1831278462&single=true&output=csv',
  'ifttt_event' => 'notify',
  'ifttt_host' => 'maker.ifttt.com'
);

include(__DIR__ . '/../config.php');

if (isset($_GET['of'])) {
  $google = fopen("https://$config[google_host]$config[google_path]", 'r');
  $of = $_GET['of'];

  if (substr($of, -3) == ' is') {
    $of = substr($of, 0, -3);
  }

  if (substr($of, -4) == ' are') {
    $of = substr($of, 0, -4);
  }

  while ($google && !feof($google)) {
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

      while ($ifttt && !feof($ifttt)) {
        fgets($ifttt);
      }

      fclose($ifttt);
    }
  }

  fclose($google);
}
?>
