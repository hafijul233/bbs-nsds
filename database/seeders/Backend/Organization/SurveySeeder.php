<?php

namespace Database\Seeders\Backend\Organization;

use App\Models\Backend\Organization\Survey;
use Illuminate\Database\Seeder;

class SurveySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $surveys = [
            ['id' => '1', 'name' => 'Cost of Migration Survey', 'enabled' => 'yes'],
            ['id' => '2', 'name' => 'Distributive Trade Survey', 'enabled' => 'yes'],
            ['id' => '3', 'name' => 'Hotel and Restaurant survey', 'enabled' => 'yes'],
            ['id' => '4', 'name' => 'Household Income and Expenditure Survey', 'enabled' => 'yes'],
            ['id' => '5', 'name' => 'Improvement of GDP Compilation and Rebasing of Indices', 'enabled' => 'yes'],
            ['id' => '6', 'name' => 'Improving Labour Market Information through Labour Force Survey (LFS)', 'enabled' => 'yes'],
            ['id' => '7', 'name' => 'Measuring ICT Access and Use by Households and Individuals', 'enabled' => 'yes'],
            ['id' => '8', 'name' => 'Multiple Indicator Cluster Survey (MICS)', 'enabled' => 'yes'],
            ['id' => '9', 'name' => 'National Hygiene survey', 'enabled' => 'yes'],
            ['id' => '10', 'name' => 'National Survey on Persons with Disabilities', 'enabled' => 'yes'],
            ['id' => '11', 'name' => 'Pilot Survey on SADDD and CCA & DRR', 'enabled' => 'yes'],
            ['id' => '12', 'name' => 'Report on Sample Vital Registration System (SVRS)', 'enabled' => 'yes'],
            ['id' => '13', 'name' => 'Report on the Survey of Private Healthcare Institutions', 'enabled' => 'yes'],
            ['id' => '14', 'name' => 'Strengthening of Environment, Climate Change and Disaster Related Statistics', 'enabled' => 'yes'],
            ['id' => '15', 'name' => 'Survey of Manufacturing Industries (SMI)', 'enabled' => 'yes'],
            ['id' => '16', 'name' => 'Survey of Travel Agent, Tour Operator and Clearing & Forwarding Agent', 'enabled' => 'yes'],
            ['id' => '17', 'name' => 'Survey on Gross Marketed Surplus of Agricultural Commodities', 'enabled' => 'yes'],
            ['id' => '18', 'name' => 'Survey on Private Commercial Mechanized and Non-Mechanized and Water Transport', 'enabled' => 'yes'],
            ['id' => '19', 'name' => 'Survey on Private Health Service Establishment', 'enabled' => 'yes'],
            ['id' => '20', 'name' => 'Time Use Survey', 'enabled' => 'yes'],
            ['id' => '21', 'name' => 'Tourism Satellite Account', 'enabled' => 'yes'],
            ['id' => '22', 'name' => 'Urban Socioeconomic Assessment Survey', 'enabled' => 'yes'],
            ['id' => '23', 'name' => 'Determination of Causes of Deaths by Verbal Autopsy (VA)', 'enabled' => 'yes'],
            ['id' => '24', 'name' => 'Perception Survey on Livelihood (PSL)', 'enabled' => 'yes'],
            ['id' => '25', 'name' => 'User Satisfaction Survey', 'enabled' => 'yes'],
            ['id' => '26', 'name' => 'Wholesale and Retail Trade Survey', 'enabled' => 'yes'],
        ];

        foreach ($surveys as $survey) {
            Survey::create($survey);
        }
    }
}
