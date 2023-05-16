FROM python:3.6-alpine

COPY requirements.txt .
RUN mkdir -p /usr/src/app && mv requirements.txt /usr/src/app && cd /usr/src/app && pip3 install --no-cache-dir -r requirements.txt && rm requirements.txt && useradd test
USER test
WORKDIR /usr/src/app

EXPOSE 8080

ENTRYPOINT ["python3"]

CMD ["-m", "swagger_server"]

COPY . /usr/src/app