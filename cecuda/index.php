<?
$config = array();

include(__DIR__ . '/../config.php');

define('CECUDA_TASK_REGEXP', '/#(\d+)/');

switch ($_SERVER['HTTP_X_GITHUB_EVENT']) {
  case 'ping':
    die('pong');
  case 'pull_request':
    $request = json_decode($_POST['payload'], true);

    switch ($request['action']) {
      case 'edited':
      case 'opened':
        if (preg_match_all(
          CECUDA_TASK_REGEXP,
          $request['pull_request']['body'],
          $matches
        )) {
          $handle = curl_init();
          curl_setopt($handle, CURLOPT_POST, true);

          curl_setopt($handle, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Authorization: Bearer ' . $config['asana_token']
          ));

          curl_setopt($handle, CURLOPT_POSTFIELDS, json_encode(array(
            'data' => array(
              'text' => sprintf(
                '@%s added %s (%s)',
                $request['pull_request']['user']['login'],
                $request['pull_request']['html_url'],
                $request['pull_request']['title']
              )
            )
          )));

          if (
            $request['action'] == 'edited' &&
                isset($request['changed']['body'])
          ) {
            preg_match_all(
              CECUDA_TASK_REGEXP,
              $request['changed']['body'],
              $submatches
            );

            $matches[1] = array_diff($matches[1], $submatches[1]);
          }

          foreach ($matches[1] as $match) {
            curl_setopt(
              $handle,
              CURLOPT_URL,
              "https://app.asana.com/api/1.0/tasks/$match/stories"
            );

            curl_exec($handle);
          }
        }

        break;
    }
}
?>
