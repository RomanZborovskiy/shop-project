<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class TaxonomySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->seedVocabularies([
            // CATEGORIES
            [
                'vocabulary' => 'categories',
                'terms' => [
                    [
                        'name' => 'Electronics',
                        'terms' => ['Alarms', 'DVRs', 'Audio'],
                    ],
                    [
                        'name' => 'Autochemistry',
                        'terms' => ['Washer', 'Shampoos', 'Polishes'],
                    ],
                    [
                        'name' => 'Wheels and rims',
                    ],
                ],
            ],
        ]);
    }

    /**
     * @param array $vocabularies
     */
    protected function seedVocabularies(array $vocabularies)
    {
        foreach ($vocabularies as $item) {
            if (! empty($item['terms'])) {
                $this->seedTerms($item['terms'], $item['vocabulary']);
            }
        }
    }

    /**
     * @param array $terms
     * @param string $vocabulary
     * @param null $parentId
     */
    protected function seedTerms(array $terms, string $vocabulary, $parentId = null)
    {
        $termModelClass = config('taxonomy.term_model');

        foreach ($terms as $item) {
            if (is_array($item)) {
                $term = $termModelClass::updateOrCreate([
                    'name' => $item['name'],
                    'vocabulary' => Arr::get($item, 'vocabulary', $vocabulary),
                ], [
                    'slug' => isset($item['slug'])
                        ? Str::slug($item['slug'], '-')
                        : Str::slug($item['name'], '-'),
                    'description' => Arr::get($item, 'description'),
                    'parent_id' => $parentId,
                ]);
            } else {
                $term = $termModelClass::updateOrCreate([
                    'name' => $item,
                    'vocabulary' => $vocabulary,
                ], [
                    'slug' => Str::slug($item),
                    'parent_id' => $parentId,
                ]);
            }

            $this->command->info(" - Term saved: {$term->id}: $term->name [{$term->vocabulary}]");

            if (! empty($item['terms'])) {
                $this->seedTerms($item['terms'], $vocabulary, $term->id);
            }
        }
    }
}
