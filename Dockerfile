# Use a imagem base com o ambiente virtual existente
FROM python:3.6-alpine as builder

# Copie os arquivos do ambiente virtual para o diretório temporário

COPY requirements.txt .

# Instale as dependências do projeto no ambiente virtual
RUN mkdir -p /temp && mv requirements.txt /temp

# Defina o diretório de trabalho como /temp
WORKDIR /temp

# Crie e ative o ambiente virtual
RUN python3 -m venv /venv
ENV PATH="/venv/bin:$PATH"

# Atualize o pip
RUN pip install --upgrade pip

# Instale as dependências no ambiente virtual
RUN pip install --no-cache-dir -r requirements.txt

# Etapa final da imagem
FROM python:3.6-alpine

# Defina o diretório de trabalho como /usr/src/app
WORKDIR /usr/src/app

# Copie o ambiente virtual do contêiner temporário para o diretório de trabalho do contêiner final
COPY --from=builder /venv /venv

# Copie o conteúdo do diretório de build para dentro do contêiner
COPY . .

# Exponha a porta necessária, se necessário
EXPOSE 8080

# Defina o comando de inicialização do contêiner para executar o módulo swagger_server
ENTRYPOINT ["/venv/bin/python"]

cmd ["-m", "swagger_server"]
