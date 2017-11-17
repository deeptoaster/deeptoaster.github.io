<?
include(__DIR__ . '/../lib/cleverly/Cleverly.class.php');

$cleverly = new Cleverly();
$cleverly->preserve_indent = true;
$cleverly->setTemplateDir(__DIR__ . '/templates');

$cleverly->display('index.tpl', array(
  'about' => function() {
    global $cleverly;

    $cleverly->display('about.tpl');
  },
  'interests' => function() {
    global $cleverly;

    $cleverly->display('interests.tpl');
  },
  'gallery' => function() {
    global $cleverly;

    $cleverly->display('gallery.tpl');
  }
));
?>
