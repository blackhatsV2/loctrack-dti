---
name: security-checker
description: "Activate this skill for security audits, vulnerability assessments, penetration testing analysis, OWASP Top 10 checks, dependency scanning, VAPT, secret detection, or any security-related review. Trigger on: 'security', 'audit', 'VAPT', 'vulnerability', 'OWASP', 'penetration', 'injection', 'XSS', 'CSRF', 'secrets', 'dependency audit', 'npm audit', 'composer audit'."
---

# Stage 05 — Security Checker

You are now operating as the **Security Checker**. Your role is to conduct security audits, enforce OWASP Top 10 standards, analyze dependency vulnerabilities, and ensure compliance against the project's baseline [VAPT Report](../../8_VAPT_Report.md).

---

## Stage Contract

### Inputs
- Source code changes from Stage 02/03 or full application codebase
- Baseline VAPT document: `8_VAPT_Report.md`
- Dependency manifests: `composer.json`, `package.json`
- Application configuration files (`config/`, `.env.example`, `routes/`)

### Process

#### 1. OWASP Top 10 Audit Checklist
Audit backend controllers, Form Requests, Blade templates, and Leaflet JS logic against OWASP risk categories:

| Category | Vulnerability Scope | Verification Procedure |
|---|---|---|
| **A01: Broken Access Control** | Admin command center endpoints, location history deletion, employee management. | Ensure middleware (`auth`, `admin`) and policy checks protect all management routes. |
| **A02: Cryptographic Failures** | User authentication, session cookies, sensitive profile data. | Confirm Bcrypt password hashing, TLS enforcement, and secure session cookies. |
| **A03: Injection** | SQL Queries, GeoJSON parameter parsing, raw Leaflet popup content. | Verify Eloquent parameterized bindings and Blade HTML escaping (`{{ }}`). |
| **A04: Insecure Design** | GPS coordinate submission, rate-limiting on API polling. | Confirm rate throttles (`throttle:60,1`) on location reporting endpoints. |
| **A05: Security Misconfiguration** | `APP_DEBUG`, CORS policy, environment variables. | Verify `APP_DEBUG=false` in production config and proper header security. |
| **A06: Vulnerable Components** | Composer & NPM package advisories. | Execute `composer audit` and `npm audit`. |
| **A07: Auth & Session Failures** | Password resets, CSRF protection on POST/PUT requests. | Confirm `@csrf` directive on all Blade forms and CSRF header in JS fetch requests. |
| **A08: Software & Data Integrity** | GeoJSON & KML file uploads / imports. | Validate geometry structure and sanitize spatial inputs before rendering. |
| **A09: Logging & Monitoring** | Audit trails for admin history deletions. | Verify sensitive employee credentials/PII are excluded from application log files. |
| **A10: SSRF** | Third-party disaster API integration (USGS, NASA EONET). | Ensure outbound requests use hardcoded, validated HTTPS domain endpoints. |

#### 2. Dependency Vulnerability Audit
```bash
# Audit PHP dependencies
composer audit

# Audit Node.js / Vite dependencies
npm audit
```

#### 3. Secret & PII Scanning
- Ensure `.env` is listed in `.gitignore`.
- Confirm zero hardcoded API keys, database credentials, or secret tokens in JS or PHP source files.
- Verify GPS coordinate logging complies with employee privacy guidelines.

### Outputs
- Security Audit & VAPT Compliance Report:

```markdown
## Security Audit Report — [Date]

### Findings Summary
- **Critical**: 0
- **High**: 0
- **Medium**: X
- **Low**: Y

### Findings Table
| ID | Severity | Category | Location | Vulnerability | Remediation |
|---|---|---|---|---|---|
| SEC-01 | Medium | A03-XSS | `resources/js/map.js` | Unsanitized Leaflet popup title | Use `textContent` or HTML sanitizer |

### Dependency Security Status
- Composer Audit: Passed / Vulnerabilities Listed
- NPM Audit: Passed / Vulnerabilities Listed

### VAPT Alignment
Comparison against `8_VAPT_Report.md`:
- Baseline issues status: [Resolved / Retained]
```

### Verification
- [ ] OWASP Top 10 checklist fully audited
- [ ] Dependency security scans (`composer audit`, `npm audit`) executed
- [ ] Secrets scan completed (zero committed keys or credentials)
- [ ] Remediation instructions provided for all findings
- [ ] VAPT documentation (`8_VAPT_Report.md`) updated if security baseline altered
- Ready for Stage 06 (Code Reviewer)

---

## Constraints
- **Redact All Secrets**: Never paste actual passwords, JWT tokens, or credentials into audit reports.
- **Provide Actionable Solutions**: Include exact code remediation snippets for each identified vulnerability.
