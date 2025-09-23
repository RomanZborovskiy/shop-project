<?php

namespace App\Actions;


use App\Models\Page;
use App\Models\Post;
use App\Models\Product;
use App\Models\Term;
use Lorisleiva\Actions\Concerns\AsAction;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class GenerateSitemapAction
{
    use AsAction;

    public string $commandSignature = 'sitemap:generate';

    public function handle(): string
    {
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

        Storage::disk('public')->put('sitemap.xml', $xml);
        Log::info('Виконується генерація sitemap о ' . now());

        return Storage::disk('public')->url('sitemap.xml');
    }

    public function asCommand($command): int
    {
        $command->info('Generating sitemap...');

        $sitemapPath = $this->handle();

        $command->info('Sitemap generated successfully!');
        $command->info("Location: " . $sitemapPath);

        return 0;
    }

    public function asJob(): void
    {
        $this->handle();
    }
}