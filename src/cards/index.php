<?
include(__DIR__ . '/../../lib/cleverly/Cleverly.class.php');
include(__DIR__ . '/../../lib/functions.php');

$cleverly = new Cleverly();
$cleverly->preserveIndent = true;
$cleverly->setTemplateDir(__DIR__ . '/templates');
ob_start();

include(__DIR__ . '/../fishbot.php');

$fishbot = ob_get_clean();

$cleverly->display('index.tpl', [
  'date' => strftime('%F'),
  'fishbot' => $fishbot,
  'root' => $config['root'],
  'title' => 'Cards - Deep Toaster'
]);
?>
