import os

ROOT = "/Users/user/Documents/ongoing-web"

def main():
    # 1. Revert index.html
    index_path = os.path.join(ROOT, "index.html")
    if os.path.exists(index_path):
        with open(index_path, 'r', encoding='utf-8') as f:
            content = f.read()
        content = content.replace(
            '<span class="text-[11px] text-gray-400 text-center font-medium">1 usuario gratis para siempre (sin tarjetas ni plazos forzosos).</span>',
            '<span class="text-[11px] text-gray-400 text-center font-medium">Gratis para 1 usuario de por vida. Sin tarjeta de crédito.</span>'
        )
        with open(index_path, 'w', encoding='utf-8') as f:
            f.write(content)
        print("Reverted index.html pricing copy")

    # 2. Revert modules
    modules = [
        os.path.join(ROOT, "modulos/crm-ventas.html"),
        os.path.join(ROOT, "modulos/gestion-operativa.html")
    ]
    for filepath in modules:
        if os.path.exists(filepath):
            with open(filepath, 'r', encoding='utf-8') as f:
                content = f.read()
            content = content.replace(
                "1 usuario gratis para siempre &bull; Sin tarjetas ni plazos forzosos",
                "Gratis para 1 usuario de por vida &bull; Sin tarjeta de crédito"
            )
            with open(filepath, 'w', encoding='utf-8') as f:
                f.write(content)
            print(f"Reverted modules copy in: {os.path.basename(filepath)}")

if __name__ == "__main__":
    main()
