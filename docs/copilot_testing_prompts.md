# 🤖 Prompts para Testing con GitHub Copilot en VS Code

## 📋 PROMPT GENERAL (Análisis Completo)

```
Actúa como un experto en Laravel y testing. Analiza mi aplicación académica completa y:

1. **Revisa la estructura del proyecto**:
   - Verifica que las relaciones de modelos estén correctamente definidas
   - Identifica problemas en controladores, rutas y middlewares
   - Revisa migraciones y seeders

2. **Encuentra errores comunes**:
   - N+1 queries
   - Validaciones faltantes
   - Problemas de seguridad (SQL injection, XSS, CSRF)
   - Rutas sin protección de autenticación
   - Operaciones sin transacciones donde deberían tenerlas

3. **Genera tests completos** para:
   - Unit tests de modelos (relaciones, scopes, métodos)
   - Feature tests de controladores (CRUD completo)
   - Tests de validación
   - Tests de autenticación y autorización

4. **Sugiere mejoras**:
   - Optimizaciones de queries
   - Refactorización de código duplicado
   - Mejores prácticas de Laravel
   - Implementación de Repository Pattern si aplica

Comienza analizando el directorio actual y genera un reporte detallado con todos los problemas encontrados y sus soluciones.
```

---

## 🎯 PROMPTS ESPECÍFICOS

### 1. Testing de Modelos

```
Genera tests completos para el modelo [NombreModelo]. Incluye:
- Tests de relaciones (belongsTo, hasMany, etc.)
- Tests de scopes
- Tests de métodos custom
- Tests de validaciones a nivel de modelo
- Tests de mutators y accessors
- Verifica que las relaciones inversa estén correctamente definidas

Usa PHPUnit y las mejores prácticas de Laravel Testing.
```

### 2. Testing de Controladores

```
Crea feature tests completos para el controlador [NombreControlador]. Debe incluir:
- Test de index (listado con y sin datos)
- Test de create (formulario de creación)
- Test de store (crear registro válido e inválido)
- Test de show (ver registro existente y no existente)
- Test de edit (formulario de edición)
- Test de update (actualizar válido e inválido)
- Test de destroy (eliminar existente y no existente)
- Tests de autenticación (usuarios no autenticados)
- Tests de autorización (permisos de usuario)

Incluye assertions para respuestas HTTP, redirecciones, mensajes flash y estado de la base de datos.
```

### 3. Testing de Validaciones

```
Revisa todas las validaciones en el controlador [NombreControlador] y:
1. Lista todas las reglas de validación que deberían existir
2. Identifica validaciones faltantes o incorrectas
3. Genera tests para cada regla de validación (válida e inválida)
4. Sugiere FormRequest si no se está usando
5. Crea el FormRequest con todas las validaciones y mensajes personalizados
```

### 4. Análisis de Seguridad

```
Realiza un análisis de seguridad completo de la aplicación:
1. Busca vulnerabilidades SQL injection
2. Verifica protección CSRF en todos los formularios
3. Identifica inputs sin sanitizar (XSS)
4. Revisa rutas sin middleware de autenticación
5. Verifica que las políticas de autorización estén implementadas
6. Busca datos sensibles en código o archivos de configuración
7. Revisa el uso correcto de mass assignment protection

Genera un reporte con todos los problemas encontrados y cómo solucionarlos.
```

### 5. Optimización de Queries

```
Analiza todos los controladores y encuentra:
1. Problemas de N+1 queries
2. Queries que pueden ser optimizados con eager loading
3. Queries sin paginación que deberían tenerla
4. Uso innecesario de all() en lugar de get()
5. Falta de índices en la base de datos

Para cada problema encontrado:
- Muestra el código actual
- Proporciona la solución optimizada
- Genera una migración si necesita índices
```

### 6. Testing de Rutas

```
Genera tests para verificar que todas las rutas estén:
1. Correctamente definidas en web.php
2. Protegidas con middleware apropiado
3. Apuntando a los controladores correctos
4. Con los nombres correctos
5. Con los parámetros requeridos

Incluye tests para rutas públicas y protegidas.
```

### 7. Testing de Base de Datos

```
Revisa las migraciones y genera tests que verifiquen:
1. Todas las columnas existen
2. Los tipos de datos son correctos
3. Las llaves foráneas están definidas
4. Los índices están creados
5. Las restricciones (unique, nullable) funcionan
6. Los valores por defecto son correctos
7. Las relaciones en cascada funcionan (onDelete, onUpdate)
```

### 8. Refactorización y Mejoras

```
Analiza el código de [archivo/directorio] y sugiere:
1. Código duplicado que puede ser extraído a métodos/clases
2. Métodos muy largos que necesitan refactorización
3. Violaciones de principios SOLID
4. Oportunidades para usar Design Patterns
5. Mejoras en nomenclatura de variables y métodos
6. Simplificación de lógica compleja

Para cada sugerencia, proporciona el código refactorizado completo.
```

---

## 🚀 PROMPT EJECUTIVO (Para ejecutar todo de una vez)

```
Eres un Senior Laravel Developer experto en testing y code review. 

**FASE 1: ANÁLISIS PROFUNDO**
Analiza mi aplicación Laravel de gestión académica:
- Revisa TODOS los modelos en app/Models
- Revisa TODOS los controladores en app/Http/Controllers
- Revisa todas las rutas en routes/web.php
- Revisa todas las migraciones en database/migrations
- Revisa las vistas en resources/views

**FASE 2: DETECCIÓN DE PROBLEMAS**
Identifica y documenta:
1. ❌ Errores críticos (que rompen la app)
2. ⚠️ Warnings (malas prácticas, vulnerabilidades)
3. 💡 Sugerencias de mejora
4. 🐌 Problemas de rendimiento

**FASE 3: GENERACIÓN DE TESTS**
Genera una suite completa de tests:
- tests/Unit/ → Tests de modelos
- tests/Feature/ → Tests de controladores
- tests/Integration/ → Tests de flujos completos

**FASE 4: CORRECCIONES**
Para cada problema encontrado:
1. Explica qué está mal
2. Muestra el código actual
3. Proporciona el código corregido
4. Genera el test que verifica la corrección

**FASE 5: REPORTE FINAL**
Genera un reporte markdown con:
- Resumen ejecutivo
- Lista priorizada de problemas
- Métricas (cobertura de tests, complejidad ciclomática)
- Plan de acción recomendado

Comienza el análisis ahora. Sé exhaustivo y detallado.
```

---

## 💡 CÓMO USAR ESTOS PROMPTS

### En el Chat de Copilot:
1. Abre el panel de Copilot (Ctrl+Shift+I o Cmd+Shift+I)
2. Copia y pega el prompt que necesites
3. Espera el análisis y las sugerencias
4. Pide aclaraciones o más detalles si es necesario

### En archivos de código:
1. Abre el archivo que quieres testear
2. Selecciona el código (o todo el archivo)
3. Click derecho → "Copilot" → "Explain this"
4. En el chat, escribe: "Ahora genera tests completos para este código"

### Con comentarios en el código:
```php
// @copilot Genera tests completos para este controlador
// Incluye tests de validación, autenticación y casos edge
class DocenteController extends Controller
{
    // ...
}
```

---

## 🎯 COMANDOS RÁPIDOS

Usa estos en el chat de Copilot para acciones específicas:

- `/tests` - Genera tests para el archivo actual
- `/fix` - Corrige problemas en el código seleccionado
- `/explain` - Explica qué hace el código
- `/doc` - Genera documentación
- `@workspace` - Analiza todo el workspace

---

## 📊 EJEMPLO DE USO PRÁCTICO

```
@workspace Analiza mi aplicación académica y:
1. Encuentra todos los controladores sin tests
2. Para cada uno, genera el archivo de test completo
3. Verifica que las validaciones estén correctas
4. Optimiza las queries con N+1 problems
5. Genera un checklist de mejoras prioritarias

Enfócate en los módulos de: gestiones, docentes, materias, grupos, aulas y horarios.
```

---

## ✅ CHECKLIST DE TESTING

Después de ejecutar los tests, verifica:

- [ ] Todos los modelos tienen tests de relaciones
- [ ] Todos los controladores tienen feature tests
- [ ] Las validaciones están testeadas
- [ ] Hay tests de autorización
- [ ] Los tests de base de datos pasan
- [ ] No hay N+1 queries
- [ ] Las rutas están protegidas
- [ ] Los formularios tienen protección CSRF
- [ ] Los inputs están sanitizados
- [ ] La cobertura de código es > 80%

---

## 🔧 COMANDOS ARTISAN ÚTILES

Después de generar tests con Copilot:

```bash
# Ejecutar todos los tests
php artisan test

# Tests con cobertura
php artisan test --coverage

# Tests específicos
php artisan test --filter=DocenteTest

# Tests con output detallado
php artisan test --verbose
```
