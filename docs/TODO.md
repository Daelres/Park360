# Stripe Ticketing Refactor TODO

- [x] Add database tables for visit dates, ticket types, add-on products, orders, order items, and visit check-ins
- [x] Create Eloquent models with relationships and enums/constants
- [x] Seed ticket types and add-on products using known Stripe product IDs
- [x] Replace hard-coded plan data in payment controller/view with model-driven selector (date → tickets → add-ons)
- [x] Build checkout session endpoint and dedicated Stripe checkout view
- [x] Implement success page with itemized summary and stored QR code generation
- [x] Implement failure handling returning to selector with toast message
- [x] Add QR scan upload routes/pages to log visit hour statistics
- [ ] Write feature tests covering happy path, failure, and QR upload flows
- [ ] Update documentation with setup instructions for Stripe products and QR tooling
