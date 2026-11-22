# Test strategy and definition of done
Levels: unit, integration, contract, end-to-end, security, accessibility, performance, disaster recovery, platform-specific acceptance, human-review process QA.
Must test: seller spoofed approval; wrong item ID; duplicate certificate; revoked status with stale cache; expired signature; denied/partial remote evidence; video consent revoked; carrier loss; insurance excluded item; API outage fail closed; reviewer conflict; merchant cross-tenant access; XSS in public notes.
DoD per story: approved design, accessible responsive UI, automated tests, audit events, threat assessment, docs, demo, acceptance by product owner and relevant trust/security leads.
Pilot exit: zero known critical defects, revocation works in each adapter, manual reviewer audit passes, support/incident coverage ready, claims approved by counsel.
