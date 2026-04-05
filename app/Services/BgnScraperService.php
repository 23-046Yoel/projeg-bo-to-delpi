<?php

namespace App\Services;

use App\Models\News;
use Illuminate\Support\Facades\Http;
use Symfony\Component\DomCrawler\Crawler;

class BgnScraperService
{
    public function scrape()
    {
        $url = 'https://bgn.go.id/news';
        $response = Http::get($url);

        if (!$response->successful()) {
            return false;
        }

        $crawler = new Crawler($response->body());
        
        // Updated selectors based on Astro/Tailwind structure observed
        $crawler->filter('a[href^="/news/"]')->each(function (Crawler $node) {
            $link = $node->attr('href');
            
            // Safer title extraction
            $titleNode = $node->filter('h1, h2, h3, .title, img');
            $title = '';
            if ($titleNode->count() > 0) {
                $title = $titleNode->first()->attr('alt') ?? $titleNode->first()->text('');
            } else {
                $title = $node->text('');
            }
            
            // Try to find the closest container for snippet and date if they exist
            $container = $node->closest('div, article, section');
            $snippet = '';
            if ($container && $container->filter('p, .description, .snippet')->count() > 0) {
                $snippet = $container->filter('p, .description, .snippet')->first()->text('');
            }
            
            $date = '';
            if ($container && $container->filter('time, .date, .timestamp')->count() > 0) {
                $date = $container->filter('time, .date, .timestamp')->first()->text('');
            }

            if ($title && $link && trim($title) !== '') {
                // Ensure full URL
                if (str_starts_with($link, '/')) {
                    $link = 'https://bgn.go.id' . $link;
                }

                News::updateOrCreate(
                    ['url' => $link],
                    [
                        'title' => trim($title),
                        'published_at' => trim($date),
                        'snippet' => trim($snippet),
                    ]
                );
            }
        });

        return true;
    }
}
