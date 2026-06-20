# ⚽ Reservas de Canchas — Laravel + Cosmos DB en Azure

App web de reservas de canchas de fútbol. Frontend (Blade) y backend (Laravel) juntos
en **Azure App Service**, base de datos en **Azure Cosmos DB (API MongoDB)**. Sin máquinas virtuales.

## ¿Qué hace?
- Lista canchas disponibles
- Registra canchas nuevas (precio, tipo, descripción)
- Permite reservar una cancha con fecha y hora
- Valida que no se crucen dos reservas en el mismo horario
- Permite cancelar reservas

---

## PASO 1 — Subir este código a GitHub

1. Crea un repositorio nuevo en github.com (ej: `reservas-canchas`)
2. En tu PC, dentro de esta carpeta:
   ```bash
   git init
   git add .
   git commit -m "App de reservas inicial"
   git branch -M main
   git remote add origin https://github.com/TU_USUARIO/reservas-canchas.git
   git push -u origin main
   ```

---

## PASO 2 — Conectar GitHub con Azure App Service

En el portal de Azure, dentro de tu App Service `reservas-canchas`:

1. Ve a **Centro de implementación (Deployment Center)**
2. Origen: **GitHub** → autoriza tu cuenta
3. Elige tu repo y la rama `main`
4. Azure crea el perfil de publicación automáticamente

> **Alternativa (la que usa este proyecto):** el workflow ya está en
> `.github/workflows/deploy.yml`. Solo necesitas agregar el secreto
> `AZURE_WEBAPP_PUBLISH_PROFILE` en GitHub:
> - En Azure App Service → **Información general → Descargar perfil de publicación**
> - En GitHub → repo → **Settings → Secrets and variables → Actions → New secret**
> - Nombre: `AZURE_WEBAPP_PUBLISH_PROFILE`, valor: el contenido del archivo descargado

---

## PASO 3 — Variables de entorno en Azure

App Service → **Configuración → Variables de entorno** → agrega:

| Nombre | Valor |
|--------|-------|
| `MONGODB_URI` | Tu PRIMARY CONNECTION STRING de Cosmos DB |
| `MONGODB_DATABASE` | `reservas` |
| `APP_KEY` | Ejecuta `php artisan key:generate --show` y pega el resultado |
| `APP_ENV` | `production` |
| `APP_DEBUG` | `false` |
| `DB_CONNECTION` | `mongodb` |
| `SESSION_DRIVER` | `file` |
| `CACHE_STORE` | `file` |

> La connection string de Cosmos la copias de: Cosmos DB → **Cadenas de conexión → PRIMARY CONNECTION STRING**

---

## PASO 4 — Comando de inicio (Laravel sirve desde /public)

App Service → **Configuración → Configuración general → Comando de inicio**, pega:

```bash
cp /home/site/wwwroot/default /etc/nginx/sites-available/default && service nginx reload
```

Guarda y reinicia la app.

---

## PASO 5 — Cargar datos de ejemplo (opcional)

Para tener 3 canchas de prueba, en App Service → **SSH** (consola web), ejecuta:

```bash
cd /home/site/wwwroot
php artisan db:seed --class=CanchaSeeder --force
```

O simplemente entra a la web y usa el botón **"+ Cancha"** para crear las tuyas.

---

## PASO 6 — Probar

- Abre `https://reservas-canchas.azurewebsites.net`
- Verifica la conexión a la BD en `https://reservas-canchas.azurewebsites.net/health`
  (debe responder `{"estado":"ok","bd":"conectada"}`)

---

## Estructura del proyecto

```
app/Models/          Cancha.php, Reserva.php   (modelos MongoDB)
app/Http/Controllers/ CanchaController, ReservaController
resources/views/     layout + vistas Blade (frontend)
routes/web.php       rutas
config/database.php  conexión a Cosmos
default              config nginx para Azure
.github/workflows/   despliegue automático
```

## Nota sobre Cosmos DB
Los modelos extienden `MongoDB\Laravel\Eloquent\Model`. El campo identificador
en MongoDB es `_id` (por eso las vistas usan `$cancha->_id`). No necesitas migraciones:
las colecciones `canchas` y `reservas` se crean solas al insertar el primer documento.
