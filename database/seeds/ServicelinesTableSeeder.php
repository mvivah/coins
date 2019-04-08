<?php

use Illuminate\Database\Seeder;
use App\Serviceline;
use App\User;
class ServicelinesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::getCreator();
        $servicelines = [
            ['id' => 1,'beneficiary'=>'Business Development','service_code'=>201, 'service_name' => 'Lead Generation', 'created_by' => $user],
            ['id' => 2,'beneficiary'=>'Business Development','service_code'=>202, 'service_name' => 'Lead qualification', 'created_by' => $user],
            ['id' => 3,'beneficiary'=>'Business Development','service_code'=>203, 'service_name' => 'Information Search', 'created_by' => $user],
            ['id' => 4,'beneficiary'=>'Business Development','service_code'=>204, 'service_name' => 'Submissions', 'created_by' => $user],
            ['id' => 6,'beneficiary'=>'Opportunities','service_code'=>101, 'service_name' => 'Monitoring & Evaluation Services', 'created_by' => $user],
            ['id' => 7,'beneficiary'=>'Opportunities','service_code'=>102, 'service_name' => 'Surveys and Research', 'created_by' => $user],
            ['id' => 8,'beneficiary'=>'Opportunities','service_code'=>103, 'service_name' => 'Policy Analysis and Design', 'created_by' => $user],
            ['id' => 9,'beneficiary'=>'Opportunities','service_code'=>104, 'service_name' => 'Public Administration', 'created_by' => $user],
            ['id' => 10,'beneficiary'=>'Opportunities','service_code'=>105, 'service_name' => 'Procurement Agent Services', 'created_by' => $user],
            ['id' => 11,'beneficiary'=>'Opportunities','service_code'=>106, 'service_name' => 'Procurement Audit Services', 'created_by' => $user],
            ['id' => 12,'beneficiary'=>'Opportunities','service_code'=>107, 'service_name' => 'Procurement Advisory Services', 'created_by' => $user],
            ['id' => 13,'beneficiary'=>'Opportunities','service_code'=>108, 'service_name' => 'IT/IS Design and or Supervision', 'created_by' => $user],
            ['id' => 14,'beneficiary'=>'Opportunities','service_code'=>109, 'service_name' => 'IT/IS Audits or Assessments', 'created_by' => $user],
            ['id' => 15,'beneficiary'=>'Opportunities','service_code'=>110, 'service_name' => 'Project Management', 'created_by' => $user],
            ['id' => 16,'beneficiary'=>'Opportunities','service_code'=>111, 'service_name' => 'IT/IS Implementation', 'created_by' => $user],
            ['id' => 17,'beneficiary'=>'Opportunities','service_code'=>112, 'service_name' => 'Software development', 'created_by' => $user],
            ['id' => 18,'beneficiary'=>'Opportunities','service_code'=>113, 'service_name' => 'Financial Management and Accountancy', 'created_by' => $user],
            ['id' => 19,'beneficiary'=>'Opportunities','service_code'=>114, 'service_name' => 'Marketing Consultancy', 'created_by' => $user],
            ['id' => 20,'beneficiary'=>'Opportunities','service_code'=>115, 'service_name' => 'Business Process Modelling', 'created_by' => $user],
            ['id' => 21,'beneficiary'=>'Opportunities','service_code'=>116, 'service_name' => 'Special Audits', 'created_by' => $user],
            ['id' => 22,'beneficiary'=>'Opportunities','service_code'=>117, 'service_name' => 'Recruitment Services', 'created_by' => $user],
            ['id' => 23,'beneficiary'=>'Opportunities','service_code'=>118, 'service_name' => 'Human Resource Management Services', 'created_by' => $user],
            ['id' => 24,'beneficiary'=>'Opportunities','service_code'=>119, 'service_name' => 'Training & Capacity Building Services', 'created_by' => $user],
            ['id' => 25,'beneficiary'=>'Opportunities','service_code'=>120, 'service_name' => 'Strategy and Business Transformation', 'created_by' => $user],
            ['id' => 26,'beneficiary'=>'Opportunities','service_code'=>121, 'service_name' => 'Organisation Development', 'created_by' => $user],
            ['id' => 27,'beneficiary'=>'Opportunities','service_code'=>122, 'service_name' => 'Environment, Health and Safety', 'created_by' => $user],
            ['id' => 28,'beneficiary'=>'Opportunities','service_code'=>123, 'service_name' => 'Investment Advisory', 'created_by' => $user],
            ['id' => 29,'beneficiary'=>'Opportunities','service_code'=>124, 'service_name' => 'Project identification and Design', 'created_by' => $user],
            ['id' => 30,'beneficiary'=>'Administration','service_code'=>301, 'service_name' => 'Annual Leave', 'created_by' => $user],
            ['id' => 31,'beneficiary'=>'Administration','service_code'=>302, 'service_name' => 'Sick Leave', 'created_by' => $user],
            ['id' => 32,'beneficiary'=>'Administration','service_code'=>303, 'service_name' => 'Training', 'created_by' => $user],
            ['id' => 33,'beneficiary'=>'Administration','service_code'=>304, 'service_name' => 'Corporate Affairs- Legal', 'created_by' => $user],
            ['id' => 34,'beneficiary'=>'Administration','service_code'=>305, 'service_name' => 'Corporate Affairs- Human Resources', 'created_by' => $user],
            ['id' => 35,'beneficiary'=>'Administration','service_code'=>306, 'service_name' => 'Corporate Affairs- Finance', 'created_by' => $user],
            ['id' => 36,'beneficiary'=>'Administration','service_code'=>307, 'service_name' => 'Corporate Affairs- Administration', 'created_by' => $user],
            ['id' => 37,'beneficiary'=>'Administration','service_code'=>308, 'service_name' => 'Corporate Affairs- Management', 'created_by' => $user],
            ['id' => 38,'beneficiary'=>'Administration','service_code'=>309, 'service_name' => 'Corporate Affairs- IT Support', 'created_by' => $user],
            ['id' => 39,'beneficiary'=>'Administration','service_code'=>310, 'service_name' => 'No Work', 'created_by' => $user],
            ['id' => 40,'beneficiary'=>'Administration','service_code'=>311, 'service_name' => 'Time off', 'created_by' => $user],
            ['id' => 41,'beneficiary'=>'Administration','service_code'=>312, 'service_name' => 'Meetings', 'created_by' => $user],
            ['id' => 42,'beneficiary'=>'Administration','service_code'=>313, 'service_name' => 'Study Leave', 'created_by' => $user],
            ['id' => 43,'beneficiary'=>'Administration','service_code'=>314, 'service_name' => 'Public Holiday', 'created_by' => $user],
        ];
        foreach($servicelines as $serviceline){
            Serviceline::create($serviceline);
        }
    }
}
