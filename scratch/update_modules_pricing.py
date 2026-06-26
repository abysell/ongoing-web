import os

FILES = [
    "/Users/user/Documents/ongoing-web/modulos/crm-ventas.html",
    "/Users/user/Documents/ongoing-web/modulos/gestion-operativa.html"
]

def main():
    for filepath in FILES:
        if not os.path.exists(filepath):
            print(f"File not found: {filepath}")
            continue
            
        with open(filepath, 'r', encoding='utf-8') as f:
            content = f.read()
            
        original = content
        # Replace the paragraph in the modules
        content = content.replace(
            "Gratis para 1 usuario de por vida &bull; Sin tarjeta de crédito",
            "1 usuario gratis para siempre &bull; Sin tarjetas ni plazos forzosos"
        )
        
        if content != original:
            with open(filepath, 'w', encoding='utf-8') as f:
                f.write(content)
            print(f"Updated modules copy in: {os.path.basename(filepath)}")
        else:
            print(f"No changes in: {os.path.basename(filepath)}")

if __name__ == "__main__":
    main()
