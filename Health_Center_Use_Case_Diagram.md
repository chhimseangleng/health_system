# Health Center Management System - Use Case Diagram

## System Overview
The Health Center Management System is designed to manage patient registration, assignment, and medical services across different departments.

## Actors

### 1. Admin/Manager
- **Role**: System administrator with full access to all system functions
- **Responsibilities**: Overall system management, user management, reporting

### 2. Medical Staff
- **Vaccine Staff**: Handles vaccination services
- **Common Disease Staff**: Manages general medical consultations
- **Gynecology Staff**: Provides gynecological services
- **Medicine/Pharmacy Staff**: Manages medication inventory and dispensing

### 3. Receptionist/Front Desk
- **Role**: Patient registration and assignment coordinator
- **Responsibilities**: Patient intake, assignment to appropriate departments

## Use Cases by Actor

```
┌─────────────────────────────────────────────────────────────────────────────┐
│                     HEALTH CENTER MANAGEMENT SYSTEM                        │
└─────────────────────────────────────────────────────────────────────────────┘

┌──────────────────┐                                    ┌─────────────────────┐
│   Admin/Manager  │                                    │   Authentication    │
│                  │────────────────────────────────────│   • Login           │
└──────────────────┘                                    │   • Logout          │
         │                                              │   • Profile Mgmt    │
         │                                              └─────────────────────┘
         │
    ┌────────────────────────────────────────┐
    │           ADMIN USE CASES              │
    │  • View Dashboard & Statistics         │
    │  • Create/Manage User Accounts         │
    │  • Generate System Reports             │
    │  • Export Data (CSV/PDF)              │
    │  • System Configuration               │
    │  • Language Management                │
    └────────────────────────────────────────┘

┌──────────────────┐                        ┌─────────────────────────────────┐
│ Receptionist/    │                        │       PATIENT MANAGEMENT        │
│ Front Desk       │────────────────────────│  • Register New Patient        │
└──────────────────┘                        │  • Search Existing Patients    │
         │                                  │  • Edit Patient Information    │
         │                                  │  • Assign Patient to Dept      │
         │                                  │  • Add Patient Services        │
         │                                  │  • Manage Appointments         │
         └──────────────────────────────────│  • View Patient History        │
                                           └─────────────────────────────────┘

┌──────────────────┐                        ┌─────────────────────────────────┐
│  Vaccine Staff   │                        │       VACCINE SERVICES          │
│                  │────────────────────────│  • Access Vaccine Workspace    │
└──────────────────┘                        │  • Manage Vaccine Categories   │
         │                                  │  • Process Vaccinations        │
         │                                  │  • Record Vaccination Data     │
         │                                  │  • Schedule Comeback Visits    │
         │                                  │  • Track Vaccination History   │
         └──────────────────────────────────│  • Generate Vaccine Reports    │
                                           └─────────────────────────────────┘

┌──────────────────┐                        ┌─────────────────────────────────┐
│Common Disease    │                        │    COMMON DISEASE SERVICES      │
│Staff             │────────────────────────│  • Access Disease Workspace    │
└──────────────────┘                        │  • Diagnose Patient Conditions │
         │                                  │  • Record Medical Information  │
         │                                  │  • Generate Medical Reports    │
         │                                  │  • Search Patient Symptoms     │
         │                                  │  • Export Diagnostic Data      │
         │                                  │  • Print Medical Certificates  │
         └──────────────────────────────────│  • Update Patient Records      │
                                           └─────────────────────────────────┘

┌──────────────────┐                        ┌─────────────────────────────────┐
│ Gynecology Staff │                        │     GYNECOLOGY SERVICES         │
│                  │────────────────────────│  • Access Gynecology Workspace │
└──────────────────┘                        │  • Conduct Examinations        │
         │                                  │  • Record Examination Results  │
         │                                  │  • Manage Reproductive Health  │
         │                                  │  • Track Treatment History     │
         │                                  │  • Generate Gynecology Reports │
         └──────────────────────────────────│  • Schedule Follow-ups         │
                                           └─────────────────────────────────┘

┌──────────────────┐                        ┌─────────────────────────────────┐
│Medicine/Pharmacy │                        │     PHARMACY SERVICES           │
│Staff             │────────────────────────│  • Manage Medicine Inventory   │
└──────────────────┘                        │  • Dispense Medications        │
         │                                  │  • Update Stock Levels         │
         │                                  │  • Bulk Medication Dispensing  │
         │                                  │  • View Pharmacy Dashboard     │
         │                                  │  • Track Medicine Usage        │
         │                                  │  • Generate Inventory Reports  │
         └──────────────────────────────────│  • Manage Medicine Categories  │
                                           └─────────────────────────────────┘

                        ┌─────────────────────────────────┐
                        │        SHARED USE CASES         │
                        │  • View Assigned Patients       │
                        │  • Mark Assignments Read        │
                        │  • Mark Assignments Processed   │
                        │  • Update Patient History       │
                        │  • View Assignment Dashboard    │
                        │  • Search Patients              │
                        │  • Generate Department Reports  │
                        └─────────────────────────────────┘
```

## System Relationships

### Include Relationships
- All actors → Authentication (Login/Logout)
- All medical staff → View Assigned Patients
- All medical staff → Update Patient History
- Admin → All system functions

### Extend Relationships
- Register Patient → Search Existing Patient
- Process Services → Generate Reports
- Manage Inventory → Generate Inventory Reports

## Key System Features

### 1. Patient Management
- **Registration**: Complete patient demographic and contact information
- **Assignment**: Route patients to appropriate medical departments
- **History Tracking**: Comprehensive medical history across all services

### 2. Department Workspaces
- **Vaccine Department**: Immunization management and scheduling
- **Common Disease**: General medical consultation and diagnosis
- **Gynecology**: Specialized women's health services
- **Pharmacy**: Medication inventory and dispensing

### 3. Reporting & Analytics
- **Dashboard**: Real-time system statistics and charts
- **Export Functions**: CSV and PDF report generation
- **Audit Trail**: Complete activity logging and tracking

### 4. Assignment Management
- **Queue System**: Patient assignment to medical staff
- **Status Tracking**: Real-time assignment status updates
- **Workflow Management**: Streamlined patient processing

## Technical Implementation Notes
- **Database**: MongoDB for flexible data storage
- **Framework**: Laravel PHP framework
- **Authentication**: Built-in Laravel authentication
- **UI**: Tailwind CSS responsive design
- **Localization**: Multi-language support (English/Khmer)
