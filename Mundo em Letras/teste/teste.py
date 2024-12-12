import requests
import sqlite3

# Configurações
api_key = "SUA_API_KEY"  # Insira sua API Key aqui
query = "harry potter"  # Termo de busca
max_results = 5  # Número de resultados a buscar

# URL da API do Google Books
url = f"https://www.googleapis.com/books/v1/volumes?q={query}&maxResults={max_results}&key={api_key}"

# Fazer a requisição à API
response = requests.get(url)
if response.status_code != 200:
    print(f"Erro na API: {response.status_code}")
    exit()

# Converter resposta JSON
data = response.json()

# Conectar ao banco de dados SQLite
conn = sqlite3.connect("books.db")
cursor = conn.cursor()

# Criar a tabela (caso não exista)
cursor.execute("""
CREATE TABLE IF NOT EXISTS books (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    title TEXT,
    authors TEXT,
    description TEXT
)
""")

# Inserir os dados no banco
if "items" in data:
    for book in data["items"]:
        title = book["volumeInfo"].get("title", "Título não disponível")
        authors = ", ".join(book["volumeInfo"].get("authors", ["Autor não disponível"]))
        description = book["volumeInfo"].get("description", "Descrição não disponível")

        # Inserir no banco
        cursor.execute("""
        INSERT INTO books (title, authors, description)
        VALUES (?, ?, ?)
        """, (title, authors, description))
        print(f"Livro inserido: {title}")

# Salvar alterações e fechar conexão
conn.commit()
conn.close()

print("Dados inseridos no banco com sucesso!")
