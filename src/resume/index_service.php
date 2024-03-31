<?
include(__DIR__ . '/../../lib/cleverly/Cleverly.class.php');
include(__DIR__ . '/../../lib/functions.php');

$cleverly = new Cleverly();
$cleverly->preserveIndent = true;
$cleverly->setTemplateDir(__DIR__ . '/templates');
$cleverly->addTemplateDir(__DIR__ . '/../common/templates');

$cleverly->display('index_service.tpl', [
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
      'date' => 2023,
      'employer' => 'The Urban Tap',
      'notes' => [
        'As host, managed hundreds of covers at four-room gastropub using Resy',
        'As expo, ensured order quality through many a late-night happy-hour rush'
      ],
      'title' => 'Server, Expo, Host'
    ],
    [
      'date' => '2022&ndash;24',
      'disabled' => true,
      'employer' => 'AnchorZero',
      'notes' => [
        'Responsible for hiring, mentoring, and maintaining quality of front-end team'
      ],
      'title' => 'Consultant / Lead Engineer'
    ],
    [
      'date' => 2021,
      'employer' => 'Boho',
      'notes' => [
        'Host at upscale restaurant with indoor and outdoor seating using OpenTable'
      ],
      'title' => 'Host'
    ],
    [
      'date' => '2020&ndash;22',
      'disabled' => true,
      'employer' => 'Compound Eye',
      'notes' => [
        'Led end-to-end architecture, build, and deployment of various cloud-based computer vision tools, such as a real-time 3D visualizer and annotation tools',
      ],
      'title' => 'Senior Engineer'
    ],
    [
      'date' => 2020,
      'employer' => 'Starbucks',
      'notes' => [
        'Trained and worked on-site during the early COVID-19 pandemic'
      ],
      'title' => 'Barista'
    ],
    [
      'date' => '2018&ndash;19',
      'employer' => 'Another Planet Entertainment',
      'notes' => ['Part-time usher for a variety of shows and events'],
      'title' => 'Usher'
    ],
    [
      'date' => '2016&ndash;20',
      'disabled' => true,
      'employer' => 'Facebook',
      'notes' => [
        'Coordinated effort among dozens of customer teams companywide which generated millions of dollars in identifiable cost savings',
      ],
      'title' => 'Senior Software Engineer (E5)'
    ],
    [
      'date' => '2014&ndash;17',
      'employer' => 'Caltech',
      'notes' => [
        'Certified by California to serve and wait tables in student dining services',
        'Point of contact for Caltech administration on undergrad housing allocation',
        'Maintained student records and ran meetings for all student-life issues'
      ],
      'title' => 'Waiter, House Secretary, IMSS Representative'
    ],
    [
      'date' => '2012&ndash;13',
      'disabled' => true,
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
  'path' => '/resume-service/',
  'root' => $config['ROOT'],
  'show_github' => false,
  'title' => 'R&eacute;sum&eacute; - Deep Toaster'
]);
?>
