<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        $services = [
            [
                'title' => 'Property Valuation',
                'short_description' => 'Accurate independent valuations for sales, loans, insurance and legal compliance.',
                'content' => 'Our team provides valuation services aligned with local land law and international best practice, helping clients understand fair market value for every transaction.',
                'banner_image' => 'brand-assets/3 Services Page/Image 1.png',
                'icon' => 'property-valuation.svg',
                'visible' => true,
            ],
            [
                'title' => 'Property Management',
                'short_description' => 'Full-service property management, maintenance and reporting for owners and investors.',
                'content' => 'We manage rental income, tenant communication, maintenance schedules and compliance so your investment performs reliably and professionally.',
                'banner_image' => 'brand-assets/3 Services Page/Image 2.png',
                'icon' => 'property-management.svg',
                'visible' => true,
            ],
            [
                'title' => 'Sales And Letting',
                'short_description' => 'Efficient property sales and letting services supported by local market insight.',
                'content' => 'From marketing to closing, we support buyers and sellers with transparent pricing, negotiations and transaction guidance.',
                'banner_image' => 'brand-assets/3 Services Page/Image 3.png',
                'icon' => 'sales-letting.svg',
                'visible' => true,
            ],
            [
                'title' => 'Property Development',
                'short_description' => 'Development advisory from concept planning to project delivery.',
                'content' => 'We advise on feasibility, approvals and construction management to help developers deliver quality projects on time and within budget.',
                'banner_image' => 'brand-assets/3 Services Page/Image 4.png',
                'icon' => 'property-development.svg',
                'visible' => true,
            ],
            [
                'title' => 'Title Deed Processing',
                'short_description' => 'Trusted assistance in preparing and submitting land registration documentation.',
                'content' => 'We support clients through deed searches, application preparation and follow-up with land registry offices to secure legal ownership documentation.',
                'banner_image' => 'brand-assets/3 Services Page/Image 5.png',
                'icon' => 'title-deed-processing.svg',
                'visible' => true,
            ],
        ];

        foreach ($services as $service) {
            Service::updateOrCreate(
                ['title' => $service['title']],
                $service
            );
        }
    }
}
