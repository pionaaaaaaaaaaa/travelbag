import os
import re

ROOT_DIR = r"C:\xampp\htdocs\web_koper"

# Map of exact string replacements
STRING_REPLACEMENTS = {
    # Old variables -> New variables
    "var(--white)": "var(--bg-surface)",
    "var(--off-white)": "var(--bg-main)",
    "var(--cream)": "var(--secondary)",
    "var(--cream-light)": "var(--bg-surface)",
    "var(--soft-bg)": "var(--secondary)",
    "var(--navy-900)": "var(--primary)",
    "var(--navy-800)": "var(--primary)",
    "var(--navy-700)": "var(--primary)",
    "var(--navy-600)": "var(--primary-hover)",
    "var(--navy-500)": "var(--primary-hover)",
    "var(--royal-blue)": "var(--primary-hover)",
    "var(--gold)": "var(--bg-surface)",
    "var(--gold-light)": "var(--bg-surface)",
    "var(--gold-dark)": "var(--primary)",
    "var(--text-dark)": "var(--text-main)",
    "var(--text-mid)": "var(--text-main)",
    "var(--text-muted)": "var(--text-muted)",

    # Hex colors -> Variables
    "#fff": "var(--bg-surface)",
    "#ffffff": "var(--bg-surface)",
    "#FFF": "var(--bg-surface)",
    "#FFFFFF": "var(--bg-surface)",
    "#000": "var(--text-main)",
    "#000000": "var(--text-main)",
    "#ef4444": "var(--danger-badge)",
    "#10b981": "var(--success-badge)",
    "#f97316": "var(--warning-badge)",
    "#d1fae5": "var(--success-bg)",
    "#065f46": "var(--success-text)",
    "#fee2e2": "var(--danger-bg)",
    "#991b1b": "var(--danger-text)",
    "#dc2626": "var(--danger-badge)",
    "#dee2e6": "var(--secondary)",
    "#f8f9fa": "var(--bg-main)",
}

# Regex replacements (to handle variable whitespace in rgba)
REGEX_REPLACEMENTS = [
    (r"rgba\(\s*0\s*,\s*0\s*,\s*0\s*,\s*0\.5\s*\)", "var(--shadow-dark)"),
    (r"rgba\(\s*0\s*,\s*0\s*,\s*0\s*,\s*0\.4\s*\)", "var(--shadow-dark)"),
    (r"rgba\(\s*0\s*,\s*0\s*,\s*0\s*,\s*\.06\s*\)", "var(--shadow-light)"),
    (r"rgba\(\s*0\s*,\s*0\s*,\s*0\s*,\s*0\.06\s*\)", "var(--shadow-light)"),
    (r"rgba\(\s*0\s*,\s*0\s*,\s*0\s*,\s*\.08\s*\)", "var(--shadow-light)"),
    (r"rgba\(\s*0\s*,\s*0\s*,\s*0\s*,\s*0\.08\s*\)", "var(--shadow-light)"),

    (r"rgba\(\s*255\s*,\s*255\s*,\s*255\s*,\s*0\.1\s*\)", "var(--border-light)"),
    (r"rgba\(\s*255\s*,\s*255\s*,\s*255\s*,\s*0\.15\s*\)", "var(--border-light)"),
    (r"rgba\(\s*255\s*,\s*255\s*,\s*255\s*,\s*0\.3\s*\)", "var(--border-light)"),
    (r"rgba\(\s*255\s*,\s*255\s*,\s*255\s*,\s*\.3\s*\)", "var(--border-light)"),
    (r"rgba\(\s*255\s*,\s*255\s*,\s*255\s*,\s*\.25\s*\)", "var(--border-light)"),
    (r"rgba\(\s*255\s*,\s*255\s*,\s*255\s*,\s*0\.4\s*\)", "var(--border-light)"),
    (r"rgba\(\s*255\s*,\s*255\s*,\s*255\s*,\s*0\.5\s*\)", "var(--border-light)"),
    (r"rgba\(\s*255\s*,\s*255\s*,\s*255\s*,\s*0\.55\s*\)", "var(--border-light)"),
    (r"rgba\(\s*255\s*,\s*255\s*,\s*255\s*,\s*\.55\s*\)", "var(--border-light)"),
    (r"rgba\(\s*255\s*,\s*255\s*,\s*255\s*,\s*0\.6\s*\)", "var(--border-light)"),
    (r"rgba\(\s*255\s*,\s*255\s*,\s*255\s*,\s*0\.65\s*\)", "var(--border-light)"),
    (r"rgba\(\s*255\s*,\s*255\s*,\s*255\s*,\s*0\.07\s*\)", "var(--border-light)"),
    (r"rgba\(\s*255\s*,\s*255\s*,\s*255\s*,\s*0\.08\s*\)", "var(--border-light)"),

    (r"rgba\(\s*85\s*,\s*107\s*,\s*93\s*,\s*\.25\s*\)", "var(--shadow-medium)"),
    (r"rgba\(\s*85\s*,\s*107\s*,\s*93\s*,\s*0\.25\s*\)", "var(--shadow-medium)"),

    (r"rgba\(\s*200\s*,\s*167\s*,\s*116\s*,\s*\.4\s*\)", "var(--shadow-medium)"),
    (r"rgba\(\s*200\s*,\s*167\s*,\s*116\s*,\s*0\.4\s*\)", "var(--shadow-medium)"),
    (r"rgba\(\s*200\s*,\s*167\s*,\s*116\s*,\s*\.5\s*\)", "var(--shadow-dark)"),
    (r"rgba\(\s*200\s*,\s*167\s*,\s*116\s*,\s*\.35\s*\)", "var(--shadow-medium)"),
    (r"rgba\(\s*200\s*,\s*167\s*,\s*116\s*,\s*0\.06\s*\)", "var(--shadow-light)"),
    (r"rgba\(\s*200\s*,\s*167\s*,\s*116\s*,\s*0\.05\s*\)", "var(--shadow-light)"),

    (r"rgba\(\s*92\s*,\s*61\s*,\s*46\s*,\s*\.35\s*\)", "var(--shadow-medium)"),
    (r"rgba\(\s*92\s*,\s*61\s*,\s*46\s*,\s*\.45\s*\)", "var(--shadow-dark)"),
    (r"rgba\(\s*92\s*,\s*61\s*,\s*46\s*,\s*0\.95\s*\)", "var(--overlay-bg)"),
    (r"rgba\(\s*92\s*,\s*61\s*,\s*46\s*,\s*0\.75\s*\)", "var(--overlay-bg)"),

    (r"rgba\(\s*251\s*,\s*251\s*,\s*248\s*,\s*\.82\s*\)", "var(--bg-main)"),
]

NEW_ROOT = ''':root {
    /* Main Background */
    --bg-main: #F5EFEB; /* Beige */
    
    /* Surface (Card, Modal) */
    --bg-surface: #FFFFFF; /* White */
    
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
    --success-bg: #d1fae5;
    --success-text: #065f46;
    --success-badge: #10b981;
    --danger-bg: #fee2e2;
    --danger-text: #991b1b;
    --danger-badge: #ef4444;
    --warning-badge: #f97316;
    
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
}'''

def process_file(filepath):
    with open(filepath, 'r', encoding='utf-8') as f:
        content = f.read()
    
    original_content = content

    # If it's the main stylesheet, replace the :root block first
    if filepath.endswith('style.css'):
        # Match from :root { until the closing brace }
        # Assume standard formatting
        root_pattern = r":root\s*\{[^}]+\}"
        content = re.sub(root_pattern, NEW_ROOT, content)

    # Apply exact string replacements
    for old, new in STRING_REPLACEMENTS.items():
        content = content.replace(old, new)
        
    # Apply regex replacements
    for pattern, new in REGEX_REPLACEMENTS:
        content = re.sub(pattern, new, content)

    # Some missed string replacements for specific PHP inline conditions
    content = content.replace("'#10b981'", "'var(--success-badge)'")
    content = content.replace("'white'", "'var(--bg-surface)'")
    content = content.replace("'#dee2e6'", "'var(--secondary)'")

    if content != original_content:
        with open(filepath, 'w', encoding='utf-8') as f:
            f.write(content)
        print(f"Updated {filepath}")

def main():
    # Process CSS files
    css_dir = os.path.join(ROOT_DIR, 'assets', 'css')
    for filename in os.listdir(css_dir):
        if filename.endswith('.css'):
            process_file(os.path.join(css_dir, filename))

    # Process PHP files in root
    for filename in os.listdir(ROOT_DIR):
        if filename.endswith('.php'):
            process_file(os.path.join(ROOT_DIR, filename))

    # Process PHP files in includes/
    includes_dir = os.path.join(ROOT_DIR, 'includes')
    if os.path.exists(includes_dir):
        for filename in os.listdir(includes_dir):
            if filename.endswith('.php'):
                process_file(os.path.join(includes_dir, filename))

if __name__ == '__main__':
    main()
