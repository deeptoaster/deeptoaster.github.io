<?
include(__DIR__ . '/../../lib/cleverly/Cleverly.class.php');
include(__DIR__ . '/../../lib/functions.php');

$cleverly = new Cleverly();
$cleverly->preserveIndent = true;
$cleverly->setTemplateDir(__DIR__ . '/templates');

$cleverly->display('index.tpl', [
  'date' => strftime('%F'),
  'education' => [
    [
      'date' => '2022&ndash;23',
      'major' => 'Computer Vision',
      'school' => 'MS, Carnegie Mellon'
    ],
    [
      'date' => '2013&ndash;17',
      'major' => 'Computer Science, Aerospace (minor)',
      'notes' =>
          'Completed Graphics, Robotics, and Machine Learning tracks, as well as the Mechanical Engineering capstone project; 3.9 GPA',
      'school' => 'BS, Caltech'
    ]
  ],
  'employment' => [
    [
      'date' => '2020&ndash;22',
      'employer' => 'Compound Eye',
      'notes' => [
        'Led end-to-end architecture, build, and deployment of various cloud-based computer vision tools, such as a real-time 3D visualizer and annotation tools',
        'Developed novel odometry software for camera-based visuospatial perception'
      ],
      'title' => 'Senior Engineer'
    ],
    [
      'date' => '2016&ndash;20',
      'employer' => 'Facebook',
      'notes' => [
        'Tech lead on rendering platform used by tens of thousands of moderators',
        'Coordinated effort among dozens of customer teams companywide which generated millions of dollars in identifiable cost savings',
        'Regularly mentored interns and other engineers'
      ],
      'title' => 'Senior Software Engineer (E5)'
    ],
    [
      'date' => 2015,
      'employer' => 'TigerText',
      'notes' => [
        'Developed client-facing admin panels, features, and toolchain improvements'
      ],
      'title' => 'Web Development Intern'
    ],
    [
      'date' => '2014&ndash;17',
      'employer' => 'Caltech',
      'notes' => [
        'Built large RAID 60 server and developed web, mail, and other services'
      ],
      'title' => 'IMSS Representative'
    ],
    [
      'date' => '2012&ndash;13',
      'employer' => 'Intel',
      'notes' => [
        'Developed UX tracking and analysis library to determine tools\' cognitive load'
      ],
      'title' => 'Software Development Intern'
    ]
  ],
  'languages' => [
    ['name' => 'English', 'proficiency' => 100],
    ['name' => 'Mandarin', 'proficiency' => 100],
    ['name' => 'French', 'proficiency' => 80],
    ['name' => 'Spanish', 'proficiency' => 60],
    ['name' => 'Russian', 'proficiency' => 40]
  ],
  'root' => $config['root'],
  'show_github' => true,
  'title' => 'R&eacute;sum&eacute; - Deep Toaster'
]);
?>
