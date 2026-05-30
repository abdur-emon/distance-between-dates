# Age Calculator - Calculate the Time Between Any Two Dates

![Age Calculator Hero](https://images.unsplash.com/photo-1501139083538-0139583c060f?auto=format&fit=crop&q=80&w=1200&h=400)

A modern, production-grade Laravel application that calculates the precise time between any two dates with beautiful visualizations and high-fidelity cyber-aesthetics.

[![Version](https://img.shields.io/badge/version-2.0.0-38bdf8?style=for-the-badge)](CHANGELOG.md)
[![Laravel 11](https://img.shields.io/badge/Laravel-11-FF2D20?style=for-the-badge&logo=laravel)](https://laravel.com)
[![TypeScript](https://img.shields.io/badge/TypeScript-5.9-3178C6?style=for-the-badge&logo=typescript)](https://www.typescriptlang.org)
[![Tailwind CSS](https://img.shields.io/badge/Tailwind-3.4-38B2AC?style=for-the-badge&logo=tailwind-css)](https://tailwindcss.com)
[![Vite 6](https://img.shields.io/badge/Vite-6-646CFF?style=for-the-badge&logo=vite)](https://vitejs.dev)

## 🎯 Features

- **Precise Calculations**: Calculate exactly how many years, months, days, weeks, hours, and seconds exist between two temporal coordinates.
- **Bidirectional**: Intelligently handles both `PAST_RECORD` (historical) and `FUTURE_PROJECTED` (upcoming) dates.
- **Deep Linking**: Seamlessly share exact calculations via URL parameters on the calculator route (`/app?date=...&from=...`).
- **State Persistence**: Remembers your preferences and last inputs using browser storage and cookies.
- **Accessibility First**: Designed with WCAG AA compliance, full keyboard navigation (`CMD+K` shortcuts), and ARIA-compliant labeling.
- **SEO Friendly**: Pre-rendered Blade layouts for maximum visibility and indexing by search engines.
- **Responsive Design**: A high-fidelity "glassmorphism" UI built with a mobile-first philosophy that scales into a premium desktop experience.

## 🏗️ Architecture

### Technology Stack

**Backend:**
- **Laravel 11**: (PHP 8.2+) powering the core engine.
- **Carbon 3.x**: For high-precision server-side date manipulation.
- **Service-Oriented Architecture**: Decoupled business logic for maximum testability.

**Frontend:**
- **TypeScript 5.9**: Type-safe logic for client-side interactions.
- **Vite 6**: Blazing-fast HMR and production builds.
- **Tailwind CSS 3.4**: Modern styling with custom glassmorphism effects.
- **date-fns v4**: Lightweight, tree-shakable date logic utilities.

**Design:**
- **Cyber-Glassmorphism**: A sleek, dark-mode aesthetic.
- **Typography**: Inter & JetBrains Mono font families (Google Fonts).
- **Branding**: Custom "Digital Hourglass" visuals with animated highlights.

### Architectural Decisions

#### 1. Server-Rendered Blade + TypeScript (Not SPA)
**Why?**
- ✅ **SEO**: Full HTML delivered on first paint.
- ✅ **Performance**: Near-zero JS bundle required for initial content display.
- ✅ **Progressive Enhancement**: Basic functionality works even with minimal client-side engagement.
- ✅ **Simplicity**: No complex state management frameworks like Redux or Pinia for a utility app.

#### 2. Service Layer Pattern
Business logic is isolated in `app/Services/AgeCalculatorService.php`.
**Why?**
- **Testability**: Pure functions that are easy to isolate in unit tests.
- **Reusability**: The same logic can be exposed via API controllers, Artisan commands, or scheduled jobs.
- **Maintainability**: A single source of truth for all temporal math.

#### 3. Client-Side Calculations
TypeScript handles real-time calculations in the browser via `date-fns` for immediate feedback.
**Why?**
- **Instant Response**: No network latency for basic calculations.
- **Reduced Load**: Minimizes hits to the Laravel engine for repeated user tweaks.
- **Offline Capable**: Once loaded, calculations function without a steady internet connection.

#### 4. Dual State Persistence
State is synchronized across Cookies, Local Storage, and URL Parameters.
**Why?**
- **Session Continuity**: Remembers user inputs across browser restarts.
- **Deep Linking**: Allows users to share specific calculation "states" with a single URL.
- **Priority System**: URL parameters take precedence, followed by saved state, then defaults.

## 📁 Project Structure

```bash
app/
├── Http/
│   └── Controllers/
│       └── AgeCalculatorController.php    # HTTP orchestration
└── Services/
    └── AgeCalculatorService.php           # Business logic (Temporal math)

resources/
├── js/
│   ├── app.ts                             # Application entry & UI logic
│   ├── types/
│   │   └── index.ts                       # TypeScript interfaces
│   └── utils/
│       ├── ageCalculator.ts               # Date calculation library
│       └── state.ts                       # Parameter & storage management
└── views/
    ├── layouts/
    │   └── main.blade.php                 # Cyber-aesthetic base layout
    ├── components/
    │   ├── date-input.blade.php           # Reusable terminal-style input
    │   └── result-display.blade.php       # Results grid UI
    └── age-calculator/
        └── index.blade.php                # Main application view
```

## 🚀 Getting Started

### Prerequisites
- PHP 8.2+
- Composer
- Node.js 18+ & NPM

### Installation
1. **Clone & Dependencies**:
   ```bash
   composer install
   npm install
   ```
2. **Setup Environment**:
   ```bash
   cp .env.example .env && php artisan key:generate
   ```
3. **Build Assets**:
   ```bash
   npm run build
   ```

### Development
For active development with HMR:
```bash
# Terminal 1: Laravel Server
php artisan serve

# Terminal 2: Asset Watcher
npm run dev
```

## 🎨 Design System

- **Primary Colors**: Sky Blue (`#38bdf8`) & Indigo (`#4f46e5`) accents.
- **Background**: Slate-950 base with dynamic radial gradient blurs.
- **Glassmorphism**: `background: rgba(15, 23, 42, 0.5); backdrop-filter: blur(12px);` borders for a futuristic terminal feel.

## 🔒 Security & Performance
- **Validation**: Strict server-side validation via Laravel's validation layer (`$request->validate()`), mirrored by client-side checks for instant feedback.
- **Exploit Prevention**: Native protection against CSRF, XSS, and SQL Injection.
- **Asset Optimization**: Vite optimizes chunks, tree-shakes dependencies, and compresses assets for instant loading.

## 📜 Changelog
See [CHANGELOG.md](CHANGELOG.md) for the full version history. The latest release is **v2.0.0** (rebrand to Age Calculator).

## 📄 License
Open source under the MIT License.

---
**Built with ❤️ using Laravel 11, TypeScript, and Tailwind CSS**
*Engineered by Abdur Rahman Emon*
