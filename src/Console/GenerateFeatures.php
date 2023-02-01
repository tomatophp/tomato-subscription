<?php

namespace TomatoPHP\TomatoSubscription\Console;

use Illuminate\Console\Command;
use TomatoPHP\TomatoSubscription\Models\PlanFeature;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class GenerateFeatures extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $name = 'tomato-feature:generate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'To Generate all features for plans';


    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $features = $this->ask('Enter features key separated by comma (,)');

        foreach (explode(',', $features) as $feature) {
            $newFeature = new PlanFeature();
            $newFeature->name = $feature;
            $newFeature->key = $feature;
            $newFeature->save();
        }

        $this->info('🍅 Features generated successfully!');
    }


}
