<?php

namespace App\Console\Commands;

use App\Models\Post;
use App\Models\Term;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use App\Models\Page;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Collection;

class GenerateSitemap extends Command
{
    protected $signature = 'sitemap:generate';

    protected $description = 'Generate a sitemap.xml for the application.';

    public function handle()
    {
        $this->info('Generating sitemap...');

        $urls = [];

        foreach (Page::cursor() as $page) {
            $urls[] = [
                'loc' => url()->to($page->slug), 
                'lastmod' => $page->updated_at->toAtomString(),
            ];
        }

        foreach (Term::cursor() as $category) {
            $urls[] = [
                'loc' => url()->to('catalog/' . $category->slug), 
                'lastmod' => $category->updated_at->toAtomString(),
            ];
        }

        foreach (Product::cursor() as $product) {
            $urls[] = [
                'loc' => url()->to('product/' . $product->slug),
                'lastmod' => $product->updated_at->toAtomString(),
            ];
        }

        foreach (Post::cursor() as $post) {
            $urls[] = [
                'loc' => url()->to('posts/' . $post->slug),
                'lastmod' => $post->updated_at->toAtomString(),
            ];
        }

        $xml = view('admin.sitemap.xml', compact('urls'))->render();
        Log::info('Виконується генераця карта сайту о ' . now());

        Storage::disk('public')->put('sitemap.xml', $xml);

        $sitemapPath = Storage::disk('public')->url('sitemap.xml');
        $this->info("Sitemap generated successfully!");
        $this->info("Location: " . $sitemapPath);

        return Command::SUCCESS;
    }
}

