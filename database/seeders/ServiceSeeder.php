<?php

namespace Database\Seeders;

use App\Models\Service;
use App\Models\ServiceIcon;
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
                'tagline' => 'Accurate Valuations You Can Trust',
                'short_description' => 'Accurate independent valuations for sales, loans, insurance and legal compliance.',
                'content' => "Whether you're securing a mortgage, settling an estate, insuring a property, or preparing for a sale, an accurate valuation is the foundation everything else is built on. Our registered valuers combine on-the-ground market knowledge across Blantyre and Lilongwe with international valuation standards to produce reports that banks, insurers, courts, and regulators accept without question. Every valuation includes a physical inspection, comparable sales analysis, and a written report you can rely on for negotiations, financing, or legal proceedings.",
                'features' => [
                    'Registered, qualified valuers',
                    'Bank and insurer-accepted reports',
                    'Residential, commercial & land valuations',
                    'Fast turnaround times',
                    'Compliant with Malawian land law',
                    'Transparent, defensible methodology',
                ],
                'banner_image' => 'brand-assets/3 Services Page/Image 1.png',
                'icon' => 'property-valuation.svg',
                'visible' => true,
            ],
            [
                'title' => 'Property Management',
                'tagline' => 'Your Investment, Professionally Managed',
                'short_description' => 'Full-service property management, maintenance and reporting for owners and investors.',
                'content' => "Owning rental property should generate income, not headaches. We take day-to-day management off your hands — sourcing and vetting tenants, collecting and remitting rent on schedule, coordinating repairs and routine maintenance, and keeping you informed with clear monthly reporting. Our team also handles lease renewals, compliance with local tenancy regulations, and emergency call-outs, so your investment stays protected and performing whether you live down the road or overseas.",
                'features' => [
                    'Rent collection & remittance',
                    'Tenant sourcing and vetting',
                    'Routine maintenance coordination',
                    'Monthly owner reporting',
                    'Lease compliance & renewals',
                    '24/7 emergency response',
                ],
                'banner_image' => 'brand-assets/3 Services Page/Image 2.png',
                'icon' => 'property-management.svg',
                'visible' => true,
            ],
            [
                'title' => 'Sales And Letting',
                'tagline' => 'From Listing to Closing, Handled',
                'short_description' => 'Efficient property sales and letting services supported by local market insight.',
                'content' => "Buying, selling, or letting a property involves more than putting up a listing. We price properties against real, current market data, market them to genuinely interested buyers and tenants, and screen every applicant before they get near your keys. From the first inquiry through negotiation to signed agreement, our team stays in your corner — explaining every offer, managing paperwork, and keeping the process moving so a transaction that could drag on for months gets closed with confidence.",
                'features' => [
                    'Market-driven pricing guidance',
                    'Professional listing & marketing',
                    'Qualified buyer & tenant screening',
                    'Negotiation support',
                ],
                'banner_image' => 'brand-assets/3 Services Page/Image 3.png',
                'icon' => 'sales-letting.svg',
                'visible' => true,
            ],
            [
                'title' => 'Property Development',
                'tagline' => 'From Concept to Completion',
                'short_description' => 'Development advisory from concept planning to project delivery.',
                'content' => "Every successful development starts long before the first brick is laid. We help developers stress-test a site's viability — assessing zoning, land use, and financial feasibility — before guiding projects through regulatory approvals with local authorities. Once construction is underway, our advisory continues through project oversight, keeping budgets, timelines, and contractor performance on track so what gets delivered matches what was planned, on schedule and within budget.",
                'features' => [
                    'Feasibility studies',
                    'Regulatory approvals support',
                    'Construction project oversight',
                    'Budget & timeline management',
                ],
                'banner_image' => 'brand-assets/3 Services Page/Image 4.png',
                'icon' => 'property-development.svg',
                'visible' => true,
            ],
            [
                'title' => 'Title Deed Processing',
                'tagline' => 'Secure Your Legal Ownership',
                'short_description' => 'Trusted assistance in preparing and submitting land registration documentation.',
                'content' => "Land registration in Malawi can be slow and paperwork-heavy, especially without someone who knows the process from the inside. We start with a title deed search to confirm ownership and flag any existing encumbrances, prepare the full application with all supporting documentation, and follow up directly with the relevant land registry offices until the deed is issued. Clients get regular status updates throughout, instead of chasing a stalled application on their own.",
                'features' => [
                    'Title deed searches',
                    'Application preparation',
                    'Land registry follow-up',
                ],
                'banner_image' => 'brand-assets/3 Services Page/Image 5.png',
                'icon' => 'title-deed-processing.svg',
                'visible' => true,
            ],
        ];

        foreach ($services as $service) {
            $service['service_icon_id'] = ServiceIcon::where('name', $service['title'])->value('id');

            Service::updateOrCreate(
                ['title' => $service['title']],
                $service
            );
        }
    }
}
