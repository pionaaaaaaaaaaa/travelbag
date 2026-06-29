<?php
$filepaths = [
    'C:/xampp/htdocs/web_koper/assets/css/style.css',
    'C:/xampp/htdocs/web_koper/detail.php'
];

$replacements = [
    'rgba(255,255,255,0.45)' => 'var(--border-light)',
    'rgba(255, 255, 255, 0.7)' => 'var(--border-light)',
    'rgba(255,255,255,0.2)' => 'var(--border-light)',
    'rgba(255,255,255,0.7)' => 'var(--border-light)',
    'rgba(92,61,46,0.1)' => 'var(--shadow-light)',
    'rgba(92,61,46,0.15)' => 'var(--shadow-light)',
    'rgba(251,251,248,.85)' => 'var(--bg-main)',
    '#ff6533' => 'var(--warning-badge)',
    '#ff4f14' => 'var(--danger-badge)',
    'rgba(255,79,20,0.35)' => 'var(--shadow-medium)',
    'rgba(255,79,20,0.45)' => 'var(--shadow-dark)',
    '#1877f2' => 'var(--primary)',
    '#25d366' => 'var(--success-badge)',
    '#e4405f' => 'var(--danger-badge)',
    '#1da1f2' => 'var(--primary)',
];

foreach ($filepaths as $filepath) {
    $content = file_get_contents($filepath);
    foreach ($replacements as $old => $new) {
        $content = str_replace($old, $new, $content);
    }
    file_put_contents($filepath, $content);
    echo "Updated $filepath\n";
}
