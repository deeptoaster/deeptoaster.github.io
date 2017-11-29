<?
if (PHP_SAPI != 'CLI') {
  header('Location: /', true, 301);
}

include(__DIR__ . '/../lib/cleverly/Cleverly.class.php');

$cleverly = new Cleverly();
$cleverly->preserveIndent = true;
$cleverly->setTemplateDir(__DIR__ . '/templates');
$cleverly->display('index.tpl');
?>
