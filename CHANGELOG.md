# Changelog

All notable changes to this project are documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.1.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [2.0.0] - 2026-05-31

### Changed
- **Rebrand to "Age Calculator".** Renamed the application from "DBD / Distance Between Dates"
  to **Age Calculator** across all visible surfaces — top-left nav mark, hero, calculator
  heading, page `<title>`s, meta descriptions, the Web Share title, and `APP_NAME`.
- **Code-level rename (no behavior change).**
  - `DateDistanceService` → `AgeCalculatorService`
  - `DateDistanceController` → `AgeCalculatorController`
  - view folder `resources/views/date-distance/` → `resources/views/age-calculator/`
  - `DateDistanceTest` → `AgeCalculatorTest`
  - `resources/js/utils/dateDistance.ts` → `resources/js/utils/ageCalculator.ts`
    (`calculateDateDistance` → `calculateAge`)
  - type `DateDistanceResult` → `AgeResult`; class `DateDistanceApp` → `AgeCalculatorApp`
- Landing-page version badge bumped to **v2.0**.
- The `/app` and `/calculate` URLs, route names, and the public domain are intentionally
  unchanged so existing links keep working.

### Fixed
- **Direction bug.** `getDirection` compared the target date to *now* instead of to the
  origin (`from`) date, so it mislabeled past/future whenever a custom origin was supplied.
  It is now computed relative to `from`, matching the client-side logic.
- **Human-readable phrasing.** Restored the documented `ago` / `from now` suffix in both the
  PHP service and the TypeScript util, so the server render and the client recalculation
  produce identical strings.
- **Landing-page crash.** `app.ts` (loaded on every page) no longer throws a `TypeError` when
  the calculator form is absent.
- **Fonts.** Inter + JetBrains Mono are now actually loaded from Google Fonts (they were
  declared in CSS but never fetched); `tailwind.config.js` was aligned with the CSS variables.
- **Tests.** Feature tests now target `/app` with assertions on real rendered content; added
  coverage for direction-relative-to-origin, the directional suffix, and a multi-component
  breakdown. `@vite` is stubbed via `withoutVite()` so HTTP tests don't require a built manifest.

### Removed
- Unused `resources/js/app.js` (Alpine) entry from the Vite input.

## [1.0.0] - 2026-02-25

### Added
- Initial release (as "Distance Between Dates"): a server-rendered Laravel 11 + Blade
  calculator with client-side `date-fns` recalculation — years/months/days breakdown plus
  cumulative totals (days, weeks, hours, seconds).
- Deep linking via `?date=&from=`, cookie + URL state persistence, copy & share actions,
  reset, and a `CMD+K` focus shortcut.
- Cyber-glassmorphism UI with the custom digital-hourglass logo.
