# Roig Arena — Design System v1.0
**Web de Compra de Entradas · Mayo 2026**

> Sistema de diseño oficial para la plataforma web y app de venta de entradas del Roig Arena, sede del Valencia Basket Club. Basado en la identidad visual del recinto (negro Arena + blanco + punto naranja) y los colores corporativos del Valencia Basket (Taronja naranja, negro y azul VBC).

---

## Índice

1. [Fundamentos](#1-fundamentos)
   - 1.1 [Paleta de Color](#11-paleta-de-color)
   - 1.2 [Tipografía](#12-tipografía)
   - 1.3 [Espaciado](#13-espaciado)
   - 1.4 [Radio de Borde](#14-radio-de-borde)
   - 1.5 [Sombras](#15-sombras)
   - 1.6 [Movimiento](#16-movimiento)
2. [Componentes](#2-componentes)
   - 2.1 [Navegación](#21-navegación)
   - 2.2 [Botones](#22-botones)
   - 2.3 [Formularios](#23-formularios)
   - 2.4 [Tarjetas de Evento](#24-tarjetas-de-evento)
   - 2.5 [Badges y Chips](#25-badges-y-chips)
   - 2.6 [Alertas](#26-alertas)
   - 2.7 [Flujo de Checkout](#27-flujo-de-checkout)
   - 2.8 [Entrada Digital](#28-entrada-digital)
   - 2.9 [Mapa de Asientos](#29-mapa-de-asientos)
3. [Patrones](#3-patrones)
   - 3.1 [Grid y Layout](#31-grid-y-layout)
   - 3.2 [Iconos](#32-iconos)
4. [Tokens CSS](#4-tokens-css)

---

## 1. Fundamentos

### 1.1 Paleta de Color

La paleta se construye sobre tres pilares de identidad:

- **Taronja** — El naranja corporativo del Valencia Basket (PMS 1585 C). Es el color principal de acción, marca y energía.
- **Arena Black** — El negro del logotipo Roig Arena. Fondo dominante que da elegancia y contraste.
- **Blau VBC** — El azul corporativo secundario (PMS 2925 C). Para acciones de selección y premium.

---

#### Taronja — Naranja Valencia Basket

| Token | Hex | Pantone | Uso |
|---|---|---|---|
| `--color-taronja-50` | `#FFF4EC` | — | Backgrounds muy sutiles |
| `--color-taronja-100` | `#FFE0C3` | — | Hover states suaves |
| `--color-taronja-200` | `#FFC799` | — | Borders sutiles naranjas |
| `--color-taronja-300` | `#FFAA66` | — | Text muted naranja |
| `--color-taronja-400` | `#FF8C33` | — | Hover de botón primario |
| **`--color-taronja-500`** | **`#FF6C0C`** | **PMS 1585 C** | **Brand orange principal — CTA, precios, accents** |
| `--color-taronja-600` | `#E05800` | — | Active states, pressed |
| `--color-taronja-700` | `#B84600` | — | Dark variant |
| `--color-taronja-800` | `#8C3400` | — | Very dark orange |
| `--color-taronja-900` | `#5C2100` | — | Near-black orange |

---

#### Arena — Negro y Gris neutro

| Token | Hex | Pantone | Uso |
|---|---|---|---|
| `--color-arena-50` | `#F5F5F5` | — | Texto sobre fondo oscuro (máx. contraste) |
| `--color-arena-100` | `#E8E8E8` | — | Texto secundario claro |
| `--color-arena-200` | `#CCCCCC` | — | Texto body sobre dark |
| `--color-arena-300` | `#AAAAAA` | — | Labels, metadata |
| `--color-arena-400` | `#888888` | — | Placeholder, hints |
| **`--color-arena-500`** | **`#5B6670`** | **PMS 431 C** | **Separadores, texto muted** |
| `--color-arena-600` | `#3A3F44` | — | Borders, elementos sutiles |
| `--color-arena-700` | `#242729` | — | Cards elevadas, ticket aside |
| `--color-arena-800` | `#141617` | — | Fondo cards, sidebar, panels |
| **`--color-arena-900`** | **`#0A0B0C`** | — | **Fondo principal de página (body)** |

---

#### Blau — Azul VBC (secundario)

| Token | Hex | Pantone | Uso |
|---|---|---|---|
| `--color-blau-400` | `#4DC8F0` | — | Hover azul |
| **`--color-blau-500`** | **`#009FE3`** | **PMS 2925 C** | **Asiento seleccionado, VIP, botón blue** |
| `--color-blau-600` | `#007EC0` | — | Active |
| `--color-blau-700` | `#005A8E` | — | Dark blue |

---

#### Colores Semánticos

| Token | Hex | Uso |
|---|---|---|
| `--color-success` | `#22C55E` | Compra completada, disponible, email verificado |
| `--color-warning` | `#EAB308` | Pocas entradas disponibles, advertencias |
| `--color-error` | `#EF4444` | Error de pago, campos inválidos |
| `--color-sold-out` | `#5B6670` | Evento agotado, asiento ocupado |
| `--color-white` | `#FFFFFF` | Texto principal, logotipo |
| `--color-off-white` | `#F8F6F3` | Backgrounds alternativos light |

---

#### Uso del Color — Reglas

- **Fondo de página**: siempre `--color-arena-900` (`#0A0B0C`)
- **Cards y panels**: `--color-arena-800` (`#141617`)
- **Texto principal**: `--color-white`
- **Texto secundario**: `--color-arena-300` / `--color-arena-400`
- **CTA principal siempre naranja**: `btn-primary` usa `--color-taronja-500`
- **Ratio de contraste mínimo**: 4.5:1 para texto normal, 3:1 para texto grande (WCAG AA)
- **No usar naranja sobre blanco** para texto en tamaños pequeños (contraste insuficiente)
- **El punto naranja del logotipo** (`·`) siempre es `--color-taronja-500`

---

### 1.2 Tipografía

#### Familias tipográficas

| Rol | Familia | Fuente | Uso |
|---|---|---|---|
| **Display / Headlines** | `Barlow Condensed` | Google Fonts | H1–H4, navbar, botones, badges, labels eyebrow |
| **Body / Texto** | `Barlow` | Google Fonts | Párrafos, formularios, descripciones, texto UI |
| **Mono / Datos** | `DM Mono` | Google Fonts | Precios, códigos de ticket, tokens CSS, asientos |

**Import Google Fonts:**
```html
<link href="https://fonts.googleapis.com/css2?family=Barlow+Condensed:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,400;1,700&family=Barlow:ital,wght@0,300;0,400;0,500;0,600;0,700;1,400&family=DM+Mono:wght@400;500&display=swap" rel="stylesheet">
```

```css
--font-display: 'Barlow Condensed', sans-serif;
--font-body:    'Barlow', sans-serif;
--font-mono:    'DM Mono', monospace;
```

---

#### Por qué estas fuentes

- **Barlow Condensed** — Comprimida, impactante, perfectamente legible en uppercase. Captura la energía del deporte y del espectáculo en vivo. Usada en weights 700–900 para titulares, siempre en UPPERCASE con `text-transform: uppercase`.
- **Barlow** — La versión regular de la misma familia, garantiza coherencia. Muy legible para texto corrido en dark mode. Neutral sin ser genérica.
- **DM Mono** — Monoespaciada elegante. Perfecta para precios (alineación numérica), códigos de entrada (FILA-C · 14) y tokens de desarrollo. Evita ambigüedades entre 0/O y 1/I/l.

---

#### Escala tipográfica

| Token | rem | px | Interlineado | Tracking | Uso principal |
|---|---|---|---|---|---|
| `--text-9xl` | 8rem | 128px | 1 (`none`) | `-0.03em` | Super hero display, estadística gigante |
| `--text-8xl` | 6rem | 96px | 1 (`none`) | `-0.03em` | Hero title máximo |
| `--text-7xl` | 4.5rem | 72px | 1 (`none`) | `-0.03em` | H1 hero página evento |
| `--text-6xl` | 3.75rem | 60px | 1.1 (`tight`) | `-0.02em` | Hero alternativo |
| `--text-5xl` | 3rem | 48px | 1.1 (`tight`) | `-0.02em` | H1 sección principal |
| `--text-4xl` | 2.25rem | 36px | 1.1 (`tight`) | `-0.02em` | H2 subsección |
| `--text-3xl` | 1.875rem | 30px | 1.2 (`snug`) | `-0.01em` | H3, card headline |
| `--text-2xl` | 1.5rem | 24px | 1.2 (`snug`) | `0` | H4, event card title |
| `--text-xl` | 1.25rem | 20px | 1.5 (`normal`) | `0` | Lead text, precio destacado |
| `--text-lg` | 1.125rem | 18px | 1.65 (`relaxed`) | `0` | Body large, descripción evento |
| **`--text-base`** | **1rem** | **16px** | **1.65 (`relaxed`)** | **0** | **Body estándar, inputs, formularios** |
| `--text-sm` | 0.875rem | 14px | 1.5 | `0` | Labels, metadata, subtítulos card |
| `--text-xs` | 0.75rem | 12px | 1.5 | `+0.08em` | Badges, hints, eyebrow labels |
| `--text-2xs` | 0.625rem | 10px | 1.5 | `+0.15em` | Micro texto, nav labels sidebar |

---

#### Pesos tipográficos

| Token | Valor | Uso con Barlow Condensed |
|---|---|---|
| `--weight-light` | 300 | Texto muy sutil, decorativo |
| `--weight-regular` | 400 | Body text en Barlow (no Condensed) |
| `--weight-medium` | 500 | Nav links, texto UI secundario |
| `--weight-semibold` | 600 | H4, card subtítulos |
| `--weight-bold` | 700 | H3, botones md/lg, nav active |
| `--weight-extrabold` | 800 | H2, sección titles |
| **`--weight-black`** | **900** | **H1, hero titles, precios, logotipo** |

---

#### Interlineados (Line Height)

| Token | Valor | Uso |
|---|---|---|
| `--leading-none` | 1 | Titulares gigantes, display text (H1 hero) |
| `--leading-tight` | 1.1 | H1–H2, card titles |
| `--leading-snug` | 1.2 | H3–H4, subtítulos |
| `--leading-normal` | 1.5 | Labels, elementos UI |
| `--leading-relaxed` | 1.65 | Body text, párrafos, formularios |
| `--leading-loose` | 2 | Texto muy aireado, legal |

---

#### Espaciado entre letras (Letter Spacing)

| Token | Valor | Uso |
|---|---|---|
| `--tracking-tight` | -0.03em | Titulares 5xl+ (comprime visualmente) |
| `--tracking-normal` | 0 | Body text normal |
| `--tracking-wide` | +0.04em | Botones, nav links |
| `--tracking-wider` | +0.08em | Labels, metadata sm |
| `--tracking-widest` | +0.15em | Eyebrow labels xs, badges uppercase |

---

#### Reglas tipográficas de uso

- **Titulares siempre en Barlow Condensed** con `font-weight: 700–900` y `text-transform: uppercase`
- **Cuerpo de texto siempre en Barlow** con `font-weight: 400–600`
- **Precios y códigos en DM Mono** — permite alineación numérica tabular
- **Eyebrow labels**: `Barlow Condensed · 10–12px · weight 700 · letter-spacing 0.15em · uppercase · color taronja-500`
- **No mezclar más de dos familias** en una misma vista
- **Tamaño mínimo legible**: 12px (`--text-xs`) para texto funcional; no usar `--text-2xs` para texto crítico de lectura

---

### 1.3 Espaciado

Sistema de grid base-8 (múltiplos de 4px). Todos los `margin`, `padding` y `gap` usan estos tokens.

| Token | rem | px | Uso principal |
|---|---|---|---|
| `--space-1` | 0.25rem | 4px | Micro gap, separación icon–texto |
| `--space-2` | 0.5rem | 8px | Gap entre icono y texto |
| `--space-3` | 0.75rem | 12px | Compact padding, badge padding |
| `--space-4` | 1rem | 16px | **Base unit** — padding input, gap mínimo card |
| `--space-5` | 1.25rem | 20px | Padding card sm |
| `--space-6` | 1.5rem | 24px | Card padding, gap entre elementos |
| `--space-8` | 2rem | 32px | Section padding, gap grid |
| `--space-10` | 2.5rem | 40px | Padding modal |
| `--space-12` | 3rem | 48px | Gap entre secciones |
| `--space-16` | 4rem | 64px | Page padding-top |
| `--space-20` | 5rem | 80px | Large sections |
| `--space-24` | 6rem | 96px | Hero padding vertical |
| `--space-32` | 8rem | 128px | Mega sections |
| `--space-40` | 10rem | 160px | Separación entre bloques mayores |

---

### 1.4 Radio de Borde

| Token | Valor | Uso principal |
|---|---|---|
| `--radius-none` | 0 | Tablas, separadores, elementos sharp |
| `--radius-sm` | 2px | Badges ultra-compactos, píxeles QR |
| `--radius-base` | 4px | **Botones, inputs, logo badge** |
| `--radius-md` | 6px | Dropdowns, tooltips, form fields |
| `--radius-lg` | 8px | Cards pequeñas, thumbnails, seat dots |
| `--radius-xl` | 12px | **Cards principales, panels, modales** |
| `--radius-2xl` | 16px | Bottom sheets, drawers laterales |
| `--radius-full` | 9999px | Pills, tags, avatares, botones redondos |

---

### 1.5 Sombras

Calibradas para dark mode (fondo oscuro). Las sombras son sutiles en niveles bajos y progresivas.

| Token | Valor CSS | Uso |
|---|---|---|
| `--shadow-sm` | `0 1px 3px rgba(0,0,0,0.4)` | Hover states leves |
| `--shadow-md` | `0 4px 16px rgba(0,0,0,0.5)` | Cards elevadas |
| `--shadow-lg` | `0 8px 32px rgba(0,0,0,0.6)` | Cards en hover, dropdowns abiertos |
| `--shadow-xl` | `0 16px 64px rgba(0,0,0,0.7)` | Modales, overlays, dialogs |
| `--shadow-glow-orange` | `0 0 32px rgba(255,108,12,0.35)` | Botón CTA en hover — identidad de marca |
| `--shadow-glow-blue` | `0 0 24px rgba(0,159,227,0.3)` | Asiento seleccionado, elementos VIP |

---

### 1.6 Movimiento

| Token | Valor | Uso |
|---|---|---|
| `--ease-fast` | `150ms ease` | Hover de botones, cambio de color de links |
| `--ease-base` | `250ms ease` | Cards, modales, dropdowns, inputs focus |
| `--ease-slow` | `400ms cubic-bezier(0.25, 0.46, 0.45, 0.94)` | Transiciones de página, hero reveals, sidebars |
| `--ease-spring` | `500ms cubic-bezier(0.34, 1.56, 0.64, 1)` | Asiento añadido al carrito, confirmación compra |

**Principios de movimiento:**
- Usar `ease-fast` para microinteracciones de feedback inmediato (color, opacity)
- Usar `ease-base` para transformaciones de posición y escala
- Usar `ease-spring` con moderación — solo para momentos de celebración (seat añadido, compra exitosa)
- Respetar `prefers-reduced-motion`: en usuarios con esta preferencia, reducir todas las animaciones a `150ms linear`

---

## 2. Componentes

### 2.1 Navegación

```css
/* Navbar — fija con glassmorphism */
.navbar {
  position: fixed;
  top: 0;
  width: 100%;
  height: 64px;
  background: rgba(10,11,12,0.92);
  backdrop-filter: blur(20px);
  -webkit-backdrop-filter: blur(20px);
  border-bottom: 1px solid rgba(255,255,255,0.06);
  z-index: var(--z-overlay);
  transition: background var(--ease-base);
}

/* Sobre hero: transparente */
.navbar.on-hero {
  background: transparent;
  border-bottom: none;
}

/* Al hacer scroll: sólida */
.navbar.scrolled {
  background: rgba(10,11,12,0.96);
}
```

**Estructura:**

| Elemento | Fuente | Tamaño | Peso | Tracking | Color |
|---|---|---|---|---|---|
| Logo "Roig·Arena" | Barlow Condensed | 20px | 900 | -0.02em | White + punto naranja |
| Nav links | Barlow Condensed | 14px | 600 | +0.04em | arena-300 / white hover |
| Nav link activo | Barlow Condensed | 14px | 600 | +0.04em | taronja-500 |
| Botón CTA nav | — | btn-sm primary | — | — | — |

---

### 2.2 Botones

Todos los botones usan `font-family: Barlow Condensed`, `text-transform: uppercase`, `letter-spacing: 0.06–0.08em`.

#### Variantes

| Clase | Background | Color texto | Borde | Hover |
|---|---|---|---|---|
| `btn-primary` | `taronja-500` | `#000` | ninguno | `taronja-400` + `glow-orange` |
| `btn-secondary` | `transparent` | `taronja-500` | 2px `taronja-500` | bg `taronja-500/08` |
| `btn-ghost` | `white/05` | `arena-200` | 1px `white/10` | bg `white/10` |
| `btn-dark` | `arena-700` | `white` | ninguno | `arena-600` |
| `btn-blue` | `blau-500` | `#000` | ninguno | `blau-400` + `glow-blue` |
| `btn-danger` | `transparent` | `error` | 2px `error` | bg `error/08` |

#### Tamaños

| Clase | Font | Height | Padding H | Uso |
|---|---|---|---|---|
| `btn-sm` | 12px | 32px | 16px | Navbar, badges compactos, tabla |
| `btn-md` | 14px | 44px | 24px | **Tamaño por defecto** — Cards, formularios |
| `btn-lg` | 16px | 54px | 32px | Sidebar checkout, modal CTA |
| `btn-xl` | 18px | 64px | 40px | Hero CTA principal "Comprar Entradas" |

#### Estados

- **Default** — estilo base
- **Hover** — ligero cambio de luminosidad + shadow/glow
- **Active/Pressed** — overlay `rgba(0,0,0,0.15)` 
- **Focus** — `outline: 3px solid rgba(255,108,12,0.5); outline-offset: 2px`
- **Disabled** — `opacity: 0.4; cursor: not-allowed; pointer-events: none`
- **Loading** — icono spinner izquierdo, texto "Procesando…"

---

### 2.3 Formularios

#### Input estándar

```css
.form-input {
  height: 48px;
  background: var(--color-arena-800);
  border: 1px solid rgba(255,255,255,0.1);
  border-radius: var(--radius-md);        /* 6px */
  padding: 12px 16px;
  font-family: var(--font-body);
  font-size: var(--text-base);            /* 16px */
  color: var(--color-white);
  transition: all var(--ease-fast);
}

.form-input:focus {
  border-color: var(--color-taronja-500);
  box-shadow: 0 0 0 3px rgba(255,108,12,0.15);
  outline: none;
}

.form-input.error {
  border-color: var(--color-error);
  box-shadow: 0 0 0 3px rgba(239,68,68,0.15);
}

.form-input.success {
  border-color: var(--color-success);
  box-shadow: 0 0 0 3px rgba(34,197,94,0.12);
}
```

#### Labels

```css
.form-label {
  font-family: var(--font-display);     /* Barlow Condensed */
  font-size: var(--text-xs);            /* 12px */
  font-weight: var(--weight-bold);      /* 700 */
  letter-spacing: var(--tracking-widest); /* 0.15em */
  text-transform: uppercase;
  color: var(--color-arena-300);
  display: block;
  margin-bottom: 8px;
}
```

#### Elementos de formulario

| Elemento | Altura | Radio | Notas |
|---|---|---|---|
| `input[type=text/email/tel]` | 48px | 6px | Base estándar |
| `input[type=password]` | 48px | 6px | + icono eye toggle |
| `select` | 48px | 6px | Chevron SVG custom |
| `textarea` | min 96px | 8px | resize: vertical |
| `checkbox` | 18×18px | 4px | Custom styled, naranja check |
| `radio` | 18×18px | full | Custom styled, dot naranja |

---

### 2.4 Tarjetas de Evento

#### Anatomía

```
┌─────────────────────────────┐
│   [Thumbnail 16:9]          │
│   [Badge tipo] [Badge estado]│
│                             │
│   SAB 31 MAYO · 20:30       │  ← fecha: taronja-500, Barlow Condensed 12px, uppercase
│   VALENCIA BASKET VS BARÇA  │  ← título: white, Barlow Condensed 24px Black, uppercase
│   Liga Endesa · Jornada 34  │  ← subtítulo: arena-400, Barlow 14px
│                             │
│  ─────────────────────────  │
│   34.50€ desde  [ENTRADAS▶] │  ← precio: DM Mono / btn-primary sm
└─────────────────────────────┘
```

#### CSS clave

```css
.event-card {
  background: var(--color-arena-800);
  border-radius: var(--radius-xl);     /* 12px */
  border: 1px solid rgba(255,255,255,0.06);
  transition: all var(--ease-slow);
}

.event-card:hover {
  transform: translateY(-4px);
  border-color: rgba(255,108,12,0.3);
  box-shadow: var(--shadow-lg), 0 0 0 1px rgba(255,108,12,0.15);
}
```

#### Variantes de estado

| Estado | Indicador visual |
|---|---|
| Disponible | Badge verde "✓ Disponible" |
| Pocas entradas | Badge amarillo "⚡ Pocas entradas" |
| Sold Out | Badge gris "Sold Out" + botón disabled "Lista espera" |
| Próximamente | Badge azul "Próximamente" |

---

### 2.5 Badges y Chips

#### Badges (en cards y thumbnails)

| Clase | Fondo | Texto | Uso |
|---|---|---|---|
| `badge-orange` | `taronja-500` | `#000` | Categoría Basket |
| `badge-blue` | `blau-500` | `#000` | Categoría Concierto/Evento |
| `badge-gray` | `arena-600` | `arena-200` | Categoría Corporativo |
| `badge-sold` | `arena-600` | `arena-300` | Agotado |
| `badge-few` | `warning/20` | `warning` | Pocas entradas — borde warning/30 |
| `badge-free` | `success/20` | `success` | Disponible — borde success/30 |

```css
.badge {
  display: inline-flex;
  align-items: center;
  padding: 3px 8px;
  border-radius: var(--radius-sm);        /* 2px */
  font-family: var(--font-display);
  font-size: var(--text-2xs);             /* 10px */
  font-weight: var(--weight-bold);
  letter-spacing: var(--tracking-widest);
  text-transform: uppercase;
}
```

#### Chips (filtros y tags)

| Clase | Uso |
|---|---|
| `chip-orange` | Competición activa, filtro seleccionado |
| `chip-blue` | EuroLeague, selecciones premium |
| `chip-white` | Estado neutro, filtro inactivo |

```css
.chip {
  display: inline-flex;
  align-items: center;
  padding: 4px 12px;
  border-radius: var(--radius-full);      /* 9999px */
  font-family: var(--font-display);
  font-size: var(--text-xs);             /* 12px */
  font-weight: var(--weight-semibold);
  text-transform: uppercase;
  letter-spacing: var(--tracking-wide);
}
```

---

### 2.6 Alertas

Sistema de cuatro niveles semánticos con borde lateral de 4px.

| Variante | Borde | Fondo | Icono | Uso |
|---|---|---|---|---|
| `alert-info` | `blau-500` | `blau/08` | `i` blau | Información general |
| `alert-success` | `success` | `success/08` | `✓` success | Compra completada |
| `alert-warning` | `warning` | `warning/08` | `!` warning | Pocas entradas, tiempo limitado |
| `alert-error` | `error` | `error/08` | `✕` error | Error de pago, sesión expirada |

```css
.alert {
  display: flex;
  align-items: flex-start;
  gap: 12px;
  padding: 16px 20px;
  border-radius: var(--radius-lg);      /* 8px */
  border-left: 4px solid;
}

.alert-title {
  font-family: var(--font-display);
  font-size: var(--text-xs);
  font-weight: var(--weight-bold);
  letter-spacing: var(--tracking-wide);
  text-transform: uppercase;
  display: block;
  margin-bottom: 2px;
}
```

---

### 2.7 Flujo de Checkout

#### Stepper de 4 pasos

```
[✓] SELECCIÓN ──────── [2] ASIENTOS ──────── [ ] DATOS ──────── [ ] PAGO
    (done: naranja)       (active: outline)     (pending: gris)     (pending: gris)
```

| Estado | Circle | Label |
|---|---|---|
| `done` | Relleno `taronja-500`, icono ✓ negro | `arena-300` |
| `active` | Borde `taronja-500`, número `taronja-500`, fondo `taronja/10` | `white` |
| `pending` | Borde `white/15`, número `arena-500` | `arena-500` |

**Línea de progreso entre pasos:**
- Done → active: línea `taronja-500`
- Pending: línea `white/08`

#### Páginas del flujo

1. **Selección de evento** — Listing con filtros y search
2. **Selección de asientos** — Mapa interactivo del arena
3. **Datos del comprador** — Formulario con validación inline
4. **Pago** — Integración pasarela, resumen pedido

**Temporizador de reserva**: Al llegar al paso 3, se activa un countdown de 15 minutos. Se muestra con `DM Mono`, color `warning` cuando quedan menos de 5 minutos, `error` cuando queda menos de 1 minuto.

---

### 2.8 Entrada Digital

La entrada digital (ticket) se muestra tras la compra y se envía por email.

#### Anatomía

```
┌─┬──────────────────────────────┬─────────────┐
│█│  LIGA ENDESA · PLAYOFF       │   34€       │  ← banda naranja izquierda 4px
│█│  VALENCIA BASKET             │   precio    │
│█│  VS REAL MADRID              │             │
│█│                              │  [QR CODE]  │
│█│  Fecha   Hora   Zona  Asiento│             │
│█│  Titular         Tipo        │  VBC-2026-  │
└─┴──────────────────────────────┴─────────────┘
```

**Especificaciones:**

| Elemento | Fuente | Tamaño | Peso | Color |
|---|---|---|---|---|
| Categoría evento | Barlow Condensed | 12px | 700 | taronja-500 |
| Nombre del evento | Barlow Condensed | 24px | 900 | white |
| Labels de campo | Barlow Condensed | 10px | 700 | arena-500 |
| Valores de campo | Barlow | 14px | 600 | arena-100 |
| Precio | DM Mono | 30px | — | taronja-500 |
| Código ticket | DM Mono | 8px | — | arena-500 |
| Banda lateral | — | 4px ancho | — | taronja-500 |

---

### 2.9 Mapa de Asientos

#### Estados de asientos

| Estado | Color | Comportamiento |
|---|---|---|
| `available` | `taronja-500` | Hover: scale 1.2, glow naranja |
| `selected` | `blau-500` | Borde white, glow azul |
| `sold` | `arena-700` opacity 0.5 | cursor not-allowed, no hover |
| `vip` | gradient `#FFD700 → #FFA500` | Borde gold |

```css
.seat {
  width: 18px;
  height: 18px;
  border-radius: 3px;
  cursor: pointer;
  transition: all var(--ease-fast);
}

.seat.available { background: var(--color-taronja-500); }
.seat.available:hover {
  transform: scale(1.2);
  box-shadow: var(--shadow-glow-orange);
}

.seat.selected {
  background: var(--color-blau-500);
  border: 2px solid var(--color-white);
  box-shadow: var(--shadow-glow-blue);
}

.seat.sold {
  background: var(--color-arena-700);
  opacity: 0.5;
  cursor: not-allowed;
}
```

#### Leyenda

Siempre visible en la parte superior del mapa con los cuatro estados documentados. Font: Barlow 12px, arena-300.

---

## 3. Patrones

### 3.1 Grid y Layout

#### Sistema de columnas

| Breakpoint | Nombre | Min-width | Columnas | Gutter | Margin |
|---|---|---|---|---|---|
| `xs` | Mobile S | 375px | 4 | 16px | 16px |
| `sm` | Mobile L | 640px | 4 | 16px | 24px |
| `md` | Tablet | 768px | 8 | 24px | 32px |
| `lg` | Desktop | 1024px | 12 | 24px | 48px |
| `xl` | Desktop L | 1280px | 12 | 32px | 64px |
| `2xl` | Wide | 1536px | 12 | 32px | auto (max 1280px) |

```css
/* Contenedor máximo */
.container {
  max-width: 1280px;
  margin: 0 auto;
  padding: 0 var(--space-8);  /* 32px */
}

/* Grid base */
.grid { display: grid; gap: var(--space-6); }
.grid-2 { grid-template-columns: repeat(2, 1fr); }
.grid-3 { grid-template-columns: repeat(3, 1fr); }
.grid-4 { grid-template-columns: repeat(4, 1fr); }

/* Event listing */
.events-grid {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
  gap: var(--space-6);
}
```

#### Responsive de tarjetas

```css
@media (max-width: 768px)  { .events-grid { grid-template-columns: 1fr; } }
@media (min-width: 768px)  { .events-grid { grid-template-columns: repeat(2, 1fr); } }
@media (min-width: 1024px) { .events-grid { grid-template-columns: repeat(3, 1fr); } }
@media (min-width: 1280px) { .events-grid { grid-template-columns: repeat(4, 1fr); } }
```

---

### 3.2 Iconos

**Librería recomendada:** [Lucide Icons](https://lucide.dev) — open source, MIT license, consistente.

| Parámetro | Valor |
|---|---|
| Stroke width | 1.5px |
| Tamaños disponibles | 16px / 20px / 24px |
| Color por defecto | `currentColor` (hereda del padre) |
| Formato | SVG inline o componente React |

#### Iconos del sistema de entradas

| Icono | Nombre Lucide | Uso |
|---|---|---|
| 🗓 | `Calendar` | Fecha del evento |
| 🎫 | `Ticket` | Entrada, sección entradas |
| 🛒 | `ShoppingCart` | Carrito de compra |
| 📍 | `MapPin` | Ubicación, "Cómo llegar" |
| 🕐 | `Clock` | Hora del evento |
| 👤 | `User` | Mi cuenta |
| 💳 | `CreditCard` | Pago, método de pago |
| ✓ | `Check` | Confirmación, validado |
| 🔍 | `Search` | Buscar eventos |
| ⭐ | `Star` | VIP, favorito |
| 🔒 | `Lock` | Seguridad, pago seguro |
| ☰ | `Menu` | Menú hamburguesa |
| ✕ | `X` | Cerrar, eliminar |
| ← | `ChevronLeft` | Volver, anterior |
| → | `ChevronRight` | Siguiente |
| ↓ | `ChevronDown` | Dropdown, acordeón |
| ⚠ | `AlertTriangle` | Warning, advertencia |
| ℹ | `Info` | Información |

---

## 4. Tokens CSS

Listado completo de todos los custom properties. Copiar en el `:root` del proyecto.

```css
:root {

  /* ─────────── COLORES ─────────── */

  /* Taronja — Naranja Valencia Basket */
  --color-taronja-50:  #FFF4EC;
  --color-taronja-100: #FFE0C3;
  --color-taronja-200: #FFC799;
  --color-taronja-300: #FFAA66;
  --color-taronja-400: #FF8C33;
  --color-taronja-500: #FF6C0C;   /* Brand — PMS 1585 C ★ */
  --color-taronja-600: #E05800;
  --color-taronja-700: #B84600;
  --color-taronja-800: #8C3400;
  --color-taronja-900: #5C2100;

  /* Arena — Negro y Gris neutro */
  --color-arena-50:  #F5F5F5;
  --color-arena-100: #E8E8E8;
  --color-arena-200: #CCCCCC;
  --color-arena-300: #AAAAAA;
  --color-arena-400: #888888;
  --color-arena-500: #5B6670;   /* PMS 431 C */
  --color-arena-600: #3A3F44;
  --color-arena-700: #242729;
  --color-arena-800: #141617;   /* Card background ★ */
  --color-arena-900: #0A0B0C;   /* Page background ★ */

  /* Blau — Azul VBC */
  --color-blau-400: #4DC8F0;
  --color-blau-500: #009FE3;    /* PMS 2925 C ★ */
  --color-blau-600: #007EC0;
  --color-blau-700: #005A8E;

  /* Semánticos */
  --color-success:   #22C55E;
  --color-warning:   #EAB308;
  --color-error:     #EF4444;
  --color-sold-out:  #5B6670;
  --color-white:     #FFFFFF;
  --color-off-white: #F8F6F3;

  /* ─────────── TIPOGRAFÍA ─────────── */

  --font-display: 'Barlow Condensed', sans-serif;
  --font-body:    'Barlow', sans-serif;
  --font-mono:    'DM Mono', monospace;

  /* Escala de tamaños */
  --text-2xs:  0.625rem;   /* 10px */
  --text-xs:   0.75rem;    /* 12px */
  --text-sm:   0.875rem;   /* 14px */
  --text-base: 1rem;       /* 16px */
  --text-lg:   1.125rem;   /* 18px */
  --text-xl:   1.25rem;    /* 20px */
  --text-2xl:  1.5rem;     /* 24px */
  --text-3xl:  1.875rem;   /* 30px */
  --text-4xl:  2.25rem;    /* 36px */
  --text-5xl:  3rem;       /* 48px */
  --text-6xl:  3.75rem;    /* 60px */
  --text-7xl:  4.5rem;     /* 72px */
  --text-8xl:  6rem;       /* 96px */
  --text-9xl:  8rem;       /* 128px */

  /* Interlineados */
  --leading-none:    1;
  --leading-tight:   1.1;
  --leading-snug:    1.2;
  --leading-normal:  1.5;
  --leading-relaxed: 1.65;
  --leading-loose:   2;

  /* Letter Spacing */
  --tracking-tight:   -0.03em;
  --tracking-normal:   0em;
  --tracking-wide:     0.04em;
  --tracking-wider:    0.08em;
  --tracking-widest:   0.15em;

  /* Pesos */
  --weight-light:     300;
  --weight-regular:   400;
  --weight-medium:    500;
  --weight-semibold:  600;
  --weight-bold:      700;
  --weight-extrabold: 800;
  --weight-black:     900;

  /* ─────────── ESPACIADO ─────────── */

  --space-1:    0.25rem;   /* 4px  */
  --space-2:    0.5rem;    /* 8px  */
  --space-3:    0.75rem;   /* 12px */
  --space-4:    1rem;      /* 16px */
  --space-5:    1.25rem;   /* 20px */
  --space-6:    1.5rem;    /* 24px */
  --space-8:    2rem;      /* 32px */
  --space-10:   2.5rem;    /* 40px */
  --space-12:   3rem;      /* 48px */
  --space-16:   4rem;      /* 64px */
  --space-20:   5rem;      /* 80px */
  --space-24:   6rem;      /* 96px */
  --space-32:   8rem;      /* 128px */
  --space-40:   10rem;     /* 160px */

  /* ─────────── BORDER RADIUS ─────────── */

  --radius-none: 0;
  --radius-sm:   2px;
  --radius-base: 4px;
  --radius-md:   6px;
  --radius-lg:   8px;
  --radius-xl:   12px;
  --radius-2xl:  16px;
  --radius-full: 9999px;

  /* ─────────── SOMBRAS ─────────── */

  --shadow-sm:           0 1px 3px rgba(0,0,0,0.4);
  --shadow-md:           0 4px 16px rgba(0,0,0,0.5);
  --shadow-lg:           0 8px 32px rgba(0,0,0,0.6);
  --shadow-xl:           0 16px 64px rgba(0,0,0,0.7);
  --shadow-glow-orange:  0 0 32px rgba(255,108,12,0.35);
  --shadow-glow-blue:    0 0 24px rgba(0,159,227,0.3);

  /* ─────────── TRANSICIONES ─────────── */

  --ease-fast:   150ms ease;
  --ease-base:   250ms ease;
  --ease-slow:   400ms cubic-bezier(0.25, 0.46, 0.45, 0.94);
  --ease-spring: 500ms cubic-bezier(0.34, 1.56, 0.64, 1);

  /* ─────────── Z-INDEX ─────────── */

  --z-below:   -1;
  --z-base:     0;
  --z-raised:  10;
  --z-overlay: 50;
  --z-modal:  100;
  --z-toast:  200;
}
```

---

## Notas de Accesibilidad

- Todos los textos sobre fondos deben cumplir **WCAG AA** mínimo (4.5:1 texto normal, 3:1 texto grande)
- El naranja `#FF6C0C` sobre negro `#0A0B0C` alcanza ratio **7.4:1** ✅
- El blanco `#FFFFFF` sobre negro `#0A0B0C` alcanza ratio **21:1** ✅
- El naranja `#FF6C0C` sobre blanco `#FFFFFF` alcanza ratio **3.0:1** — solo usar en tamaños 18px+ Bold ⚠️
- Todos los inputs deben tener `label` visible y asociado
- Focus visible en todos los elementos interactivos (outline naranja)
- El mapa de asientos incluye roles ARIA (`role="grid"`, `aria-label`, `aria-pressed` por asiento)
- Imágenes decorativas: `alt=""` | Imágenes informativas: `alt` descriptivo

---

*Roig Arena Design System v1.0 · Web de Entradas · Creado Mayo 2026*
*Colores: Valencia Basket Club (PMS 1585 C naranja · PMS 2925 C azul · PMS 431 C gris) + Logotipo Roig Arena (negro + blanco + punto naranja)*
