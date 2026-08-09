# HTTPS en Docker para Zapateria POS

Para habilitar TLS real con Nginx, crea los certificados en la carpeta docker/ssl:

```bash
mkdir -p docker/ssl
openssl req -x509 -nodes -newkey rsa:2048 \
  -keyout docker/ssl/key.pem \
  -out docker/ssl/cert.pem \
  -days 365 \
  -subj "/CN=localhost"
```

Luego levanta los contenedores:

```bash
docker compose up -d --build
```

Si prefieres Let's Encrypt, puedes sustituir los certificados autofirmados por los emitidos por Certbot.
