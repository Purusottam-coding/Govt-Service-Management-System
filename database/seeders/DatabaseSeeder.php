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
        // 1. प्रशासक खाता
        $admin = User::create([
            'name' => 'प्रणाली प्रशासक',
            'email' => 'admin@gov.np',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'phone' => '९८४०-०१२३४५',
            'address' => 'सिंहदरबार, काठमाडौं, नेपाल',
        ]);

        // 2. नागरिक परीक्षण खाता
        $citizen = User::create([
            'name' => 'राम बहादुर श्रेष्ठ',
            'email' => 'citizen@test.np',
            'password' => Hash::make('password'),
            'role' => 'citizen',
            'phone' => '९८४१-०१२३४६',
            'address' => 'बालाजु, काठमाडौं, नेपाल',
        ]);

        // 3. मन्त्रालय तथा विभागहरू
        $deptTransport = Department::create([
            'name' => 'यातायात व्यवस्था विभाग',
            'description' => 'सवारी चालक अनुमतिपत्र, सवारी साधन दर्ता, सडक परमिट, र यातायात नियमनसम्बन्धी कार्यहरू सञ्चालन गर्दछ।',
            'phone' => '०१-४२११५४०',
            'email' => 'transport@gov.np',
            'status' => true,
        ]);

        $deptImmigration = Department::create([
            'name' => 'राहदानी विभाग (अध्यागमन)',
            'description' => 'राहदानी जारी, भिसा प्रशोधन, नागरिकता प्रमाणीकरण, र यात्रा कागजातसम्बन्धी सेवाहरू प्रदान गर्दछ।',
            'phone' => '०१-४४१४३३६',
            'email' => 'passport@gov.np',
            'status' => true,
        ]);

        $deptCivil = Department::create([
            'name' => 'नागरिक दर्ता विभाग (जिल्ला प्रशासन)',
            'description' => 'जन्म दर्ता, विवाह दर्ता, मृत्यु दर्ता, र नागरिकता प्रमाणपत्रसम्बन्धी सेवाहरू व्यवस्थापन गर्दछ।',
            'phone' => '०१-४२११७८३',
            'email' => 'civilreg@gov.np',
            'status' => true,
        ]);

        $deptHousing = Department::create([
            'name' => 'नगरपालिका तथा भवन निर्माण विभाग',
            'description' => 'निर्माण अनुमति, जग्गा प्रयोग स्वीकृति, सार्वजनिक आवास निवेदन, र सम्पत्ति दर्तासम्बन्धी कार्यहरू गर्दछ।',
            'phone' => '०१-४२११४५१',
            'email' => 'housing@gov.np',
            'status' => true,
        ]);

        $deptBusiness = Department::create([
            'name' => 'वाणिज्य तथा आपूर्ति विभाग',
            'description' => 'व्यापारिक व्यवसाय दर्ता, व्यापार इजाजत, कर अनुपालन प्रमाणपत्र, र व्यावसायिक परमिटसम्बन्धी सेवाहरू।',
            'phone' => '०१-४२११०१७',
            'email' => 'commerce@gov.np',
            'status' => true,
        ]);

        // 4. सेवाहरू
        Service::create([
            'department_id' => $deptTransport->id,
            'name' => 'सवारी चालक अनुमतिपत्र नवीकरण',
            'description' => 'आफ्नो सवारी चालक अनुमतिपत्र यातायात व्यवस्था कार्यालयमा नगई अनलाइनबाट नवीकरण गर्नुहोस्।',
            'required_documents' => ['अवधि नसकिएको चालक अनुमतिपत्रको प्रतिलिपि', 'बसोबास प्रमाण', 'हालसालैको आँखा जाँच प्रमाणपत्र'],
            'fee' => 1500.00,
            'processing_days' => 5,
            'status' => true,
        ]);

        Service::create([
            'department_id' => $deptTransport->id,
            'name' => 'सवारी साधन दर्ता तथा नम्बर प्लेट',
            'description' => 'नयाँ वा हस्तान्तरण गरिएको सवारी साधन दर्ता गर्नुहोस् र आधिकारिक नम्बर प्लेट अनुरोध गर्नुहोस्।',
            'required_documents' => ['सवारी खरिद बिल', 'बिमा प्रमाणपत्र', 'प्रदूषण जाँच प्रमाणपत्र'],
            'fee' => 3500.00,
            'processing_days' => 3,
            'status' => true,
        ]);

        Service::create([
            'department_id' => $deptImmigration->id,
            'name' => 'राहदानी जारी तथा नवीकरण',
            'description' => 'नयाँ बायोमेट्रिक राहदानीको लागि आवेदन दिनुहोस् वा म्याद नाघ्न लागेको यात्रा कागजात नवीकरण गर्नुहोस्।',
            'required_documents' => ['नागरिकता प्रमाणपत्र / जन्मदर्ता', 'हालसालैको पासपोर्ट साइजको फोटो', 'नागरिकताको प्रमाण'],
            'fee' => 5000.00,
            'processing_days' => 10,
            'status' => true,
        ]);

        Service::create([
            'department_id' => $deptImmigration->id,
            'name' => 'नागरिकता प्रमाणपत्र प्रमाणीकरण',
            'description' => 'नागरिकता कागजातको आधिकारिक प्रमाणीकरण र प्रमाणित प्रतिलिपिको लागि अनुरोध गर्नुहोस्।',
            'required_documents' => ['बाबु-आमाको जन्मदर्ता', 'बसोबास प्रमाण'],
            'fee' => 500.00,
            'processing_days' => 7,
            'status' => true,
        ]);

        Service::create([
            'department_id' => $deptCivil->id,
            'name' => 'जन्मदर्ता प्रमाणपत्र जारी',
            'description' => 'कानुनी, शैक्षिक, वा परिचयको उद्देश्यका लागि जन्मदर्ता प्रमाणपत्रको प्रमाणित प्रतिलिपि अर्डर गर्नुहोस्।',
            'required_documents' => ['अस्पतालको जन्म सूचना', 'अभिभावकको नागरिकता प्रतिलिपि'],
            'fee' => 250.00,
            'processing_days' => 2,
            'status' => true,
        ]);

        Service::create([
            'department_id' => $deptCivil->id,
            'name' => 'विवाह दर्ता प्रमाणपत्र',
            'description' => 'विवाह दर्ता गर्नुहोस् र आधिकारिक कानुनी विवाह कागजात प्राप्त गर्नुहोस्।',
            'required_documents' => ['दुवै पक्षको नागरिकता प्रमाणपत्र', 'साक्षी परिचय फारम', 'सम्बन्धविच्छेद आदेश (पूर्व विवाहित भए)'],
            'fee' => 1000.00,
            'processing_days' => 4,
            'status' => true,
        ]);

        Service::create([
            'department_id' => $deptHousing->id,
            'name' => 'आवासीय भवन निर्माण अनुमति',
            'description' => 'आवासीय सम्पत्तिको संरचनात्मक निर्माण, नवीकरण, वा विस्तारको लागि अनुमति प्राप्त गर्नुहोस्।',
            'required_documents' => ['वास्तुकला नक्सा (ब्लुप्रिन्ट)', 'जग्गाधनीपुर्जा', 'वातावरणीय प्रभाव मूल्याङ्कन'],
            'fee' => 4500.00,
            'processing_days' => 14,
            'status' => true,
        ]);

        Service::create([
            'department_id' => $deptBusiness->id,
            'name' => 'व्यावसायिक व्यवसाय इजाजत दर्ता',
            'description' => 'नयाँ साना व्यवसाय, साझेदारी, वा कम्पनी दर्ता गर्नुहोस् र आधिकारिक परिचालन अनुमति प्राप्त गर्नुहोस्।',
            'required_documents' => ['व्यवसाय दर्ताको लागि निवेदन', 'प्यान / कर नम्बर', 'कार्यालय भाडा वा स्वामित्व कागजात'],
            'fee' => 2500.00,
            'processing_days' => 7,
            'status' => true,
        ]);

        // 5. सार्वजनिक सूचनाहरू
        Notice::create([
            'title' => 'पोर्टल रखरखाव तथा प्रणाली स्तरोन्नति सूचना',
            'content' => 'अनलाइन सरकारी सेवा पोर्टल आइतबार राति २:०० बजेदेखि बिहान ६:०० बजेसम्म अनुसूचित रखरखावको लागि बन्द रहनेछ। यस अवधिमा अनलाइन निवेदन सेवा अस्थायी रूपमा उपलब्ध नहुन सक्छ।',
            'published_at' => now()->subDays(1),
            'is_active' => true,
        ]);

        Notice::create([
            'title' => 'द्रुत राहदानी तथा कागजात वितरण सेवा शुरू',
            'content' => 'नागरिकहरूले अब नवीकरण गरिएको राहदानी र प्रमाणित कागजातहरू आफ्नो दर्ता ठेगानामा एक्सप्रेस कुरियरद्वारा प्राप्त गर्न सक्नुहुनेछ।',
            'published_at' => now()->subDays(3),
            'is_active' => true,
        ]);

        Notice::create([
            'title' => 'डिजिटल दस्तुर भुक्तानी प्रणाली विस्तार',
            'content' => 'अब हामी eSewa, Khalti, ConnectIPS, बैंक ट्रान्सफर, र सबै प्रमुख क्रेडिट/डेबिट कार्डबाट तत्काल अनलाइन भुक्तानी स्वीकार गर्दछौं।',
            'published_at' => now()->subDays(5),
            'is_active' => true,
        ]);
    }
}
