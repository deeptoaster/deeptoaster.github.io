<?
include(__DIR__ . '/../../lib/cleverly/Cleverly.class.php');

$cleverly = new Cleverly();
$cleverly->preserveIndent = true;
$cleverly->setTemplateDir(__DIR__ . '/templates');
ob_start();

include(__DIR__ . '/../fishbot.php');

$fishbot = ob_get_clean();
$cleverly->display('index.tpl', ['fishbot' => $fishbot]);
?>
