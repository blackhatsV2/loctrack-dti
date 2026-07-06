# Voice & Communication Guide

This document specifies the tone, language style, and formatting rules for all user-facing content, developer documentation, error messages, and stage output reports in the **Workforce Locator** project.

---

## Tone Principles

1. **Clear & Actionable**: Emergency management tools require concise, unambiguous language. Avoid jargon in user-facing alerts.
2. **Professional & Official**: Reflect the dignity of an executive government agency (DTI Region 6) while remaining accessible.
3. **Calm & Reassuring**: In disaster notifications and location status alerts, maintain a factual, clear tone without inducing panic.
4. **Factual & Objective in Code/Docs**: In code reviews, PR reports, and developer logs, state facts directly without dramatic or exaggerated adjectives.

---

## UI & User-Facing Text Guidelines

### Notifications & Alerts
- **Disaster Proximity Alert**:
  - *Do*: "Earthquake (M 4.5) recorded 12.4 km from your reported location."
  - *Don't*: "DANGER! Extreme earthquake detected right near your position!"
- **Location Submission Success**:
  - *Do*: "Location updated successfully at 14:32 PST."
  - *Don't*: "Awesome job! We successfully stored your coords!"
- **Error Messages**:
  - *Do*: "Unable to retrieve current GPS location. Please enable browser location permissions and try again."
  - *Don't*: "Geolocation failed!"

### Admin Dashboard Labels
- Use clear title casing for navigation buttons, table headers, and layer controls (`Employee Layers`, `Live Hazards`, `Active Personnel (24h)`).
- Provide helpful tooltips for map markers and action controls.

---

## Developer & Stage Report Guidelines

### Commit Messages & PR Descriptions
- Concise, technical, and objective format (`feat(map): ...`, `fix(auth): ...`).
- End statements with periods.
- Avoid promotional or hyperbolic terms ("flawless", "perfect", "bulletproof").

### Stage Artifact Reports (ICM Output Files)
- Structure reports with clear Markdown headings, summary tables, and verification checklists.
- State test results and security scan outputs with exact numbers and metrics (e.g. `12 unit tests passed, 0 failures`, `0 HIGH severity VAPT issues remaining`).
