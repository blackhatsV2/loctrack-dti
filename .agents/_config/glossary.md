# Project Glossary

This glossary defines technical terms, domain concepts, and acronyms used throughout the **Preparedness, Safety & Continuity Portal (PSCP): Workforce Locator** project.

---

## Domain & Organizational Terms

| Term | Full Name / Meaning | Description |
|---|---|---|
| **PSCP** | Preparedness, Safety & Continuity Portal | The overall emergency management and continuity web portal for DTI Region 6. |
| **Workforce Locator** | Workforce Locator System | The core module that tracks employee GPS coordinates, plots personnel on Leaflet map layers, and monitors nearby disaster hazards. |
| **DTI Region 6** | Department of Trade and Industry - Region VI | Government regional executive department overseeing Western Visayas (Aklan, Antique, Capiz, Guimaras, Iloilo, Negros Occidental). |
| **PO** | Provincial Office | DTI regional office branches located in each of the 6 provinces in Western Visayas. |
| **NC** | Negosyo Center | Field offices/centers established in municipalities across Region 6 (e.g., NC Negros Occidental, NC Iloilo, NC Guimaras, NC Capiz, NC Antique, NC Aklan). |
| **Regular Employee** | Permanent DTI Staff | Core staff members assigned to DTI regional or provincial headquarters. |

---

## Technical & Geospatial Concepts

| Term | Definition / Context |
|---|---|
| **Leaflet.js** | Open-source JavaScript map library powering the 3-panel command center and employee disaster tracker dashboards. |
| **Haversine Formula** | Spherical trigonometry formula used in `app/Services/` and client JS to calculate the shortest distance across Earth's surface between employee GPS coordinates and disaster markers. |
| **USGS Earthquake API** | External REST endpoint (`earthquake.usgs.gov`) supplying live earthquake data (M2.5+ within past 3 days). |
| **NASA EONET v3** | Earth Observatory Natural Event Tracker API providing active natural hazards (wildfires, storms, floods). |
| **GeoJSON** | JSON-based geospatial vector format used for static map overlays (Philippine fault lines, active volcanoes). |
| **KML / KMZ** | Keyhole Markup Language files used to render provincial boundaries and office markers (`DTI6 Employees.kml`). |
| **Active Personnel** | Employees who have logged location coordinates within the last 24 hours (refreshed via 30s auto-polling). |
| **Location Reuse** | Feature permitting employees to re-submit past verified coordinates as a new current location log. |

---

## Security & Quality Control Terms

| Term | Definition / Context |
|---|---|
| **VAPT** | Vulnerability Assessment and Penetration Testing. Security evaluation report (`8_VAPT_Report.md`) detailing vulnerabilities, remediations, and compliance checks. |
| **OWASP Top 10** | Standard security risk framework referenced during Security Checker (`05_security-checker`) audits. |
| **CSRF** | Cross-Site Request Forgery protection required on all location submission and profile modification POST/PUT routes. |
| **XSS** | Cross-Site Scripting prevention ensuring coordinates, profile inputs, and popup contents are sanitized before display. |
