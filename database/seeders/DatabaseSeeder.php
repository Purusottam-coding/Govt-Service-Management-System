<?php

namespace Database\Seeders;

use App\Models\Department;
use App\Models\Notice;
use App\Models\Service;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Seed Admin User
        $admin = User::create([
            'name' => 'System Administrator',
            'email' => 'admin@gov.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'phone' => '+1 (555) 019-2831',
            'address' => 'Government Headquarters, Block A',
        ]);

        // 2. Seed Citizen User
        $citizen = User::create([
            'name' => 'John Citizen',
            'email' => 'citizen@test.com',
            'password' => Hash::make('password'),
            'role' => 'citizen',
            'phone' => '+1 (555) 382-9102',
            'address' => '742 Evergreen Terrace, Springfield',
        ]);

        // 3. Seed Departments
        $deptTransport = Department::create([
            'name' => 'Department of Motor Vehicles & Transport',
            'description' => 'Oversees driver licensing, vehicle registration, road permits, and transport regulations.',
            'phone' => '+1 (555) 100-2000',
            'email' => 'transport@gov.com',
            'status' => true,
        ]);

        $deptImmigration = Department::create([
            'name' => 'Department of Immigration & Citizenship',
            'description' => 'Handles passport issuance, visa processing, citizenship verification, and travel documentation.',
            'phone' => '+1 (555) 200-3000',
            'email' => 'immigration@gov.com',
            'status' => true,
        ]);

        $deptCivil = Department::create([
            'name' => 'Department of Civil Registry & Vital Statistics',
            'description' => 'Manages birth certificates, marriage licenses, death records, and identity registration.',
            'phone' => '+1 (555) 300-4000',
            'email' => 'civil@gov.com',
            'status' => true,
        ]);

        $deptHousing = Department::create([
            'name' => 'Department of Housing & Urban Planning',
            'description' => 'Processes building permits, zoning approvals, public housing applications, and property records.',
            'phone' => '+1 (555) 400-5000',
            'email' => 'housing@gov.com',
            'status' => true,
        ]);

        $deptBusiness = Department::create([
            'name' => 'Department of Commerce & Business Affairs',
            'description' => 'Handles commercial business registration, trade licenses, tax compliance certificates, and permits.',
            'phone' => '+1 (555) 500-6000',
            'email' => 'commerce@gov.com',
            'status' => true,
        ]);

        // 4. Seed Services
        Service::create([
            'department_id' => $deptTransport->id,
            'name' => 'Driver License Renewal',
            'description' => 'Renew your standard or commercial driver license online without visiting the DMV branch.',
            'required_documents' => ['Existing Driver License Copy', 'Proof of Address', 'Recent Eye Examination Certificate'],
            'fee' => 45.00,
            'processing_days' => 5,
            'status' => true,
        ]);

        Service::create([
            'department_id' => $deptTransport->id,
            'name' => 'Vehicle Registration & License Plates',
            'description' => 'Register a new or transferred motor vehicle and request official license plates.',
            'required_documents' => ['Vehicle Bill of Sale', 'Proof of Vehicle Insurance', 'Smog/Inspection Certificate'],
            'fee' => 120.00,
            'processing_days' => 3,
            'status' => true,
        ]);

        Service::create([
            'department_id' => $deptImmigration->id,
            'name' => 'Passport Issuance & Renewal',
            'description' => 'Apply for a new national biometric passport or renew an expiring travel document.',
            'required_documents' => ['National Identity Card / Birth Certificate', 'Passport Photograph (2x2)', 'Proof of Citizenship'],
            'fee' => 110.00,
            'processing_days' => 10,
            'status' => true,
        ]);

        Service::create([
            'department_id' => $deptImmigration->id,
            'name' => 'Citizenship Certificate Verification',
            'description' => 'Request official verification and certified copy of citizenship documentation.',
            'required_documents' => ['Parental Birth Certificates', 'Proof of Residency'],
            'fee' => 35.00,
            'processing_days' => 7,
            'status' => true,
        ]);

        Service::create([
            'department_id' => $deptCivil->id,
            'name' => 'Official Birth Certificate Issuance',
            'description' => 'Order certified copy of birth certificate for legal, educational, or identification purposes.',
            'required_documents' => ['Hospital Birth Notification', 'Parents Government ID Copies'],
            'fee' => 25.00,
            'processing_days' => 2,
            'status' => true,
        ]);

        Service::create([
            'department_id' => $deptCivil->id,
            'name' => 'Marriage License Registration',
            'description' => 'Register marriage certificate and obtain official legal marriage documentation.',
            'required_documents' => ['Both Applicants Identity Cards', 'Witness Information Form', 'Divorce Decree (if applicable)'],
            'fee' => 60.00,
            'processing_days' => 4,
            'status' => true,
        ]);

        Service::create([
            'department_id' => $deptHousing->id,
            'name' => 'Residential Building Permit',
            'description' => 'Apply for structural construction, renovation, or expansion permission for residential properties.',
            'required_documents' => ['Architectural Blueprints', 'Property Land Deed', 'Environmental Impact Assessment'],
            'fee' => 250.00,
            'processing_days' => 14,
            'status' => true,
        ]);

        Service::create([
            'department_id' => $deptBusiness->id,
            'name' => 'Commercial Business Operating License',
            'description' => 'Register a new small business, LLC, or corporation and obtain official operating permit.',
            'required_documents' => ['Articles of Incorporation', 'Tax Identification Number', 'Lease/Deed Agreement'],
            'fee' => 180.00,
            'processing_days' => 7,
            'status' => true,
        ]);

        // 5. Seed Public Notices
        Notice::create([
            'title' => 'Portal Maintenance & Scheduled System Upgrade',
            'content' => 'Please be advised that the Online Government Service Portal will undergo scheduled maintenance on Sunday from 02:00 AM to 06:00 AM. Online submissions may be temporarily unavailable.',
            'published_at' => now()->subDays(1),
            'is_active' => true,
        ]);

        Notice::create([
            'title' => 'New Expedited Passport & Document Delivery Available',
            'content' => 'Citizens can now opt for express courier delivery of renewed passports and certified vital statistics records directly to their registered residential address.',
            'published_at' => now()->subDays(3),
            'is_active' => true,
        ]);

        Notice::create([
            'title' => 'Digital Fee Payment Methods Expanded',
            'content' => 'We now accept instant online debit/credit card payments, digital bank wires, and over-the-counter payments at all municipal service centers nationwide.',
            'published_at' => now()->subDays(5),
            'is_active' => true,
        ]);
    }
}
