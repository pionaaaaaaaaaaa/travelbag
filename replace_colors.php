<?php
$ROOT_DIR = "C:/xampp/htdocs/web_koper";

$STRING_REPLACEMENTS = [
    "var(--bg-surface)" => "var(--bg-surface)",
    "var(--bg-main)" => "var(--bg-main)",
    "var(--secondary)" => "var(--secondary)",
    "var(--bg-surface)" => "var(--bg-surface)",
    "var(--secondary)" => "var(--secondary)",
    "var(--primary)" => "var(--primary)",
    "var(--primary)" => "var(--primary)",
    "var(--primary)" => "var(--primary)",
    "var(--primary-hover)" => "var(--primary-hover)",
    "var(--primary-hover)" => "var(--primary-hover)",
    "var(--primary-hover)" => "var(--primary-hover)",
    "var(--bg-surface)" => "var(--bg-surface)",
    "var(--bg-surface)" => "var(--bg-surface)",
    "var(--primary)" => "var(--primary)",
    "var(--text-main)" => "var(--text-main)",
    "var(--text-main)" => "var(--text-main)",
    "var(--text-muted)" => "var(--text-muted)",

    "var(--bg-surface)" => "var(--bg-surface)",
    "var(--bg-surface)fff" => "var(--bg-surface)",
    "var(--bg-surface)" => "var(--bg-surface)",
    "var(--bg-surface)FFF" => "var(--bg-surface)",
    "var(--text-main)" => "var(--text-main)",
    "var(--text-main)000" => "var(--text-main)",
    "var(--danger-badge)" => "var(--danger-badge)",
    "var(--success-badge)" => "var(--success-badge)",
    "var(--warning-badge)" => "var(--warning-badge)",
    "var(--success-bg)" => "var(--success-bg)",
    "var(--success-text)" => "var(--success-text)",
    "var(--danger-bg)" => "var(--danger-bg)",
    "var(--danger-text)" => "var(--danger-text)",
    "var(--danger-badge)" => "var(--danger-badge)",
    "var(--secondary)" => "var(--secondary)",
    "var(--bg-main)" => "var(--bg-main)",
];

$REGEX_REPLACEMENTS = [
    "/rgba\(\s*0\s*,\s*0\s*,\s*0\s*,\s*0\.5\s*\)/" => "var(--shadow-dark)",
    "/rgba\(\s*0\s*,\s*0\s*,\s*0\s*,\s*0\.4\s*\)/" => "var(--shadow-dark)",
    "/rgba\(\s*0\s*,\s*0\s*,\s*0\s*,\s*\.06\s*\)/" => "var(--shadow-light)",
    "/rgba\(\s*0\s*,\s*0\s*,\s*0\s*,\s*0\.06\s*\)/" => "var(--shadow-light)",
    "/rgba\(\s*0\s*,\s*0\s*,\s*0\s*,\s*\.08\s*\)/" => "var(--shadow-light)",
    "/rgba\(\s*0\s*,\s*0\s*,\s*0\s*,\s*0\.08\s*\)/" => "var(--shadow-light)",

    "/rgba\(\s*255\s*,\s*255\s*,\s*255\s*,\s*0\.1\s*\)/" => "var(--border-light)",
    "/rgba\(\s*255\s*,\s*255\s*,\s*255\s*,\s*0\.15\s*\)/" => "var(--border-light)",
    "/rgba\(\s*255\s*,\s*255\s*,\s*255\s*,\s*0\.3\s*\)/" => "var(--border-light)",
    "/rgba\(\s*255\s*,\s*255\s*,\s*255\s*,\s*\.3\s*\)/" => "var(--border-light)",
    "/rgba\(\s*255\s*,\s*255\s*,\s*255\s*,\s*\.25\s*\)/" => "var(--border-light)",
    "/rgba\(\s*255\s*,\s*255\s*,\s*255\s*,\s*0\.4\s*\)/" => "var(--border-light)",
    "/rgba\(\s*255\s*,\s*255\s*,\s*255\s*,\s*0\.5\s*\)/" => "var(--border-light)",
    "/rgba\(\s*255\s*,\s*255\s*,\s*255\s*,\s*0\.55\s*\)/" => "var(--border-light)",
    "/rgba\(\s*255\s*,\s*255\s*,\s*255\s*,\s*\.55\s*\)/" => "var(--border-light)",
    "/rgba\(\s*255\s*,\s*255\s*,\s*255\s*,\s*0\.6\s*\)/" => "var(--border-light)",
    "/rgba\(\s*255\s*,\s*255\s*,\s*255\s*,\s*0\.65\s*\)/" => "var(--border-light)",
    "/rgba\(\s*255\s*,\s*255\s*,\s*255\s*,\s*0\.07\s*\)/" => "var(--border-light)",
    "/rgba\(\s*255\s*,\s*255\s*,\s*255\s*,\s*0\.08\s*\)/" => "var(--border-light)",

    "/rgba\(\s*85\s*,\s*107\s*,\s*93\s*,\s*\.25\s*\)/" => "var(--shadow-medium)",
    "/rgba\(\s*85\s*,\s*107\s*,\s*93\s*,\s*0\.25\s*\)/" => "var(--shadow-medium)",

    "/rgba\(\s*200\s*,\s*167\s*,\s*116\s*,\s*\.4\s*\)/" => "var(--shadow-medium)",
    "/rgba\(\s*200\s*,\s*167\s*,\s*116\s*,\s*0\.4\s*\)/" => "var(--shadow-medium)",
    "/rgba\(\s*200\s*,\s*167\s*,\s*116\s*,\s*\.5\s*\)/" => "var(--shadow-dark)",
    "/rgba\(\s*200\s*,\s*167\s*,\s*116\s*,\s*\.35\s*\)/" => "var(--shadow-medium)",
    "/rgba\(\s*200\s*,\s*167\s*,\s*116\s*,\s*0\.06\s*\)/" => "var(--shadow-light)",
    "/rgba\(\s*200\s*,\s*167\s*,\s*116\s*,\s*0\.05\s*\)/" => "var(--shadow-light)",

    "/rgba\(\s*92\s*,\s*61\s*,\s*46\s*,\s*\.35\s*\)/" => "var(--shadow-medium)",
    "/rgba\(\s*92\s*,\s*61\s*,\s*46\s*,\s*\.45\s*\)/" => "var(--shadow-dark)",
    "/rgba\(\s*92\s*,\s*61\s*,\s*46\s*,\s*0\.95\s*\)/" => "var(--overlay-bg)",
    "/rgba\(\s*92\s*,\s*61\s*,\s*46\s*,\s*0\.75\s*\)/" => "var(--overlay-bg)",

    "/rgba\(\s*251\s*,\s*251\s*,\s*248\s*,\s*\.82\s*\)/" => "var(--bg-main)",
];

$NEW_ROOT = ':root {
    /* Main Background */
    --bg-main: #F5EFEB; /* Beige */
    
    /* Surface (Card, Modal) */
    --bg-surface: var(--bg-surface)FFF; /* White */
    
    /* Primary (Heading, Navbar, Main Buttons) */
    --primary: #2F4156; /* Navy */
    
    /* Hover & Active State */
    --primary-hover: #567C8D; /* Teal */
    
    /* Borders, Light Highlights, Section Backgrounds */
    --secondary: #C8D9E6; /* Sky Blue */
    
    /* Text Colors */
    --text-main: var(--primary);
    --text-muted: var(--primary-hover);
    --text-light: var(--bg-surface);
    
    /* Alerts & Badges */
    --success-bg: var(--success-bg);
    --success-text: var(--success-text);
    --success-badge: var(--success-badge);
    --danger-bg: var(--danger-bg);
    --danger-text: var(--danger-text);
    --danger-badge: var(--danger-badge);
    --warning-badge: var(--warning-badge);
    
    /* Shadows and Overlays */
    --shadow-light: rgba(47, 65, 86, 0.1);
    --shadow-medium: rgba(47, 65, 86, 0.25);
    --shadow-dark: rgba(47, 65, 86, 0.5);
    --overlay-bg: rgba(47, 65, 86, 0.75);
    --border-light: rgba(200, 217, 230, 0.5);

    /* Misc Configuration (Preserved) */
    --radius-sm: 4px;
    --radius-md: 8px;
    --radius-lg: 14px;
    --radius-xl: 20px;
    --transition: all .3s cubic-bezier(.25, .8, .25, 1);
}';

function process_file($filepath) {
    global $STRING_REPLACEMENTS, $REGEX_REPLACEMENTS, $NEW_ROOT;
    
    $content = file_get_contents($filepath);
    $original_content = $content;

    // If it's the main stylesheet, replace the :root block first
    if (str_ends_with($filepath, 'style.css')) {
        $root_pattern = "/:root\s*\{[^}]+\}/s";
        $content = preg_replace($root_pattern, $NEW_ROOT, $content);
    }

    // Apply exact string replacements
    foreach ($STRING_REPLACEMENTS as $old => $new) {
        $content = str_replace($old, $new, $content);
    }
        
    // Apply regex replacements
    foreach ($REGEX_REPLACEMENTS as $pattern => $new) {
        $content = preg_replace($pattern, $new, $content);
    }

    // Some missed string replacements for specific PHP inline conditions
    $content = str_replace("'var(--success-badge)'", "'var(--success-badge)'", $content);
    $content = str_replace("'var(--bg-surface)'", "'var(--bg-surface)'", $content);
    $content = str_replace("'var(--secondary)'", "'var(--secondary)'", $content);
    // Also 'var(--bg-main)' in onmouseout="this.style.borderColor='var(--bg-main)'"
    $content = str_replace("'var(--bg-main)'", "'var(--bg-main)'", $content);

    if ($content !== $original_content) {
        file_put_contents($filepath, $content);
        echo "Updated $filepath\n";
    }
}

// Process CSS files
$css_dir = $ROOT_DIR . '/assets/css';
foreach (glob($css_dir . '/*.css') as $filename) {
    process_file($filename);
}

// Process PHP files in root
foreach (glob($ROOT_DIR . '/*.php') as $filename) {
    process_file($filename);
}

// Process PHP files in includes/
$includes_dir = $ROOT_DIR . '/includes';
if (file_exists($includes_dir)) {
    foreach (glob($includes_dir . '/*.php') as $filename) {
        process_file($filename);
    }
}
?>
