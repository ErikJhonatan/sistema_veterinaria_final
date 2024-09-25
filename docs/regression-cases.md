# Regression cases

Prepared for this change. **Not executed.** Tests, manual checks, lint and builds require explicit user authorization. Use isolated fixtures; never run destructive cases against production.

| Case | Input or setup | Expected outcome |
| --- | --- | --- |
| Destructive routes | GET event/area/bonus/deduction delete URL | 405; data unchanged |
| CSRF | Submit corresponding DELETE form without session CSRF token then with valid token | 419 without token; authorized valid submission reaches controller |
| Attendance | Anonymous GET /Atendance and POST /RRHH/Asistencia/Form | Authentication required |
| References | Submit bonus create/delete and employee evaluation form | References match real controller methods and unique route names |
| Attendance fields | Unknown QR employee; existing employee marks arrival/lunch/departure | Unknown employee rejected; queries use Empleado and formatted time strings |
| PDF aliases | Generate both legacy PDF URL and canonical comprobantes.pdf link | Different route names resolve without collision |
| Home alias | Resolve /home by URL and named route home | One redirect to /dashboard; no competing controller route |
