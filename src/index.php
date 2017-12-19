<?
if (PHP_SAPI != 'CLI') {
  header('Location: /', true, 301);
}

include(__DIR__ . '/../lib/cleverly/Cleverly.class.php');

$interests = array(
  'building things',
  'calligraphy',
  'climbing',
  'fencing',
  'fire spinning',
  'making music',
  'self-defense',
  'urban exploration',
  'writing'
);

$cleverly = new Cleverly();
$cleverly->preserveIndent = true;
$cleverly->setTemplateDir(__DIR__ . '/templates');
$cleverly->display('index.tpl', array(
  'interests' => $interests
));
?>
