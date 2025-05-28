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
          'SLAM, ML, and modelling courses; laser interferometry capstone; 4.1 GPA',
      'school' => 'MS, Carnegie Mellon'
    ],
    [
      'date' => 2023,
      'disabled' => true,
      'major' => 'Computer Vision Intern',
      'school' => 'Mach9 Robotics'
    ],
    [
      'date' => '2013&ndash;17',
      'major' => 'Computer Science, Aerospace (minor)',
      'notes' =>
          'Graphics track; Robotics track; Mech. Eng. capstone; 3.9 GPA',
      'school' => 'BS, Caltech'
    ],
    [
      'date' => 2015,
      'disabled' => true,
      'major' => 'Web Development Intern',
      'school' => 'TigerText'
    ]
  ],
  'employment' => [
    [
      'date' => '2024&ndash;25',
      'employer' => 'Matterport',
      'notes' => [
        'Created central library and framework for training and managing models and datasets to accelerate ML development across the company',
        'Designed, trained, and deployed ML models for computer vision pipeline'
      ],
      'title' => 'Staff Machine Learning Engineer'
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
    ['level' => 'native', 'name' => 'English', 'proficiency' => 100],
    ['level' => 'native', 'name' => 'Mandarin', 'proficiency' => 100],
    ['level' => 'B2', 'name' => 'French', 'proficiency' => 70],
    ['level' => 'B2', 'name' => 'Spanish', 'proficiency' => 60],
    ['level' => 'B1', 'name' => 'Russian', 'proficiency' => 40]
  ],
  'path' => '/resume',
  'root' => $config['ROOT'],
  'show_github' => true,
  'title' => 'R&eacute;sum&eacute; - Deep Toaster'
]);
?>
