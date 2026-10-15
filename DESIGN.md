---
name: Sosro Career Hub
colors:
  surface: '#f6faff'
  surface-dim: '#d2dbe4'
  surface-bright: '#f6faff'
  surface-container-lowest: '#ffffff'
  surface-container-low: '#ecf5fe'
  surface-container: '#e6eff8'
  surface-container-high: '#e0e9f2'
  surface-container-highest: '#dbe4ed'
  on-surface: '#141d23'
  on-surface-variant: '#59413f'
  inverse-surface: '#293138'
  inverse-on-surface: '#e9f2fb'
  outline: '#8d706f'
  outline-variant: '#e1bfbc'
  surface-tint: '#b12a31'
  primary: '#92101e'
  on-primary: '#ffffff'
  primary-container: '#b42c33'
  on-primary-container: '#ffd1ce'
  inverse-primary: '#ffb3b0'
  secondary: '#5a605c'
  on-secondary: '#ffffff'
  secondary-container: '#dfe4df'
  on-secondary-container: '#606662'
  tertiary: '#950025'
  on-tertiary: '#ffffff'
  tertiary-container: '#bc1a37'
  on-tertiary-container: '#ffd0d0'
  error: '#ba1a1a'
  on-error: '#ffffff'
  error-container: '#ffdad6'
  on-error-container: '#93000a'
  primary-fixed: '#ffdad8'
  primary-fixed-dim: '#ffb3b0'
  on-primary-fixed: '#410006'
  on-primary-fixed-variant: '#8f0d1d'
  secondary-fixed: '#dfe4df'
  secondary-fixed-dim: '#c3c8c3'
  on-secondary-fixed: '#181d1a'
  on-secondary-fixed-variant: '#434844'
  tertiary-fixed: '#ffdada'
  tertiary-fixed-dim: '#ffb3b4'
  on-tertiary-fixed: '#40000b'
  on-tertiary-fixed-variant: '#920024'
  background: '#f6faff'
  on-background: '#141d23'
  surface-variant: '#dbe4ed'
  sosro-crimson: '#B42C33'
  sosro-crimson-vivid: '#B51233'
  surface-card: '#FFFFFF'
  surface-subtle: '#F8F9FA'
  status-active: '#0D8A56'
  status-review: '#D97706'
  text-on-primary: '#FFFFFF'
typography:
  headline-xl:
    fontFamily: Inter
    fontSize: 40px
    fontWeight: '700'
    lineHeight: 48px
  headline-xl-mobile:
    fontFamily: Inter
    fontSize: 30px
    fontWeight: '700'
    lineHeight: 38px
  headline-lg:
    fontFamily: Inter
    fontSize: 28px
    fontWeight: '600'
    lineHeight: 36px
  headline-md:
    fontFamily: Inter
    fontSize: 22px
    fontWeight: '600'
    lineHeight: 30px
  title-lg:
    fontFamily: Inter
    fontSize: 18px
    fontWeight: '600'
    lineHeight: 26px
  title-md:
    fontFamily: Inter
    fontSize: 16px
    fontWeight: '600'
    lineHeight: 24px
  body-lg:
    fontFamily: Inter
    fontSize: 16px
    fontWeight: '400'
    lineHeight: 24px
  body-md:
    fontFamily: Inter
    fontSize: 14px
    fontWeight: '400'
    lineHeight: 20px
  label-lg:
    fontFamily: Inter
    fontSize: 15px
    fontWeight: '600'
    lineHeight: 20px
  label-md:
    fontFamily: Inter
    fontSize: 14px
    fontWeight: '500'
    lineHeight: 18px
  label-sm:
    fontFamily: Inter
    fontSize: 12px
    fontWeight: '500'
    lineHeight: 16px
rounded:
  sm: 0.5rem
  DEFAULT: 1rem
  md: 1.5rem
  lg: 2rem
  xl: 3rem
  full: 9999px
spacing:
  gutter: 1.5rem
  gutter-mobile: 1rem
  margin: 2rem
  margin-mobile: 1rem
  space-xs: 0.25rem
  space-sm: 0.5rem
  space-md: 1rem
  space-lg: 1.5rem
  space-xl: 2.5rem
  space-2xl: 4rem
---

## Brand & Style

The design system powers the recruitment and career experience for PT Sinar Sosro, Indonesia’s heritage beverage leader. The interface balances high-trust corporate reliability with the welcoming, energizing warmth synonymous with the brand. It addresses diverse job seekers across Indonesia—from corporate executives and technical specialists to manufacturing and field sales candidates.

The visual direction follows a **Corporate / Modern** aesthetic with deliberate human touchpoints:
- **Clean Architectural Clarity:** Pure white foundations paired with intentional negative space create immediate legibility and seamless navigation across job listings and application funnels.
- **Iconic Crimson Anchors:** Deep, recognizable crimson acts as an unmistakable focal point for primary calls to action, active statuses, and vital career milestones.
- **Friendly Precision:** High-radius pill contours and smooth card envelopes soften rigorous enterprise workflows, making the portal approachable, accessible, and fast to parse on mobile devices.

## Colors

The palette revolves around the iconic Sosro heritage crimson:
- **Primary (`#B42C33`)**: The core brand anchor. Used for primary interactive touchpoints, hero application banners, submit controls, and essential branded headers.
- **Secondary (`#1F2421`)**: A grounding, deep charcoal-black ensuring maximum WCAG AAA contrast for body typography, form input labels, and core table headings.
- **Tertiary (`#B51233`)**: An intense, saturated crimson variant dedicated to micro-interactions, selected dropdown states, interactive list highlights, and interactive links.
- **Neutral (`#6C757D`)**: Balanced, cool slate gray for secondary metadata, subtle dividers, supporting timestamps, and deactivated states.

### Color Rules & Hierarchy
- Avoid tinted red backgrounds for body surfaces; keep background canvas pure `#FFFFFF` or softened to `#F8F9FA` for structured recruitment cards.
- Crimson should never compete with warning or error states; pair error alerts with distinct crimson-adjacent deep rubies accompanied by unambiguous iconography.
- Job category tags and operational regional badges utilize subtle neutral backgrounds (`#F1F3F5`) with crisp dark text or light crimson tints (`#FDF2F2` background with `#B42C33` text) to preserve scan speed.

## Typography

The design system exclusively implements **Inter** across all structural tiers to deliver industrial-strength clarity and cross-platform consistency.

- **Headlines:** Set with firm weights (600 and 700) and tight, disciplined line-heights to ground job titles, department hubs, and major portal metrics without distracting editorial flourish.
- **Interactive Labels:** Standard button labels and menu options leverage `15px / 600` or `14px / 500` to maintain optical parity with high-radius pill contours.
- **Body & Editorial Content:** Job responsibilities, candidate requirements, and corporate policy summaries use `body-md` (14px) and `body-lg` (16px) with generous line heights to prevent reading fatigue during complex application workflows.

## Layout & Spacing

Layout execution relies on an adaptable 12-column responsive grid engineered for both high-density candidate search dashboards and focused, uncluttered application forms.

- **Desktop (1024px+):** 12-column layout with 24px (`1.5rem`) gutters and a centered container max-width of 1280px. Split-view candidate filters and live vacancy results align cleanly across 4-column and 8-column sub-divisions.
- **Tablet (768px - 1023px):** 8-column layout with 16px (`1rem`) gutters. Filter panels collapse into top drawer selectors or sheet overlays.
- **Mobile (< 768px):** 4-column fluid layout with 16px margins. Job action bars and location triggers pin comfortably to thumb zones.

### Vertical Rhythm
Component stacks leverage strict multiples of 4px and 8px:
- Internal button and chip padding: `space-xs` and `space-sm` for vertical rhythm; `space-md` and `space-lg` for horizontal pill padding.
- Card interiors: `space-lg` (24px) for desktop vacancy containers, scaling down to `space-md` (16px) on mobile viewports.
- Section intervals: `space-xl` to `space-2xl` between application process steps and hero search panels.

## Elevation & Depth

Visual hierarchy emphasizes clean, tactile 2D structural planes over heavy skeuomorphic drop shadows.

- **Surface Tiers:** Depth is articulated primarily through surface value separation. Pure white (`#FFFFFF`) job and dropdown cards sit atop clean off-white canvas surfaces (`#F8F9FA`), framed with subtle, ultra-thin borders (`1px solid #E9ECEF`).
- **Floating Overlays & Menus:** Dropdowns (such as regional branch selectors like JKTBTN, JBR, and SBB) employ a soft ambient shadow (`0 8px 24px rgba(0, 0, 0, 0.08)`) with zero spread to float cleanly above application content without harsh contrast.
- **Interactive State Elevation:** Primary crimson buttons do not lift via heavy drop shadows; instead, subtle brightness shifts (`hover: #9E242B`, `active: #881F25`) and crisp focus rings (`0 0 0 3px rgba(180, 44, 51, 0.25)`) communicate interactivity crisply.

## Shapes

The design system incorporates a distinct hybrid geometry:
- **Pill Contours (Full Rounding / Level 3):** Primary calls-to-action, search triggers, floating location buttons, and interactive filter chips utilize a full 9999px / pill radius. This softens corporate density and creates high-affordance tap targets.
- **Containers & Menus:** Large surface cards, dropdown panels, and upload dropzones use `rounded-lg` (2rem) and `rounded-md` (1rem) envelopes, maintaining cohesion with the pill buttons while maximizing internal real estate for dense corporate data.
- **Form Controls:** Text inputs and location dropdown bars balance pill triggers with cleanly radiused input boxes (`1rem` / 16px), ensuring entered text does not crowd the inner corners.

## Components

### Buttons & Action Triggers
- **Primary Action Pill:** Solid crimson (`#B42C33`) container with crisp white Inter Medium typography (`15px` to `16px`) and embedded navigation chevron (`mingcute:right-fill`). Padding: `12px 24px` (collapsed) or `14px 28px` (large).
- **Secondary Button:** Outlined transparent surface with `1.5px solid #B42C33`, displaying crimson text. On hover, transitions to `#FDF2F2`.
- **Ghost Action:** Flat surface with `#1F2421` text for minor secondary portal actions (e.g., "Batal", "Lihat Deskripsi").

### Location & Filter Dropdown Menus
- **Trigger Element:** Crimson or white pill container housing the active selection with an inline chevron toggle.
- **Menu Overlay Container:** A floating `#FFFFFF` card with `16px` radius, subtle border (`#E9ECEF`), and diffused soft shadow.
- **List Items:** Structured lists displaying branch codes (e.g., `SANSBR`, `JKTBTN`, `JTH`, `HO`) set in `Inter Semi-Bold (15px)`. Default text color `#B51233` or `#1F2421`; hover state fills item with `#F8F9FA` with an active indicator tick.

### Status Tags & Chips
- **Category Chips:** Pill-shaped metadata tags (`roundedness: 3`) with `6px 14px` padding. Applied for job employment types ("Full-Time", "Internship", "Contract").
- **Application Status Badges:**
  - *Lolos Administrasi / Diterima:* Soft green tint (`#E8F5E9`) with `#0D8A56` label.
  - *Dalam Proses Review:* Soft amber tint (`#FEF3C7`) with `#D97706` label.
  - *Belum Sesuai:* Soft gray tint (`#F1F3F5`) with `#6C757D` label.

### Form Inputs & Application Fields
- **Text Inputs:** Height 48px, `16px` corner radius, `1px solid #CED4DA` border, white fill. 
- **Focus State:** Border shifts to `#B42C33` with a subtle outer crimson halo (`rgba(180, 44, 51, 0.15)`).
- **Labels:** Positioned outside the input field in `label-md` (`Inter 14px / 500`), secondary text tone (`#1F2421`).

### Vacancy & Career Cards
- **Structure:** Encapsulated `#FFFFFF` card with `16px` to `24px` radius, hairline border (`#E9ECEF`), and interior padding of `24px`.
- **Content Hierarchy:** Department badge top-left, job position (`title-lg`, bold), regional branch tag (`label-sm`), followed by a bottom row containing salary visibility / posting date and a direct pill CTA ("Lamar Sekarang").