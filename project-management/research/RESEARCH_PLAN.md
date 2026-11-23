# Discovery and validation research
Recruit 12–20 independent luxury merchants across Shopify, WooCommerce and Magento, 6–10 luxury buyers, 4–6 experienced authenticators, and shipping/insurance specialists. Obtain informed consent; do not fabricate interviews.
Questions: current authentication workflow and cost; distrust and returns; willingness to pay per item and monthly; which categories require shipment; remote evidence quality; shipping insurance concerns; badge trust and public record comprehension.
Artifacts: interview notes, anonymized themes, evidence log, opportunity scoring, objections, signed-off insights. Record hypothesis vs observed evidence. Pilot 5–10 merchants and measure true turnaround, quality, gross margin, dispute rate and conversion experiment.


## Current scenario implementation register — 2026-11-23

Status: Requirements and acceptance gates; not evidence of production completion.

- [ ] **RESEARCH_PLAN-01:** Recruit merchants, reviewers and buyers with cross-platform representation. Evidence: code location, automated test, staging trace, owner approval.
- [ ] **RESEARCH_PLAN-02:** Use controlled authentic/counterfeit reference sets only with rights and provenance. Evidence: code location, automated test, staging trace, owner approval.
- [ ] **RESEARCH_PLAN-03:** Pre-register usability and error metrics and avoid using generated labels as ground truth. Evidence: code location, automated test, staging trace, owner approval.
- [ ] **RESEARCH_PLAN-04:** Recruitment across three commerce platforms. Evidence: code location, automated test, staging trace, owner approval.
- [ ] **RESEARCH_PLAN-05:** Product listing and evidence capture usability. Evidence: code location, automated test, staging trace, owner approval.
- [ ] **RESEARCH_PLAN-06:** Reviewer consistency and false-acceptance risk. Evidence: code location, automated test, staging trace, owner approval.
- [ ] **RESEARCH_PLAN-07:** Badge trust and customer comprehension. Evidence: code location, automated test, staging trace, owner approval.
- [ ] **RESEARCH_PLAN-08:** Accessibility and mobile flows. Evidence: code location, automated test, staging trace, owner approval.
- [ ] **RESEARCH_PLAN-09:** Consent, sampling bias and analysis. Evidence: code location, automated test, staging trace, owner approval.

### Cross-platform release constraints

- Merchant-side apps cannot grant verified status; final decisions remain reviewer-authorized.
- AWS Bedrock image analysis is advisory and is not a validated counterfeit-authenticity classifier.
- Shopify OAuth/compliance webhooks, WooCommerce/Magento retries, tenant isolation, certificate signing, revocation and real-install tests remain release gates unless separately evidenced.
- All platform badges must resolve status against a server-authoritative record and handle pending, rejected, revoked and expired states safely.
