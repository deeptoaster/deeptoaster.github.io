<?
include(__DIR__ . '/../../lib/cleverly/Cleverly.class.php');
include(__DIR__ . '/../../lib/functions.php');

$cleverly = new Cleverly();
$cleverly->preserveIndent = true;
$cleverly->setTemplateDir(__DIR__ . '/templates');
$cleverly->addTemplateDir(__DIR__ . '/../common/templates');

$cleverly->display('index.tpl', [
  'date' => strftime('%F'),
  'education' => [
    [
      'date' => '2022&ndash;23',
      'major' => 'Computer Vision',
      'notes' =>
          'SLAM and modelling courses; laser interferometry capstone; 4.1 GPA',
      'school' => 'MS, Carnegie Mellon'
    ],
    [
      'date' => '2013&ndash;17',
      'major' => 'Computer Science, Aerospace (minor)',
      'notes' =>
          'Graphics track; Robotics track; Mech. Eng. capstone; 3.9 GPA',
      'school' => 'BS, Caltech'
    ]
  ],
  'employment' => [
    [
      'date' => 2023,
      'employer' => 'Mach9 Robotics',
      'notes' => [
        'Developed end-to-end solution using a combination of classical and ML-based computer vision to tackle major real-world infrastructure challenges'
      ],
      'title' => 'Computer Vision Intern'
    ],
    [
      'date' => '2020&ndash;22',
      'employer' => 'Compound Eye',
      'notes' => [
        'Led end-to-end architecture, build, and deployment of cloud-based computer vision applications, such as a real-time 3D visualizer and annotation tools',
        'Created novel odometry software for camera-based visuospatial perception'
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
  'path' => '/resume',
  'root' => $config['ROOT'],
  'show_github' => true,
  'title' => 'R&eacute;sum&eacute; - Deep Toaster'
]);
?>
