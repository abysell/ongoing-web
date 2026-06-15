import os
import re

# Define the root path of the project
ROOT_DIR = "/Users/user/Documents/ongoing-web"

# Extensions to process
PROCESS_EXTENSIONS = ('.html', '.md', '.txt', '.js', '.php')

# Exclude directories
EXCLUDE_DIRS = {'.git', 'scratch', 'node_modules'}

# Replacements list: (pattern, replacement, flags)
REPLACEMENTS = [
    # Global Sticky Banner and mentions of "inicia tu prueba de 14 días gratis"
    (
        r"inicia(r)? tu prueba de 14 días gratis",
        r"inicia\1 tu cuenta gratis de por vida (1 usuario)",
        re.IGNORECASE
    ),
    # "prueba gratuita de 14 días" in chatbots/APIs
    (
        r"prueba gratuita de 14 días",
        r"cuenta gratis de por vida para un usuario",
        re.IGNORECASE
    ),
    # "prueba de 14 días gratis"
    (
        r"prueba de 14 días gratis",
        r"cuenta gratis de por vida para 1 usuario",
        re.IGNORECASE
    ),
    # "prueba de 14 días"
    (
        r"prueba de 14 días",
        r"cuenta gratis de por vida para 1 usuario",
        re.IGNORECASE
    ),
    # "14 días de prueba. 1 usuario admin. Sin tarjeta de crédito."
    (
        r"14 días de prueba\.\s*1 usuario admin\.\s*Sin tarjeta de crédito\.",
        r"Gratis para 1 usuario de por vida. Sin tarjeta de crédito.",
        re.IGNORECASE
    ),
    # "14 días de prueba sin compromiso &bull; No requiere tarjeta de crédito"
    (
        r"14 días de prueba sin compromiso \s*&bull;\s* No requiere tarjeta de crédito",
        r"Gratis para 1 usuario de por vida &bull; Sin tarjeta de crédito",
        re.IGNORECASE
    ),
    # "Iniciar Prueba de 14 Días"
    (
        r"Iniciar Prueba de 14 Días",
        r"Iniciar Gratis (1 Usuario de por vida)",
        0
    ),
    (
        r"Iniciar Prueba de 14 días",
        r"Iniciar Gratis (1 Usuario de por vida)",
        0
    ),
    # "Configuramos un espacio de prueba real de 14 días..."
    (
        r"Configuramos un espacio de prueba real de 14 días para ti sin ningún costo de implementación\.",
        r"Configuramos tu cuenta gratis de por vida para un usuario sin ningún costo de implementación.",
        re.IGNORECASE
    ),
    # "Crear cuenta gratis (14 días)"
    (
        r"Crear cuenta gratis \(14 días\)",
        r"Crear cuenta gratis de por vida",
        re.IGNORECASE
    ),
    # "Crear mi cuenta (14 días gratis)"
    (
        r"Crear mi cuenta \(14 días gratis\)",
        r"Crear cuenta gratis de por vida",
        re.IGNORECASE
    ),
    # "Comenzar mi prueba de 14 días"
    (
        r"Comenzar mi prueba de 14 días",
        r"Comenzar gratis de por vida",
        re.IGNORECASE
    ),
    # "Iniciar mis 14 días gratis"
    (
        r"Iniciar mis 14 días gratis",
        r"Iniciar gratis de por vida (1 usuario)",
        re.IGNORECASE
    ),
    # "Inicia tu prueba de CRM gratis por 14 días."
    (
        r"Inicia tu prueba de CRM gratis por 14 días\.",
        r"Inicia tu cuenta de CRM gratis de por vida para 1 usuario.",
        re.IGNORECASE
    ),
    # "Empieza Gratis Ahora &bull; 14 Días"
    (
        r"Empieza Gratis Ahora \s*&bull;\s* 14 Días",
        r"Empieza Gratis Ahora &bull; 1 Usuario",
        re.IGNORECASE
    ),
    # "prueba gratuita por 14 días"
    (
        r"prueba gratuita por 14 días",
        r"cuenta gratuita de por vida para un usuario",
        re.IGNORECASE
    ),
]

def process_file(filepath):
    try:
        with open(filepath, 'r', encoding='utf-8') as f:
            content = f.read()
    except UnicodeDecodeError:
        # Skip binary files if any matches occurred
        return

    original_content = content
    modified = False

    for pattern, replacement, flags in REPLACEMENTS:
        new_content = re.sub(pattern, replacement, content, flags=flags)
        if new_content != content:
            content = new_content
            modified = True

    if modified:
        with open(filepath, 'w', encoding='utf-8') as f:
            f.write(content)
        print(f"Modified: {os.path.relpath(filepath, ROOT_DIR)}")

def main():
    print("Starting pricing communication updates...")
    for root, dirs, files in os.walk(ROOT_DIR):
        # Filter directories in-place
        dirs[:] = [d for d in dirs if d not in EXCLUDE_DIRS]

        for file in files:
            if file.endswith(PROCESS_EXTENSIONS):
                filepath = os.path.join(root, file)
                process_file(filepath)
    print("Done!")

if __name__ == "__main__":
    main()
