# Task Brief for Forge (Senior Backend Developer)
**Project:** Wedora — Sri Lankan Wedding Planning SaaS & Marketplace  
**Architecture:** Laravel 12 Modular Monolith (pp/Domains/)  
**Specification Reference:** C:/xampp/htdocs/wedora/WEDORA_PHASE1_SPECIFICATION.md

## Forge Implementation Objectives:
1. **Enums & Value Objects (pp/Domains/*/Enums):**
   - Implement backed PHP 8.2 enums: UserRole, UserStatus, WeddingType, TaskPriority, TaskStatus, PaymentStatus, PaymentMethod, QuotationStatus, BookingStatus, VerificationStatus.
2. **Multi-Tenancy Isolation (pp/Domains/Wedding/):**
   - Create CurrentWeddingManager request-scoped singleton.
   - Implement WeddingScope global scope.
   - Implement BelongsToWedding trait for all workspace-scoped entities.
3. **Database Migrations (database/migrations/):**
   - Generate the 33 database migrations defined in Section 2 of WEDORA_PHASE1_SPECIFICATION.md.
   - Ensure foreign key constraints, default LKR currency, DECIMAL(12,2) financials, and ON DELETE RESTRICT on financial/booking records.
4. **Eloquent Models & UUIDs:**
   - Define Models under their respective Domain folders.
   - Configure $fillable, $casts, relationships, and auto-generation of UUIDs on creation.
5. **Database Seeders (database/seeders/):**
   - VendorCategorySeeder (10 Sri Lankan wedding categories).
   - SriLankaDistrictsSeeder (25 administrative districts).
   - ChecklistTemplateSeeder (Traditional & Western planning timeline milestones).
   - SubscriptionPlanSeeder (Free, Pro, Premium, Planner tiers).
6. **Verification:**
   - Execute php artisan migrate:fresh --seed.
