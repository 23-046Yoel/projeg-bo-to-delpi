# Requirements Document

## Introduction

This document specifies the comprehensive revision requirements for the MBG (Makanan Bergizi Gratis) Admin & Financial System. The system manages kitchen operations, beneficiary tracking, financial transactions, material inventory, and public transparency for a government nutrition program. This revision introduces multi-kitchen support, enhanced role management, improved financial tracking, route monitoring via WhatsApp, and public engagement features.

## Glossary

- **System**: The MBG Admin & Financial System (Bo To Delpi)
- **Kitchen**: A physical cooking facility (Dapur) that prepares meals for beneficiaries
- **SPPG**: Satuan Pelaksana Program Gizi (Nutrition Program Implementation Unit) - represents a kitchen location
- **Beneficiary**: A recipient of the nutrition program (schools, posyandu, individuals)
- **Posyandu**: Community health post providing maternal and child health services
- **Material**: Raw ingredients or supplies used in meal preparation (Bahan Baku)
- **Purchase_Order**: A formal request to suppliers for materials (Surat Pesanan)
- **ASLAP**: Supervisor role responsible for route monitoring
- **Driver**: Personnel who delivers meals to beneficiaries
- **Transaction**: A financial record of income or expense
- **Virtual_Account**: Digital payment account for financial transactions
- **Kas_Kecil**: Petty cash account for small expenses
- **LP2DM**: Laporan Pertanggungjawaban Penggunaan Dana Makan (Meal Fund Usage Accountability Report)
- **SPTJ**: Surat Pertanggungjawaban (Accountability Letter)
- **BAPAD**: Berita Acara Penerimaan dan Distribusi (Receipt and Distribution Minutes)
- **BGN**: Badan Gizi Nasional (National Nutrition Agency)
- **Parser**: A software component that reads and interprets structured data formats
- **Pretty_Printer**: A software component that formats data into human-readable output
- **Configuration_Object**: A structured data representation of system settings
- **Warehouse_Report**: An inventory status report showing material stock levels
- **Route**: A predefined path for meal delivery to multiple beneficiaries
- **Public_Portal**: The publicly accessible website interface
- **News_Ticker**: A scrolling display of public messages and updates
- **Price_Transparency**: Public display of material costs and market prices
- **Siperda**: Sistem Informasi Pasar Daerah (Regional Market Information System)

## Requirements

### Requirement 1: Multi-Kitchen Architecture

**User Story:** As a system administrator, I want to manage multiple kitchens with independent operations, so that each kitchen can operate autonomously with its own suppliers, menus, and beneficiaries.

#### Acceptance Criteria

1. THE System SHALL store a kitchen identifier for each SPPG record
2. WHEN a user logs in, THE System SHALL assign the user to their designated kitchen
3. WHILE a user is logged in, THE System SHALL filter all data operations to show only records belonging to the user's assigned kitchen
4. THE System SHALL allow each kitchen to maintain independent supplier relationships
5. THE System SHALL allow each kitchen to create independent menu plans
6. THE System SHALL maintain a unified dish list accessible to all kitchens
7. THE System SHALL store kitchen assignment for each beneficiary record
8. WHEN displaying beneficiary data, THE System SHALL include the kitchen name field
9. THE System SHALL enforce kitchen-based access control for all CRUD operations on materials, orders, menus, and distributions

### Requirement 2: Enhanced User Role Management

**User Story:** As a system administrator, I want to manage user roles and job positions, so that I can control access and assign appropriate responsibilities.

#### Acceptance Criteria

1. THE System SHALL support an Admin role with full system access
2. THE System SHALL allow multiple users to be assigned the Admin role
3. THE System SHALL support a Quality_Control job position
4. THE System SHALL support a Pengawas_Gizi job position
5. THE System SHALL support an Admin job position
6. WHEN configuring SPPG Karang Rejo, THE System SHALL limit the user count to 1
7. THE System SHALL validate user role assignments against kitchen capacity constraints

### Requirement 3: Material Category Management

**User Story:** As a warehouse manager, I want to categorize materials by nutritional type, so that I can organize inventory and plan balanced meals.

#### Acceptance Criteria

1. THE System SHALL classify materials into exactly one of five categories: Karbohidrat, Protein_Hewani, Protein_Nabati, Buah, or Tambahan
2. WHEN creating a new material, THE System SHALL require category selection from the five defined categories
3. WHEN displaying material lists, THE System SHALL show the assigned category for each material
4. THE System SHALL allow filtering materials by category

### Requirement 4: Material Unit Management

**User Story:** As a warehouse manager, I want to define and reuse measurement units, so that I can maintain consistency in material tracking.

#### Acceptance Criteria

1. THE System SHALL provide a dropdown list of predefined measurement units
2. THE System SHALL allow users to add new measurement units to the dropdown list
3. WHEN a user adds a new unit, THE System SHALL persist it for future use
4. WHEN creating a material record, THE System SHALL auto-fill the unit field based on the material's default unit
5. THE System SHALL display the unit field as read-only when auto-filled from material defaults

### Requirement 5: Material Expiration Tracking

**User Story:** As a warehouse manager, I want to track material expiration dates, so that I can prevent use of expired ingredients.

#### Acceptance Criteria

1. THE System SHALL store an expiration date field for each material stock entry
2. WHEN adding material stock, THE System SHALL require an expiration date input
3. WHEN displaying material inventory, THE System SHALL show the expiration date for each stock entry
4. WHEN the current date is within 7 days of a material's expiration date, THE System SHALL highlight the material with a warning indicator

### Requirement 6: Material Stock Deduction

**User Story:** As a warehouse manager, I want to subtract materials from inventory when used, so that stock levels remain accurate.

#### Acceptance Criteria

1. THE System SHALL provide a subtract operation for material stock quantities
2. WHEN a user initiates a subtract operation, THE System SHALL display a quantity input field
3. WHEN a subtract operation is confirmed, THE System SHALL reduce the material stock by the specified quantity
4. IF the subtract quantity exceeds available stock, THEN THE System SHALL reject the operation and display an error message
5. WHEN a subtract operation completes, THE System SHALL create a material log entry recording the deduction

### Requirement 7: Warehouse Reporting

**User Story:** As a warehouse manager, I want to view inventory status in a report format, so that I can assess stock levels and plan purchases.

#### Acceptance Criteria

1. THE System SHALL generate a Warehouse_Report displaying all materials
2. THE Warehouse_Report SHALL include material name for each entry
3. THE Warehouse_Report SHALL include notes field for each entry
4. THE Warehouse_Report SHALL include last purchase price for each entry
5. THE Warehouse_Report SHALL include estimated needs quantity for each entry
6. THE System SHALL format the Warehouse_Report as a printable document

### Requirement 8: Purchase Order Auto-Fill

**User Story:** As a procurement officer, I want purchase order fields to auto-populate, so that I can create orders quickly and accurately.

#### Acceptance Criteria

1. WHEN a user selects a material in a Purchase_Order form, THE System SHALL auto-fill the price field with the material's last purchase price
2. WHEN a user selects a material in a Purchase_Order form, THE System SHALL auto-fill the unit field with the material's default unit
3. THE System SHALL allow users to override auto-filled price values
4. THE System SHALL display auto-filled unit values as read-only

### Requirement 9: Purchase Order Printing

**User Story:** As a procurement officer, I want to print purchase orders, so that I can send formal requests to suppliers.

#### Acceptance Criteria

1. THE System SHALL provide a print function for Purchase_Order documents
2. WHEN a user initiates print, THE System SHALL generate a formatted Purchase_Order document
3. THE Purchase_Order document SHALL include supplier information, material list, quantities, prices, and total amount
4. THE System SHALL format the Purchase_Order document according to official government document standards

### Requirement 10: Financial Transaction Restructuring

**User Story:** As a finance officer, I want to record all financial activities in a unified transaction system, so that I can track cash flow accurately.

#### Acceptance Criteria

1. THE System SHALL rename the "Rekap Harian" menu to "Dashboard"
2. THE System SHALL rename the "Pembayaran" menu to "Input Transaksi"
3. THE System SHALL display a reminder to enter initial balance when no balance record exists
4. THE System SHALL support three expense transaction types: Biaya_Bahan_Baku, Biaya_Operasional, and Insentif_Fasilitas
5. THE System SHALL support one income transaction type: Bantuan_Pemerintah
6. THE System SHALL support two cash account types: Virtual_Account and Kas_Kecil
7. WHEN recording a transaction, THE System SHALL require: date, description, transaction type, amount, cash type, and proof upload
8. WHEN recording an expense, THE System SHALL populate the "Keluar" column with the amount
9. WHEN recording income, THE System SHALL populate the "Masuk" column with the amount
10. WHEN a transaction is recorded, THE System SHALL calculate and display the balance difference in the "Selisih" column
11. THE System SHALL remove the beneficiary field from transaction input forms

### Requirement 11: Financial Document Alignment

**User Story:** As a finance officer, I want financial reports to match BGN document formats, so that I can submit compliant reports to the government.

#### Acceptance Criteria

1. THE System SHALL generate LP2DM documents following BGN format specifications
2. THE System SHALL generate SPTJ documents following BGN format specifications
3. THE System SHALL generate BAPAD documents following BGN format specifications
4. WHEN generating financial documents, THE System SHALL include all required fields specified in BGN guidelines
5. THE System SHALL validate financial document completeness before allowing export

### Requirement 12: Attendance Filtering

**User Story:** As a supervisor, I want to filter attendance records by kitchen and date, so that I can review specific attendance data.

#### Acceptance Criteria

1. THE System SHALL provide a kitchen filter dropdown on the attendance report page
2. THE System SHALL provide a date filter input on the attendance report page
3. WHEN a user selects a kitchen filter, THE System SHALL display only attendance records for the selected kitchen
4. WHEN a user selects a date filter, THE System SHALL display only attendance records for the selected date
5. THE System SHALL allow combining kitchen and date filters simultaneously

### Requirement 13: WhatsApp-Based Route Monitoring

**User Story:** As an ASLAP supervisor, I want to monitor delivery routes via WhatsApp messages, so that I can track driver progress without requiring driver accounts.

#### Acceptance Criteria

1. THE System SHALL allow ASLAP users to configure delivery routes with stop sequences
2. THE System SHALL store driver phone numbers associated with each route
3. WHEN a driver sends a WhatsApp message containing "berangkat", THE System SHALL record a departure timestamp for the active route
4. WHEN a driver sends a WhatsApp message containing "tiba", THE System SHALL record an arrival timestamp for the current route stop
5. THE System SHALL parse incoming WhatsApp messages from registered driver phone numbers
6. THE System SHALL match WhatsApp messages to configured routes based on driver phone number
7. THE System SHALL display route monitoring status on the ASLAP dashboard showing departure and arrival times
8. IF a WhatsApp message is received from an unregistered phone number, THEN THE System SHALL ignore the message

### Requirement 14: Beneficiary Management Restructuring

**User Story:** As a program coordinator, I want to manage different types of beneficiaries with detailed categorization, so that I can track program reach accurately.

#### Acceptance Criteria

1. THE System SHALL rename the "Manajemen Sekolah" menu to "Manajemen Penerima Manfaat"
2. THE System SHALL support two beneficiary types: Sekolah and Posyandu
3. WHEN creating a beneficiary, THE System SHALL require selection of beneficiary type
4. THE System SHALL provide a form to add new beneficiaries
5. WHEN a beneficiary is saved, THE System SHALL display the registered beneficiary in a list below the form
6. THE System SHALL store estimated portion counts for Porsi_Besar and Porsi_Kecil for each beneficiary
7. THE System SHALL support beneficiary categories including: Guru_dan_Staf, Kader_Posyandu, Anak_Sekolah
8. THE System SHALL allow defining additional beneficiary categories beyond the predefined list
9. THE System SHALL store SPPG name assignment for each beneficiary

### Requirement 15: Public Live Chat System

**User Story:** As a member of the public, I want to interact with a chatbot for general questions, so that I can get information without logging in.

#### Acceptance Criteria

1. THE System SHALL provide a public chat interface accessible without authentication
2. THE System SHALL configure predefined dialog responses for common general questions
3. WHEN a public user asks a general question, THE System SHALL respond with the configured dialog
4. WHEN a public user asks a financial question, THE System SHALL prompt the user to log in
5. THE System SHALL detect financial question keywords to trigger login prompts

### Requirement 16: Logo and Branding Update

**User Story:** As a system administrator, I want to update system branding to Delphi logo, so that the system reflects current organizational identity.

#### Acceptance Criteria

1. THE System SHALL display the Delphi logo in the main navigation header
2. THE System SHALL display the Delphi logo on the dashboard page
3. THE System SHALL display the Delphi logo on all public-facing pages
4. THE System SHALL replace all instances of previous logos with the Delphi logo

### Requirement 17: Public Portal Content Management

**User Story:** As a content administrator, I want to publish news and updates on the public portal, so that the community stays informed about program activities.

#### Acceptance Criteria

1. THE System SHALL provide a menu for posting news and information content
2. WHEN content is posted, THE System SHALL display it on the public portal homepage
3. THE System SHALL display content in reverse chronological order with newest content first
4. THE System SHALL allow content administrators to edit and delete posted content
5. THE System SHALL display the BGN logo as a clickable link to bgn.go.id

### Requirement 18: Kitchen Information Display

**User Story:** As a member of the public, I want to view information about each kitchen, so that I can learn about facilities and contact them.

#### Acceptance Criteria

1. THE System SHALL provide a public page listing all kitchens
2. WHEN a user selects a kitchen, THE System SHALL display building and kitchen facility photos
3. WHEN a user selects a kitchen, THE System SHALL display management profile information
4. WHEN a user selects a kitchen, THE System SHALL display contact information including phone number and address
5. THE System SHALL allow kitchen administrators to update their kitchen information

### Requirement 19: Public Aspiration and News Ticker

**User Story:** As a member of the public, I want to share my observations about food prices, so that I can contribute to price transparency.

#### Acceptance Criteria

1. THE System SHALL provide a public form for submitting MBG aspirations and price observations
2. WHEN a public user submits an aspiration, THE System SHALL display it in the news ticker without censorship
3. THE System SHALL display the news ticker below the top logo on the public portal
4. THE news ticker SHALL show the submitter's name, phone number (partially masked), location, and message
5. THE System SHALL display online user count on the public portal
6. THE System SHALL display new user registration count on the public portal

### Requirement 20: Market Price Integration

**User Story:** As a member of the public, I want to view traditional market prices, so that I can compare program costs with local market rates.

#### Acceptance Criteria

1. THE System SHALL provide a link to siperda.simalungunkab.go.id on the public portal
2. THE System SHALL display the link in the price transparency section
3. THE System SHALL label the link clearly as "Harga Pasar Tradisional Simalungun"

### Requirement 21: BGN Content Integration

**User Story:** As a content administrator, I want to automatically fetch content from BGN website, so that the portal displays current national program information.

#### Acceptance Criteria

1. THE System SHALL fetch content from bgn.go.id/juknis automatically
2. THE System SHALL display fetched BGN content in a designated section of the public portal
3. THE System SHALL update BGN content daily at 06:00 local time
4. IF the BGN website is unreachable, THEN THE System SHALL display the last successfully fetched content
5. THE System SHALL log content fetch operations for troubleshooting

### Requirement 22: Duplicate Menu Removal

**User Story:** As a system user, I want a clean navigation menu without duplicates, so that I can navigate efficiently.

#### Acceptance Criteria

1. THE System SHALL display only one "Daftar Pemasok" menu item
2. WHEN the system loads, THE System SHALL verify no duplicate menu items exist in the navigation
3. THE System SHALL remove the duplicate "Daftar Pemasok" menu item from the navigation structure

### Requirement 23: Material Management UI Improvements

**User Story:** As a warehouse manager, I want clear Indonesian labels on material management buttons, so that I can understand actions quickly.

#### Acceptance Criteria

1. THE System SHALL display "Tambahkan Bahan Baku" as the button text for adding new materials
2. THE System SHALL replace any English button text with Indonesian equivalents in the material management interface

### Requirement 24: Configuration Data Parsing and Formatting

**User Story:** As a system developer, I want to parse and format configuration files reliably, so that system settings are loaded and saved correctly.

#### Acceptance Criteria

1. WHEN a valid configuration file is provided, THE Parser SHALL parse it into a Configuration_Object
2. WHEN an invalid configuration file is provided, THE Parser SHALL return a descriptive error message
3. THE Pretty_Printer SHALL format Configuration_Object instances back into valid configuration files
4. FOR ALL valid Configuration_Object instances, parsing then printing then parsing SHALL produce an equivalent Configuration_Object (round-trip property)
5. THE Parser SHALL validate configuration file structure against the defined schema
6. THE Pretty_Printer SHALL format configuration files with consistent indentation and spacing

