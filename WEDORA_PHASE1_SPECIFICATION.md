# WEDORA — Phase 1 (Foundation) Technical Architecture & Database Specification
**Document Version:** 1.0  
**Author:** Apex (Tech Lead & Solutions Architect, Vertex Web Solution)  
**Target Implementer:** Forge (Senior Backend Developer)  
**Reviewed By:** Sanka (Chief of Staff)  
**Date:** November 2026  
**Baseline Stack:** Laravel 12 (PHP 8.2+), MySQL 8.0+, Tailwind CSS, Alpine.js, Blade  

---

## 1. Executive Summary & Architecture Blueprint

### 1.1 Architectural Paradigm: Laravel Modular Monolith
Wedora is designed as a **Modular Monolith** using Laravel 12. All business domains reside in a single codebase and execute against a unified relational MySQL database, structured strictly by business capability into Domain packages under `app/Domains/`.

- **Domain Encapsulation:** Eliminates cross-boundary model entanglement.
- **ACID Guarantees:** Ensures financial calculations, bookings, and quotation conversions happen in atomic database transactions without distributed latency.
- **Extensibility:** Pre-structured for future extraction into independent microservices if vendor marketplace traffic demands it.

### 1.2 Multi-Tenancy & Workspace Isolation Model
- **Tenant Boundary:** The `weddings` entity forms the root multi-tenant boundary for couple workspaces.
- **Row-Level Tenancy Scoping:** Tenant entities store `wedding_id` (foreign key).
- **Context Resolution:** `EnsureWeddingContext` middleware resolves active workspace via route `{wedding:uuid}` or session.
- **Automated Scoping:** Models leverage `BelongsToWedding` trait and `WeddingScope` to ensure tenant data isolation across all queries and model creations.
- **Vendor Isolation:** Vendors are strictly isolated via `user_id` and assigned inquiries/quotations/bookings.
- **Role-Based Access Control (RBAC):** Governed by Laravel Policies and Gates (`super_admin`, `couple`, `vendor`, `planner`).

### 1.3 Key Technical Conventions
- **Dual Identifier Strategy:** Internal `id` (BIGINT UNSIGNED AUTO_INCREMENT) for optimal B-Tree index performance and foreign keys; public `uuid` (CHAR(36) UNIQUE) for route-model binding and external API contracts to eliminate IDOR enumeration vulnerabilities.
- **Financial Accuracy:** All financial values (`planned_amount`, `amount`, `total_amount`, `unit_price`, `balance_amount`) strictly use `DECIMAL(12, 2)`. Float types are strictly prohibited.
- **Timezone Handling:** Stored in UTC (`TIMESTAMP`). Display and scheduling default to `Asia/Colombo` (Sri Lanka, UTC+05:30).
- **Audit & Delete Integrity:** Financial (`payments`, `expenses`, `budgets`) and legal records (`bookings`, `audit_logs`) enforce `ON DELETE RESTRICT`. Ephemeral items (`quotation_items`, `timeline_events`) use `ON DELETE CASCADE`.

---

## 2. Complete Phase 1 Database Schema (MySQL 8+)

### 2.1 Core Identity, Users & Workspaces
#### 1. `users`
- `id` BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY
- `uuid` CHAR(36) NOT NULL UNIQUE
- `name` VARCHAR(255) NOT NULL
- `email` VARCHAR(255) NOT NULL UNIQUE
- `email_verified_at` TIMESTAMP NULL
- `password` VARCHAR(255) NOT NULL
- `phone` VARCHAR(30) NULL
- `role` ENUM('super_admin', 'couple', 'vendor', 'planner') NOT NULL DEFAULT 'couple'
- `status` ENUM('active', 'inactive', 'suspended') NOT NULL DEFAULT 'active'
- `remember_token` VARCHAR(100) NULL
- `created_at` TIMESTAMP NULL, `updated_at` TIMESTAMP NULL, `deleted_at` TIMESTAMP NULL
- *Indexes:* `(role, status)`, `email`

#### 2. `user_profiles`
- `id` BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY
- `user_id` BIGINT UNSIGNED NOT NULL UNIQUE (FK -> `users.id` ON DELETE CASCADE)
- `partner_name` VARCHAR(255) NULL
- `avatar_url` VARCHAR(2048) NULL
- `preferred_locale` VARCHAR(10) NOT NULL DEFAULT 'en'
- `notification_preferences` JSON NULL
- `created_at` TIMESTAMP NULL, `updated_at` TIMESTAMP NULL

#### 3. `weddings` (Workspace Entity)
- `id` BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY
- `uuid` CHAR(36) NOT NULL UNIQUE
- `owner_id` BIGINT UNSIGNED NOT NULL (FK -> `users.id` ON DELETE RESTRICT)
- `title` VARCHAR(255) NOT NULL
- `partner1_name` VARCHAR(255) NOT NULL
- `partner2_name` VARCHAR(255) NOT NULL
- `wedding_date` DATE NOT NULL
- `wedding_type` ENUM('traditional', 'western', 'homecoming', 'reception', 'hindu', 'muslim', 'other') NOT NULL DEFAULT 'traditional'
- `location` VARCHAR(255) NULL
- `district` VARCHAR(50) NOT NULL COMMENT 'Sri Lankan District: Colombo, Kandy, Galle, etc.'
- `estimated_guest_count` INT UNSIGNED NOT NULL DEFAULT 100
- `total_budget` DECIMAL(12, 2) NOT NULL DEFAULT 0.00
- `currency` CHAR(3) NOT NULL DEFAULT 'LKR'
- `style_theme` VARCHAR(100) NULL
- `status` ENUM('planning', 'completed', 'archived') NOT NULL DEFAULT 'planning'
- `created_at` TIMESTAMP NULL, `updated_at` TIMESTAMP NULL, `deleted_at` TIMESTAMP NULL
- *Indexes:* `owner_id`, `(wedding_date, status)`, `district`

#### 4. `wedding_members`
- `id` BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY
- `wedding_id` BIGINT UNSIGNED NOT NULL (FK -> `weddings.id` ON DELETE CASCADE)
- `user_id` BIGINT UNSIGNED NOT NULL (FK -> `users.id` ON DELETE CASCADE)
- `role` ENUM('owner', 'partner', 'collaborator', 'planner') NOT NULL DEFAULT 'partner'
- `invitation_status` ENUM('pending', 'accepted', 'declined') NOT NULL DEFAULT 'pending'
- `permissions` JSON NULL
- `joined_at` TIMESTAMP NULL
- `created_at` TIMESTAMP NULL, `updated_at` TIMESTAMP NULL
- *Unique:* `(wedding_id, user_id)`
- *Index:* `(user_id, role)`

#### 5. `wedding_invitations`
- `id` BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY
- `uuid` CHAR(36) NOT NULL UNIQUE
- `wedding_id` BIGINT UNSIGNED NOT NULL (FK -> `weddings.id` ON DELETE CASCADE)
- `invited_by_user_id` BIGINT UNSIGNED NOT NULL (FK -> `users.id` ON DELETE CASCADE)
- `email` VARCHAR(255) NOT NULL
- `role` ENUM('partner', 'collaborator') NOT NULL DEFAULT 'partner'
- `token` CHAR(64) NOT NULL UNIQUE
- `status` ENUM('pending', 'accepted', 'expired', 'revoked') NOT NULL DEFAULT 'pending'
- `expires_at` TIMESTAMP NOT NULL
- `created_at` TIMESTAMP NULL, `updated_at` TIMESTAMP NULL
- *Indexes:* `(email, status)`, `token`

#### 6. `wedding_settings`
- `id` BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY
- `wedding_id` BIGINT UNSIGNED NOT NULL UNIQUE (FK -> `weddings.id` ON DELETE CASCADE)
- `timezone` VARCHAR(50) NOT NULL DEFAULT 'Asia/Colombo'
- `currency` CHAR(3) NOT NULL DEFAULT 'LKR'
- `budget_alert_threshold_pct` TINYINT UNSIGNED NOT NULL DEFAULT 90
- `is_public_rsvp_enabled` BOOLEAN NOT NULL DEFAULT FALSE
- `notification_email_on_task_due` BOOLEAN NOT NULL DEFAULT TRUE
- `created_at` TIMESTAMP NULL, `updated_at` TIMESTAMP NULL

### 2.2 Planning, Checklist & Timeline
#### 7. `task_categories`
- `id` BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY
- `uuid` CHAR(36) NOT NULL UNIQUE
- `wedding_id` BIGINT UNSIGNED NULL (FK -> `weddings.id` ON DELETE CASCADE, NULL = System preset)
- `name` VARCHAR(100) NOT NULL
- `slug` VARCHAR(100) NOT NULL
- `icon` VARCHAR(100) NULL
- `sort_order` INT UNSIGNED NOT NULL DEFAULT 0
- `is_default` BOOLEAN NOT NULL DEFAULT FALSE
- `created_at` TIMESTAMP NULL, `updated_at` TIMESTAMP NULL
- *Index:* `(wedding_id, sort_order)`

#### 8. `tasks`
- `id` BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY
- `uuid` CHAR(36) NOT NULL UNIQUE
- `wedding_id` BIGINT UNSIGNED NOT NULL (FK -> `weddings.id` ON DELETE CASCADE)
- `category_id` BIGINT UNSIGNED NULL (FK -> `task_categories.id` ON DELETE SET NULL)
- `assigned_to_user_id` BIGINT UNSIGNED NULL (FK -> `users.id` ON DELETE SET NULL)
- `title` VARCHAR(255) NOT NULL
- `description` TEXT NULL
- `due_date` DATE NULL
- `priority` ENUM('low', 'medium', 'high', 'urgent') NOT NULL DEFAULT 'medium'
- `status` ENUM('pending', 'in_progress', 'completed', 'cancelled') NOT NULL DEFAULT 'pending'
- `sort_order` INT UNSIGNED NOT NULL DEFAULT 0
- `completed_at` TIMESTAMP NULL
- `completed_by_user_id` BIGINT UNSIGNED NULL (FK -> `users.id` ON DELETE SET NULL)
- `created_at` TIMESTAMP NULL, `updated_at` TIMESTAMP NULL, `deleted_at` TIMESTAMP NULL
- *Indexes:* `(wedding_id, status)`, `(wedding_id, due_date)`, `(wedding_id, category_id)`, `(assigned_to_user_id, status)`

#### 9. `timeline_events`
- `id` BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY
- `uuid` CHAR(36) NOT NULL UNIQUE
- `wedding_id` BIGINT UNSIGNED NOT NULL (FK -> `weddings.id` ON DELETE CASCADE)
- `title` VARCHAR(255) NOT NULL
- `description` TEXT NULL
- `event_date` DATE NOT NULL
- `start_time` TIME NOT NULL
- `end_time` TIME NULL
- `location` VARCHAR(255) NULL
- `sort_order` INT UNSIGNED NOT NULL DEFAULT 0
- `created_at` TIMESTAMP NULL, `updated_at` TIMESTAMP NULL
- *Index:* `(wedding_id, event_date, start_time)`

#### 10. `checklist_templates`
- `id` BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY
- `name` VARCHAR(100) NOT NULL
- `wedding_type` ENUM('traditional', 'western', 'homecoming', 'reception', 'all') NOT NULL DEFAULT 'all'
- `description` VARCHAR(255) NULL
- `is_active` BOOLEAN NOT NULL DEFAULT TRUE
- `created_at` TIMESTAMP NULL, `updated_at` TIMESTAMP NULL

#### 11. `checklist_template_items`
- `id` BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY
- `checklist_template_id` BIGINT UNSIGNED NOT NULL (FK -> `checklist_templates.id` ON DELETE CASCADE)
- `category_name` VARCHAR(100) NOT NULL
- `title` VARCHAR(255) NOT NULL
- `description` TEXT NULL
- `suggested_due_offset_days` INT NOT NULL COMMENT 'Negative values indicate days before wedding date'
- `priority` ENUM('low', 'medium', 'high', 'urgent') NOT NULL DEFAULT 'medium'
- `sort_order` INT UNSIGNED NOT NULL DEFAULT 0
- `created_at` TIMESTAMP NULL, `updated_at` TIMESTAMP NULL

### 2.3 Budget, Expenses & Payments
#### 12. `budgets` (Category Allocations)
- `id` BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY
- `uuid` CHAR(36) NOT NULL UNIQUE
- `wedding_id` BIGINT UNSIGNED NOT NULL (FK -> `weddings.id` ON DELETE CASCADE)
- `category_name` VARCHAR(100) NOT NULL
- `planned_amount` DECIMAL(12, 2) NOT NULL DEFAULT 0.00
- `notes` TEXT NULL
- `sort_order` INT UNSIGNED NOT NULL DEFAULT 0
- `created_at` TIMESTAMP NULL, `updated_at` TIMESTAMP NULL
- *Index:* `wedding_id`

#### 13. `expenses`
- `id` BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY
- `uuid` CHAR(36) NOT NULL UNIQUE
- `wedding_id` BIGINT UNSIGNED NOT NULL (FK -> `weddings.id` ON DELETE RESTRICT)
- `budget_id` BIGINT UNSIGNED NOT NULL (FK -> `budgets.id` ON DELETE RESTRICT)
- `vendor_id` BIGINT UNSIGNED NULL
- `booking_id` BIGINT UNSIGNED NULL
- `title` VARCHAR(255) NOT NULL
- `amount` DECIMAL(12, 2) NOT NULL
- `expense_date` DATE NOT NULL
- `payment_status` ENUM('unpaid', 'partially_paid', 'paid') NOT NULL DEFAULT 'unpaid'
- `notes` TEXT NULL
- `receipt_url` VARCHAR(2048) NULL
- `created_at` TIMESTAMP NULL, `updated_at` TIMESTAMP NULL, `deleted_at` TIMESTAMP NULL
- *Indexes:* `(wedding_id, budget_id)`, `(wedding_id, payment_status)`, `(wedding_id, expense_date)`

#### 14. `payments`
- `id` BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY
- `uuid` CHAR(36) NOT NULL UNIQUE
- `wedding_id` BIGINT UNSIGNED NOT NULL (FK -> `weddings.id` ON DELETE RESTRICT)
- `expense_id` BIGINT UNSIGNED NULL (FK -> `expenses.id` ON DELETE RESTRICT)
- `booking_id` BIGINT UNSIGNED NULL
- `recorded_by_user_id` BIGINT UNSIGNED NOT NULL (FK -> `users.id` ON DELETE RESTRICT)
- `amount` DECIMAL(12, 2) NOT NULL
- `payment_method` ENUM('cash', 'bank_transfer', 'credit_card', 'online_slip', 'cheque', 'other') NOT NULL DEFAULT 'bank_transfer'
- `payment_date` DATE NOT NULL
- `reference_number` VARCHAR(100) NULL
- `receipt_url` VARCHAR(2048) NULL
- `notes` TEXT NULL
- `created_at` TIMESTAMP NULL, `updated_at` TIMESTAMP NULL
- *Indexes:* `(wedding_id, expense_id)`, `(wedding_id, payment_date)`

### 2.4 Guest Management & RSVP
#### 15. `guest_groups`
- `id` BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY
- `uuid` CHAR(36) NOT NULL UNIQUE
- `wedding_id` BIGINT UNSIGNED NOT NULL (FK -> `weddings.id` ON DELETE CASCADE)
- `name` VARCHAR(100) NOT NULL
- `created_at` TIMESTAMP NULL, `updated_at` TIMESTAMP NULL
- *Index:* `wedding_id`

#### 16. `guests`
- `id` BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY
- `uuid` CHAR(36) NOT NULL UNIQUE
- `wedding_id` BIGINT UNSIGNED NOT NULL (FK -> `weddings.id` ON DELETE CASCADE)
- `guest_group_id` BIGINT UNSIGNED NULL (FK -> `guest_groups.id` ON DELETE SET NULL)
- `first_name` VARCHAR(100) NOT NULL
- `last_name` VARCHAR(100) NULL
- `email` VARCHAR(255) NULL
- `phone` VARCHAR(30) NULL
- `address` VARCHAR(255) NULL
- `invitation_status` ENUM('not_sent', 'sent', 'delivered', 'failed') NOT NULL DEFAULT 'not_sent'
- `rsvp_status` ENUM('pending', 'attending', 'declined', 'tentative') NOT NULL DEFAULT 'pending'
- `invited_count` SMALLINT UNSIGNED NOT NULL DEFAULT 1
- `attending_count` SMALLINT UNSIGNED NOT NULL DEFAULT 0
- `dietary_requirements` TEXT NULL
- `table_assignment` VARCHAR(50) NULL
- `notes` TEXT NULL
- `rsvp_token` CHAR(64) NULL UNIQUE
- `rsvp_responded_at` TIMESTAMP NULL
- `created_at` TIMESTAMP NULL, `updated_at` TIMESTAMP NULL, `deleted_at` TIMESTAMP NULL
- *Indexes:* `(wedding_id, rsvp_status)`, `(wedding_id, guest_group_id)`, `rsvp_token`, `email`

### 2.5 Marketplace Vendors, Packages, Quotations & Bookings
#### 17. `vendor_categories`
- `id` BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY
- `uuid` CHAR(36) NOT NULL UNIQUE
- `parent_id` BIGINT UNSIGNED NULL (FK -> `vendor_categories.id` ON DELETE SET NULL)
- `name` VARCHAR(100) NOT NULL
- `slug` VARCHAR(100) NOT NULL UNIQUE
- `description` TEXT NULL
- `icon_url` VARCHAR(2048) NULL
- `is_active` BOOLEAN NOT NULL DEFAULT TRUE
- `sort_order` INT UNSIGNED NOT NULL DEFAULT 0
- `created_at` TIMESTAMP NULL, `updated_at` TIMESTAMP NULL
- *Index:* `(is_active, sort_order)`

#### 18. `vendors`
- `id` BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY
- `uuid` CHAR(36) NOT NULL UNIQUE
- `user_id` BIGINT UNSIGNED NOT NULL UNIQUE (FK -> `users.id` ON DELETE RESTRICT)
- `category_id` BIGINT UNSIGNED NOT NULL (FK -> `vendor_categories.id` ON DELETE RESTRICT)
- `business_name` VARCHAR(255) NOT NULL
- `slug` VARCHAR(255) NOT NULL UNIQUE
- `description` TEXT NOT NULL
- `district` VARCHAR(50) NOT NULL
- `address` VARCHAR(255) NOT NULL
- `phone` VARCHAR(30) NOT NULL
- `email` VARCHAR(255) NOT NULL
- `website` VARCHAR(255) NULL
- `instagram_handle` VARCHAR(100) NULL
- `facebook_url` VARCHAR(255) NULL
- `starting_price` DECIMAL(12, 2) NULL
- `currency` CHAR(3) NOT NULL DEFAULT 'LKR'
- `verification_status` ENUM('unverified', 'pending', 'verified', 'rejected') NOT NULL DEFAULT 'unverified'
- `is_active` BOOLEAN NOT NULL DEFAULT TRUE
- `is_featured` BOOLEAN NOT NULL DEFAULT FALSE
- `rating_avg` DECIMAL(3, 2) NOT NULL DEFAULT 0.00
- `reviews_count` INT UNSIGNED NOT NULL DEFAULT 0
- `created_at` TIMESTAMP NULL, `updated_at` TIMESTAMP NULL, `deleted_at` TIMESTAMP NULL
- *Indexes:* `(category_id, district, is_active)`, `(verification_status, is_active)`, `(is_featured, is_active)`, Fulltext `(business_name, description)`

#### 19. `vendor_packages`
- `id` BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY
- `uuid` CHAR(36) NOT NULL UNIQUE
- `vendor_id` BIGINT UNSIGNED NOT NULL (FK -> `vendors.id` ON DELETE CASCADE)
- `name` VARCHAR(255) NOT NULL
- `description` TEXT NOT NULL
- `price` DECIMAL(12, 2) NOT NULL
- `currency` CHAR(3) NOT NULL DEFAULT 'LKR'
- `duration_hours` DECIMAL(4, 1) NULL
- `features` JSON NULL
- `is_active` BOOLEAN NOT NULL DEFAULT TRUE
- `sort_order` INT UNSIGNED NOT NULL DEFAULT 0
- `created_at` TIMESTAMP NULL, `updated_at` TIMESTAMP NULL
- *Index:* `(vendor_id, is_active, sort_order)`

#### 20. `vendor_media`
- `id` BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY
- `uuid` CHAR(36) NOT NULL UNIQUE
- `vendor_id` BIGINT UNSIGNED NOT NULL (FK -> `vendors.id` ON DELETE CASCADE)
- `file_path` VARCHAR(2048) NOT NULL
- `media_type` ENUM('image', 'video') NOT NULL DEFAULT 'image'
- `caption` VARCHAR(255) NULL
- `is_cover` BOOLEAN NOT NULL DEFAULT FALSE
- `sort_order` INT UNSIGNED NOT NULL DEFAULT 0
- `created_at` TIMESTAMP NULL, `updated_at` TIMESTAMP NULL
- *Index:* `(vendor_id, sort_order)`

#### 21. `favorites`
- `id` BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY
- `user_id` BIGINT UNSIGNED NOT NULL (FK -> `users.id` ON DELETE CASCADE)
- `vendor_id` BIGINT UNSIGNED NOT NULL (FK -> `vendors.id` ON DELETE CASCADE)
- `created_at` TIMESTAMP NULL, `updated_at` TIMESTAMP NULL
- *Unique:* `(user_id, vendor_id)`

#### 22. `quotations`
- `id` BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY
- `uuid` CHAR(36) NOT NULL UNIQUE
- `wedding_id` BIGINT UNSIGNED NOT NULL (FK -> `weddings.id` ON DELETE RESTRICT)
- `vendor_id` BIGINT UNSIGNED NOT NULL (FK -> `vendors.id` ON DELETE RESTRICT)
- `package_id` BIGINT UNSIGNED NULL (FK -> `vendor_packages.id` ON DELETE SET NULL)
- `requested_by_user_id` BIGINT UNSIGNED NOT NULL (FK -> `users.id` ON DELETE RESTRICT)
- `event_date` DATE NOT NULL
- `guest_count` INT UNSIGNED NULL
- `venue_location` VARCHAR(255) NULL
- `couple_message` TEXT NOT NULL
- `vendor_response_message` TEXT NULL
- `valid_until` DATE NULL
- `total_amount` DECIMAL(12, 2) NOT NULL DEFAULT 0.00
- `currency` CHAR(3) NOT NULL DEFAULT 'LKR'
- `status` ENUM('pending', 'responded', 'accepted', 'rejected', 'expired') NOT NULL DEFAULT 'pending'
- `responded_at` TIMESTAMP NULL, `accepted_at` TIMESTAMP NULL
- `created_at` TIMESTAMP NULL, `updated_at` TIMESTAMP NULL
- *Indexes:* `(wedding_id, status)`, `(vendor_id, status)`, `event_date`

#### 23. `quotation_items`
- `id` BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY
- `quotation_id` BIGINT UNSIGNED NOT NULL (FK -> `quotations.id` ON DELETE CASCADE)
- `description` VARCHAR(255) NOT NULL
- `quantity` SMALLINT UNSIGNED NOT NULL DEFAULT 1
- `unit_price` DECIMAL(12, 2) NOT NULL
- `total_price` DECIMAL(12, 2) NOT NULL
- `sort_order` INT UNSIGNED NOT NULL DEFAULT 0
- `created_at` TIMESTAMP NULL, `updated_at` TIMESTAMP NULL

#### 24. `bookings`
- `id` BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY
- `uuid` CHAR(36) NOT NULL UNIQUE
- `wedding_id` BIGINT UNSIGNED NOT NULL (FK -> `weddings.id` ON DELETE RESTRICT)
- `vendor_id` BIGINT UNSIGNED NOT NULL (FK -> `vendors.id` ON DELETE RESTRICT)
- `quotation_id` BIGINT UNSIGNED NULL (FK -> `quotations.id` ON DELETE SET NULL)
- `package_id` BIGINT UNSIGNED NULL (FK -> `vendor_packages.id` ON DELETE SET NULL)
- `event_date` DATE NOT NULL
- `total_amount` DECIMAL(12, 2) NOT NULL
- `advance_amount` DECIMAL(12, 2) NOT NULL DEFAULT 0.00
- `balance_amount` DECIMAL(12, 2) NOT NULL DEFAULT 0.00
- `currency` CHAR(3) NOT NULL DEFAULT 'LKR'
- `status` ENUM('pending_confirmation', 'confirmed', 'completed', 'cancelled') NOT NULL DEFAULT 'pending_confirmation'
- `cancellation_reason` TEXT NULL
- `cancelled_by_user_id` BIGINT UNSIGNED NULL (FK -> `users.id` ON DELETE RESTRICT)
- `notes` TEXT NULL
- `confirmed_at` TIMESTAMP NULL, `completed_at` TIMESTAMP NULL
- `created_at` TIMESTAMP NULL, `updated_at` TIMESTAMP NULL
- *Indexes:* `(wedding_id, status)`, `(vendor_id, status)`, `event_date`

#### 25. `reviews`
- `id` BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY
- `uuid` CHAR(36) NOT NULL UNIQUE
- `booking_id` BIGINT UNSIGNED NOT NULL UNIQUE (FK -> `bookings.id` ON DELETE RESTRICT)
- `wedding_id` BIGINT UNSIGNED NOT NULL (FK -> `weddings.id` ON DELETE RESTRICT)
- `vendor_id` BIGINT UNSIGNED NOT NULL (FK -> `vendors.id` ON DELETE RESTRICT)
- `user_id` BIGINT UNSIGNED NOT NULL (FK -> `users.id` ON DELETE RESTRICT)
- `rating` TINYINT UNSIGNED NOT NULL COMMENT '1 to 5 stars'
- `comment` TEXT NOT NULL
- `status` ENUM('pending_moderation', 'approved', 'rejected') NOT NULL DEFAULT 'pending_moderation'
- `created_at` TIMESTAMP NULL, `updated_at` TIMESTAMP NULL
- *Index:* `(vendor_id, status)`

### 2.6 Communication, Subscriptions & Platform Infrastructure
#### 26. `conversations`
- `id` BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY
- `uuid` CHAR(36) NOT NULL UNIQUE
- `wedding_id` BIGINT UNSIGNED NULL (FK -> `weddings.id` ON DELETE CASCADE)
- `quotation_id` BIGINT UNSIGNED NULL (FK -> `quotations.id` ON DELETE SET NULL)
- `booking_id` BIGINT UNSIGNED NULL (FK -> `bookings.id` ON DELETE SET NULL)
- `type` ENUM('couple_vendor', 'couple_support', 'vendor_support') NOT NULL DEFAULT 'couple_vendor'
- `title` VARCHAR(255) NULL
- `created_at` TIMESTAMP NULL, `updated_at` TIMESTAMP NULL

#### 27. `conversation_members`
- `id` BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY
- `conversation_id` BIGINT UNSIGNED NOT NULL (FK -> `conversations.id` ON DELETE CASCADE)
- `user_id` BIGINT UNSIGNED NOT NULL (FK -> `users.id` ON DELETE CASCADE)
- `last_read_at` TIMESTAMP NULL
- `created_at` TIMESTAMP NULL, `updated_at` TIMESTAMP NULL
- *Unique:* `(conversation_id, user_id)`

#### 28. `messages`
- `id` BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY
- `uuid` CHAR(36) NOT NULL UNIQUE
- `conversation_id` BIGINT UNSIGNED NOT NULL (FK -> `conversations.id` ON DELETE CASCADE)
- `sender_id` BIGINT UNSIGNED NOT NULL (FK -> `users.id` ON DELETE RESTRICT)
- `body` TEXT NOT NULL
- `attachments` JSON NULL
- `is_read` BOOLEAN NOT NULL DEFAULT FALSE
- `created_at` TIMESTAMP NULL, `updated_at` TIMESTAMP NULL
- *Index:* `(conversation_id, created_at)`

#### 29. `notifications`
- `id` CHAR(36) NOT NULL PRIMARY KEY
- `type` VARCHAR(255) NOT NULL
- `notifiable_type` VARCHAR(255) NOT NULL
- `notifiable_id` BIGINT UNSIGNED NOT NULL
- `data` TEXT NOT NULL
- `read_at` TIMESTAMP NULL
- `created_at` TIMESTAMP NULL, `updated_at` TIMESTAMP NULL
- *Index:* `(notifiable_type, notifiable_id)`

#### 30. `subscription_plans`
- `id` BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY
- `uuid` CHAR(36) NOT NULL UNIQUE
- `name` VARCHAR(100) NOT NULL
- `slug` VARCHAR(100) NOT NULL UNIQUE
- `target_type` ENUM('vendor', 'planner') NOT NULL DEFAULT 'vendor'
- `billing_interval` ENUM('monthly', 'yearly') NOT NULL DEFAULT 'monthly'
- `price` DECIMAL(10, 2) NOT NULL DEFAULT 0.00
- `currency` CHAR(3) NOT NULL DEFAULT 'LKR'
- `features` JSON NULL
- `max_packages` INT UNSIGNED NOT NULL DEFAULT 3
- `max_portfolio_images` INT UNSIGNED NOT NULL DEFAULT 10
- `is_featured_badge` BOOLEAN NOT NULL DEFAULT FALSE
- `is_active` BOOLEAN NOT NULL DEFAULT TRUE
- `sort_order` INT UNSIGNED NOT NULL DEFAULT 0
- `created_at` TIMESTAMP NULL, `updated_at` TIMESTAMP NULL

#### 31. `subscriptions`
- `id` BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY
- `uuid` CHAR(36) NOT NULL UNIQUE
- `user_id` BIGINT UNSIGNED NOT NULL (FK -> `users.id` ON DELETE CASCADE)
- `vendor_id` BIGINT UNSIGNED NULL (FK -> `vendors.id` ON DELETE CASCADE)
- `plan_id` BIGINT UNSIGNED NOT NULL (FK -> `subscription_plans.id` ON DELETE RESTRICT)
- `status` ENUM('trial', 'active', 'past_due', 'cancelled', 'expired') NOT NULL DEFAULT 'active'
- `starts_at` TIMESTAMP NOT NULL, `ends_at` TIMESTAMP NULL
- `trial_ends_at` TIMESTAMP NULL, `cancelled_at` TIMESTAMP NULL
- `payment_method` VARCHAR(50) NULL
- `created_at` TIMESTAMP NULL, `updated_at` TIMESTAMP NULL
- *Index:* `(status, ends_at)`

#### 32. `audit_logs`
- `id` BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY
- `actor_id` BIGINT UNSIGNED NULL (FK -> `users.id` ON DELETE SET NULL)
- `wedding_id` BIGINT UNSIGNED NULL
- `ip_address` VARCHAR(45) NULL
- `user_agent` TEXT NULL
- `action` VARCHAR(100) NOT NULL
- `auditable_type` VARCHAR(255) NOT NULL
- `auditable_id` BIGINT UNSIGNED NOT NULL
- `old_values` JSON NULL, `new_values` JSON NULL
- `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
- *Indexes:* `wedding_id`, `(auditable_type, auditable_id)`, `(action, created_at)`

#### 33. `settings`
- `id` BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY
- `key` VARCHAR(100) NOT NULL UNIQUE
- `value` TEXT NULL
- `type` ENUM('string', 'integer', 'boolean', 'json') NOT NULL DEFAULT 'string'
- `group` VARCHAR(50) NOT NULL DEFAULT 'general'
- `is_public` BOOLEAN NOT NULL DEFAULT FALSE
- `created_at` TIMESTAMP NULL, `updated_at` TIMESTAMP NULL

---

## 3. Laravel Modular Monolith Architecture Blueprint

### 3.1 Domain-Driven Directory Layout (`app/Domains/`)
```text
app/
├── Domains/
│   ├── Identity/         # Users, Profiles, Authentication, RBAC
│   ├── Wedding/          # Weddings, Members, Invitations, Settings, Scope
│   ├── Planning/         # Tasks, Categories, Timelines, Checklists
│   ├── Budget/           # Budgets, Expenses, Manual Payments, Summaries
│   ├── Guest/            # Guests, Groups, RSVP, CSV import/export
│   ├── Marketplace/      # Vendors, Categories, Packages, Media, Favorites
│   ├── Booking/          # RFQs, Quotations, Items, Bookings, Reviews
│   ├── Communication/    # Conversations, Members, Messages, Notifications
│   └── Platform/         # Subscriptions, Audit Logs, Settings
├── Http/
│   ├── Controllers/      # Thin controllers (Couple/, Vendor/, Admin/, Public/)
│   ├── Middleware/       # EnsureWeddingContext, EnsureVendorContext, EnsureSuperAdmin
│   └── Requests/         # Form validation requests
```

### 3.2 Workspace Data Isolation Pattern
```php
// 1. CurrentWeddingManager (Request Singleton)
namespace App\Domains\Wedding\Services;
use App\Domains\Wedding\Models\Wedding;
class CurrentWeddingManager {
    protected ?Wedding $wedding = null;
    public function set(Wedding $wedding): void { $this->wedding = $wedding; }
    public function get(): ?Wedding { return $this->wedding; }
    public function getId(): ?int { return $this->wedding?->id; }
    public function hasWedding(): bool { return $this->wedding !== null; }
}

// 2. WeddingScope (Global Eloquent Scope)
namespace App\Domains\Wedding\Scopes;
use App\Domains\Wedding\Services\CurrentWeddingManager;
use Illuminate\Database\Eloquent\{Builder, Model, Scope};
class WeddingScope implements Scope {
    public function apply(Builder $builder, Model $model): void {
        $manager = app(CurrentWeddingManager::class);
        if ($manager->hasWedding()) {
            $builder->where($model->getTable() . '.wedding_id', '=', $manager->getId());
        }
    }
}

// 3. BelongsToWedding (Model Trait)
namespace App\Domains\Wedding\Traits;
use App\Domains\Wedding\Models\Wedding;
use App\Domains\Wedding\Scopes\WeddingScope;
use App\Domains\Wedding\Services\CurrentWeddingManager;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
trait BelongsToWedding {
    public static function bootBelongsToWedding(): void {
        static::addGlobalScope(new WeddingScope());
        static::creating(function ($model) {
            $manager = app(CurrentWeddingManager::class);
            if ($manager->hasWedding() && empty($model->wedding_id)) {
                $model->wedding_id = $manager->getId();
            }
        });
    }
    public function wedding(): BelongsTo {
        return $this->belongsTo(Wedding::class, 'wedding_id');
    }
}
```

---

## 4. Implementation Instructions & Roadmap for Forge (Senior Backend Developer)

### 4.1 Execution Sequence
1. **Enums:** Create PHP 8.2 backed enums for UserRole, UserStatus, WeddingType, TaskPriority, TaskStatus, PaymentStatus, PaymentMethod, QuotationStatus, BookingStatus, etc.
2. **Migrations:** Generate 33 migrations in strict dependency order (Users -> Weddings -> Planning -> Budget -> Guest -> Marketplace -> Booking -> Comm -> Platform).
3. **Scopes & Traits:** Implement `CurrentWeddingManager`, `WeddingScope`, and `BelongsToWedding`.
4. **Models & Factories:** Define all Eloquent models with fillables, casts, relations, and auto-generated UUIDs.
5. **Seeders:** Seed 10 Sri Lankan vendor categories, 25 districts, checklist templates with negative day offsets, and subscription tiers.
6. **Actions & Tests:** Implement core actions (`ConvertQuotationToBookingAction`, `AllocateBudgetCategoriesAction`) and automated Pest/PHPUnit tests.

### 4.2 Forge Verification Checklist
- [ ] `php artisan migrate:fresh --seed` runs completely without foreign key violations.
- [ ] Every workspace model applies `BelongsToWedding`.
- [ ] `Task::all()` in a workspace returns only that wedding's records.
- [ ] Deleting a `Budget` with recorded `Expenses` is blocked (`ON DELETE RESTRICT`).
- [ ] Pest/PHPUnit tests for tenant isolation pass with 100% assertions.
