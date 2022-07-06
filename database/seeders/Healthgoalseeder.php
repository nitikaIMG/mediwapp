<?php

namespace Database\Seeders;

use App\Models\HeathGoalModel;
use Illuminate\Database\Seeder;

class Healthgoalseeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        HeathGoalModel::create([
            'health_goals' => 'Vitamins & Supplements',
        ]);
        HeathGoalModel::create([
            'health_goals' => 'Fitness',
        ]);
        HeathGoalModel::create([
            'health_goals' => 'Imunity & wellbeing',
        ]);
        HeathGoalModel::create([
            'health_goals' => 'Weightloss',
        ]);
        HeathGoalModel::create([
            'health_goals' => 'Skincare',
        ]);
        HeathGoalModel::create([
            'health_goals' => 'Ayurveda & Herbs',
        ]);
        HeathGoalModel::create([
            'health_goals' => 'Sports & Nutrition',
        ]);
        HeathGoalModel::create([
            'health_goals' => 'Wellness',
        ]);
    }
}
