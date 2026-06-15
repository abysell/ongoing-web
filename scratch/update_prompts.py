import os

FILES_TO_UPDATE = [
    "/Users/user/Documents/ongoing-web/js/main.js",
    "/Users/user/Documents/ongoing-web/docs/index.html",
    "/Users/user/Documents/ongoing-web/modulos/crm-ventas.html",
    "/Users/user/Documents/ongoing-web/modulos/gestion-operativa.html",
    "/Users/user/Documents/ongoing-web/modulos/infraestructura-multitenant.html",
    "/Users/user/Documents/ongoing-web/api/chat.js",
    "/Users/user/Documents/ongoing-web/api/chat/index.php"
]

def main():
    for filepath in FILES_TO_UPDATE:
        if not os.path.exists(filepath):
            print(f"File not found: {filepath}")
            continue
            
        with open(filepath, 'r', encoding='utf-8') as f:
            content = f.read()
            
        original = content
        
        # Replace for js / html files
        content = content.replace(
            "iniciar la prueba gratis en https://ongoing2.mx",
            "iniciar la cuenta gratis de por vida en https://ongoing2.mx"
        )
        
        # Replace for api files
        content = content.replace(
            "iniciar la prueba gratuita en https://ongoing2.mx",
            "iniciar el registro gratuito en https://ongoing2.mx"
        )
        
        if content != original:
            with open(filepath, 'w', encoding='utf-8') as f:
                f.write(content)
            print(f"Updated prompts in: {os.path.basename(filepath)}")
        else:
            print(f"No prompt changes needed in: {os.path.basename(filepath)}")

if __name__ == "__main__":
    main()
