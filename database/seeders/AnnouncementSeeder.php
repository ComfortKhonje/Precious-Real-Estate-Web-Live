<?php

namespace Database\Seeders;

use App\Models\Announcement;
use App\Models\AnnouncementImage;
use App\Models\TeamMember;
use App\Services\MediaService;
use Illuminate\Database\Seeder;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Carbon;

class AnnouncementSeeder extends Seeder
{
    /**
     * Deliberately no WithoutModelEvents — Announcement::deleted() cleans up
     * uploaded files via MediaService, and this seeder re-runs via
     * updateOrCreate, so a clean teardown on re-seed matters here (unlike
     * seeders with no model events tied to file storage).
     */
    public function run(): void
    {
        // 2026-09-08: categories changed from Announcement/Market Update/
        // Notice to Announcement/News/Blog — old rows under the retired
        // category values aren't valid data under the new taxonomy, so this
        // wipes and reseeds fresh rather than trying to remap in place.
        Announcement::query()->get()->each->delete();

        $media = app(MediaService::class);

        $announcements = [
            [
                'title' => 'Precious Real Estate Opens New Lilongwe Office',
                'category' => 'Announcement',
                'summary' => 'We have expanded our footprint with a new branch in Area 47, bringing our valuation and sales services closer to clients in the capital.',
                'content' => '<p>We are excited to announce the opening of our new Lilongwe branch, located in Area 47 Sector 4. This expansion allows us to serve clients in the capital region more directly, with a dedicated team handling property sales, rentals, and valuations.</p><p>The new office is open Monday to Friday, 8am to 5pm, and Saturdays by appointment.</p>',
                'cover' => '4 Properties Page/Hero Image.png',
                'status' => 'published',
                'is_featured' => true,
                'published_at' => Carbon::now()->subDays(3),
            ],
            [
                'title' => 'New Listings: Six Properties Added This Week',
                'category' => 'Announcement',
                'summary' => 'A fresh batch of residential and commercial listings has gone live, including a lakeshore plot at Senga Bay and a warehouse facility in Kanengo.',
                'content' => '<p>Browse our latest listings, now live on the Properties page, including a lakefront plot at Senga Bay, a warehouse facility in Kanengo, and several family homes across Blantyre and Lilongwe.</p><p>Contact our valuation team for a private viewing.</p>',
                'cover' => '5 Properties View Page/Property image 1.png',
                'status' => 'published',
                'is_featured' => false,
                'published_at' => Carbon::now()->subDays(25),
            ],
            [
                'title' => 'Blantyre Property Market Sees Steady Growth in Q3',
                'category' => 'News',
                'summary' => 'Demand for mid-range residential properties in Blantyre suburbs continues to outpace supply, pushing rental yields upward this quarter.',
                'content' => '<p>Our latest market review shows sustained demand across Nyambadwe, Sunnyside, and Chilomoni, with average time-on-market for well-priced 3-bedroom homes dropping to under six weeks.</p><p>Commercial space in the CBD remains stable, with office suites in high demand from professional services firms relocating from older buildings.</p>',
                'cover' => '4 Properties Page/Property image 2.png',
                'status' => 'published',
                'is_featured' => false,
                'published_at' => Carbon::now()->subDays(10),
            ],
            [
                'title' => 'Lilongwe Commercial Rents Trend Higher on Kanengo Demand',
                'category' => 'News',
                'summary' => 'Industrial and warehouse space in Kanengo is commanding higher rents as logistics and distribution firms expand their footprint.',
                'content' => '<p>Kanengo Industrial Area continues to be the strongest-performing commercial segment in Lilongwe, driven by growth in logistics, distribution, and light manufacturing tenants.</p><p>We expect this trend to continue into the next quarter as more firms seek proximity to the M1 corridor.</p>',
                'cover' => '4 Properties Page/Property image 3.png',
                'status' => 'published',
                'is_featured' => false,
                'published_at' => Carbon::now()->subDays(32),
            ],
            [
                'title' => 'Behind the Scenes: Valuing a Heritage Property in Blantyre',
                'category' => 'Blog',
                'teamMember' => 'Ronald Mosopa',
                'summary' => 'A look at how our valuation team approached a century-old colonial-era property near the CBD — and the challenges heritage buildings bring.',
                'content' => '<p>When a client asked us to value a colonial-era property just off Chileka Road, we knew this wasn\'t going to be a standard inspection. The building dates back to the 1920s, and decades of partial renovations meant the usual comparable-sales approach would only get us part of the way there.</p>'
                    .'<p>Our first step was a full structural walkthrough — documenting original brickwork, the timber roof trusses, and sections that had been modernized over the years. Heritage properties like this one carry value that a straightforward square-footage calculation misses entirely.</p>'
                    .'<p>We also had to factor in the practical side: what would it cost a buyer to bring the wiring and plumbing up to current standards, versus the premium the character and location command in today\'s market? Getting that balance right is where experience matters most.</p>'
                    .'<p>After three site visits and a full comparable review against similar heritage listings in Blantyre and Zomba, we delivered a valuation the client\'s bank accepted without a single follow-up question — which, on a property this unusual, is exactly the outcome we aim for.</p>'
                    .'<p>Projects like this are why we love this work. Every property tells a different story, and our job is to translate that story into a number someone can actually act on.</p>',
                'cover' => '2 About Us Page/Image 1.png',
                'gallery' => [
                    '2 About Us Page/Image 2.png',
                    '2 About Us Page/Image 3.png',
                ],
                'status' => 'published',
                'is_featured' => false,
                'published_at' => Carbon::now()->subDays(6),
            ],
            [
                'title' => 'How We Helped a First-Time Buyer Navigate Title Deed Processing',
                'category' => 'Blog',
                'teamMember' => 'Doreen Mpunga',
                'summary' => 'Title registration can be the most confusing part of buying property in Malawi. Here\'s how our team walked one client through it, start to finish.',
                'content' => '<p>Most first-time buyers we meet know how to negotiate a price and arrange financing — but title deed processing is where things usually stall. That was exactly where one of our recent clients found themselves, three months into a purchase with no clear path to actually owning the property on paper.</p>'
                    .'<p>We started with a title search to confirm there were no competing claims or outstanding encumbrances on the land — a step that\'s easy to skip and expensive to regret. Everything checked out, so we moved straight into preparing the application package.</p>'
                    .'<p>From there it was a matter of staying on top of the registry. We followed up directly with the land registry office roughly every two weeks, which is usually the difference between a six-week process and a six-month one. Our client got weekly updates the entire way, so there was never a moment of wondering what was happening.</p>'
                    .'<p>Eight weeks after we took over the file, the deed was issued. For a first-time buyer, that\'s the moment property ownership stops being a plan and starts being real.</p>',
                'cover' => '6 Our Team Page/Image 2 Our commitment.png',
                'gallery' => [
                    '2 About Us Page/Image 4.png',
                ],
                'status' => 'published',
                'is_featured' => false,
                'published_at' => Carbon::now()->subDays(14),
            ],
            [
                'title' => 'Upcoming Feature: Online Property Valuation Requests',
                'category' => 'Announcement',
                'summary' => 'We are working on a self-service valuation request tool for the website, expected to launch later this year.',
                'content' => '<p>We are developing a new feature that will let clients request a property valuation directly through our website, without needing to call or email our office first.</p><p>Stay tuned for updates as we roll this out in the coming months.</p>',
                'cover' => '1 Home Page/CTA Image.png',
                'status' => 'draft',
                'is_featured' => false,
                'published_at' => null,
            ],
        ];

        foreach ($announcements as $entry) {
            $teamMemberId = isset($entry['teamMember'])
                ? TeamMember::where('name', $entry['teamMember'])->value('id')
                : null;

            $announcement = Announcement::create([
                'title' => $entry['title'],
                'category' => $entry['category'],
                'team_member_id' => $teamMemberId,
                'summary' => $entry['summary'],
                'content' => $entry['content'],
                'cover_image' => $media->upload($this->fakeUpload($entry['cover']), 'announcements/featured'),
                'status' => $entry['status'],
                'is_featured' => $entry['is_featured'],
                'published_at' => $entry['published_at'],
            ]);

            foreach (($entry['gallery'] ?? []) as $i => $galleryFile) {
                AnnouncementImage::create([
                    'announcement_id' => $announcement->id,
                    'image_path' => $media->upload($this->fakeUpload($galleryFile), 'announcements/gallery'),
                    'sort_order' => $i,
                ]);
            }
        }
    }

    /**
     * Wraps an existing file under public/brand-assets/ as an UploadedFile
     * so it can be fed through MediaService::upload() exactly like a real
     * CMS upload — produces real thumbnail/medium/large.webp variants
     * instead of leaving seeded posts pointing at nothing.
     */
    private function fakeUpload(string $relativePath): UploadedFile
    {
        $path = public_path('brand-assets/'.$relativePath);

        return new UploadedFile($path, basename($path), null, null, true);
    }
}
