# Business model and unit economics
**Illustrative pricing hypotheses (not validated):** merchant subscription $49–$499/month; authentication review $75–$395+ per item, depending on category/method. Shipping and insurance are disclosed pass-through or partner charges, not automatically margin.
**Model:** monthly revenue = active merchants × average subscription + completed paid reviews × average review fee + contracted enterprise revenue. Gross contribution = revenue − expert labor − media/storage − payment fees − shipping subsidies − insurance/claims costs − support − certificate infrastructure.
**Example:** 100 merchants × $99 + (100 × 5 reviews × $100) = **$59,900/month**, $718,800 annualized gross run rate, **before costs**. The visual Lean Canvas may show different numbers; use a transparent spreadsheet with assumptions for investment decisions.
**Sensitivity:** vary merchants (25/100/500), reviews per merchant (1/5/10), average fee ($75/$150/$300), expert cost per case, approval rate, disputes and churn. Never assert conversion or fraud reduction percentages without measured evidence.
**Economic impact for merchant:** incremental gross profit from measured conversion/AOV lift − subscription − per-review fees − shipping/insurance − operational overhead. This can be negative; test with controlled cohorts.


## Current scenario implementation register — 2026-11-23

Status: Requirements and acceptance gates; not evidence of production completion.

- [ ] **UNIT_ECONOMICS-01:** Model per submission: API Gateway, Lambda, DynamoDB, S3, SQS, Bedrock and reviewer minutes. Evidence: code location, automated test, staging trace, owner approval.
- [ ] **UNIT_ECONOMICS-02:** Include fraud/dispute overhead, certificate lookup traffic, retention, backups and alerting. Evidence: code location, automated test, staging trace, owner approval.
- [ ] **UNIT_ECONOMICS-03:** Use sensitivity scenarios for low-volume, medium-volume and high-image-count merchants. Evidence: code location, automated test, staging trace, owner approval.
- [ ] **UNIT_ECONOMICS-04:** Merchant segments and differentiated positioning. Evidence: code location, automated test, staging trace, owner approval.
- [ ] **UNIT_ECONOMICS-05:** Platform distribution and conversion funnel. Evidence: code location, automated test, staging trace, owner approval.
- [ ] **UNIT_ECONOMICS-06:** Unit economics and Bedrock inference budget. Evidence: code location, automated test, staging trace, owner approval.
- [ ] **UNIT_ECONOMICS-07:** Reviewer labor, dispute and chargeback costs. Evidence: code location, automated test, staging trace, owner approval.
- [ ] **UNIT_ECONOMICS-08:** Legal claims, insurance and evidence limits. Evidence: code location, automated test, staging trace, owner approval.
- [ ] **UNIT_ECONOMICS-09:** Pilot evidence, pricing and commercial exit gates. Evidence: code location, automated test, staging trace, owner approval.

### Cross-platform release constraints

- Merchant-side apps cannot grant verified status; final decisions remain reviewer-authorized.
- AWS Bedrock image analysis is advisory and is not a validated counterfeit-authenticity classifier.
- Shopify OAuth/compliance webhooks, WooCommerce/Magento retries, tenant isolation, certificate signing, revocation and real-install tests remain release gates unless separately evidenced.
- All platform badges must resolve status against a server-authoritative record and handle pending, rejected, revoked and expired states safely.
