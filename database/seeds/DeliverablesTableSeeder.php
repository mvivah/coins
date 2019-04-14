<?php

use Illuminate\Database\Seeder;
use App\Deliverable;
use App\User;
class DeliverablesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::getCreator();
        $deliverables = [
            ['id' => 1, 'deliverable_name' => 'Qualified Lead', 'deliverable_type'=> 'Opportunity','created_by' => $user],
            ['id' => 2, 'deliverable_name' => 'Prepared Proposal', 'deliverable_type'=> 'Opportunity','created_by' => $user],
            ['id' => 3, 'deliverable_name' => 'Prepared EOI', 'deliverable_type'=> 'Opportunity','created_by' => $user],
            ['id' => 4, 'deliverable_name' => 'Prepared Prequalification', 'deliverable_type'=> 'Opportunity','created_by' => $user],
            ['id' => 5, 'deliverable_name' => 'Reviewed Proposal', 'deliverable_type'=> 'Opportunity','created_by' => $user],
            ['id' => 6, 'deliverable_name' => 'Reviewed EOI', 'deliverable_type'=> 'Opportunity','created_by' => $user],
            ['id' => 7, 'deliverable_name' => 'Reviewed Prequalification', 'deliverable_type'=> 'Opportunity','created_by' => $user],
            ['id' => 8, 'deliverable_name' => 'Submitted Proposal', 'deliverable_type'=> 'Opportunity','created_by' => $user],
            ['id' => 9, 'deliverable_name' => 'Submitted EOI', 'deliverable_type'=> 'Opportunity','created_by' => $user],
            ['id' => 10, 'deliverable_name' => 'Submitted Prequalification', 'deliverable_type'=> 'Opportunity','created_by' => $user],
            ['id' => 11, 'deliverable_name' => 'Signed Contract', 'deliverable_type'=> 'Project','created_by' => $user],
            ['id' => 12, 'deliverable_name' => 'Tender document', 'deliverable_type'=> 'Project','created_by' => $user],
            ['id' => 13, 'deliverable_name' => 'Inception Report', 'deliverable_type'=> 'Project','created_by' => $user],
            ['id' => 14, 'deliverable_name' => 'Service report', 'deliverable_type'=> 'Project','created_by' => $user],
            ['id' => 15, 'deliverable_name' => 'Strategic report', 'deliverable_type'=> 'Project','created_by' => $user],
            ['id' => 16, 'deliverable_name' => 'Progress report', 'deliverable_type'=> 'Project','created_by' => $user],
            ['id' => 17, 'deliverable_name' => 'Useability report', 'deliverable_type'=> 'Project','created_by' => $user],
            ['id' => 18, 'deliverable_name' => 'Feasibility report', 'deliverable_type'=> 'Project','created_by' => $user],
            ['id' => 19, 'deliverable_name' => 'Web site/page', 'deliverable_type'=> 'Project','created_by' => $user],
            ['id' => 20, 'deliverable_name' => 'Product prototype', 'deliverable_type'=> 'Project','created_by' => $user],
            ['id' => 21, 'deliverable_name' => 'Design documents', 'deliverable_type'=> 'Project','created_by' => $user],
            ['id' => 22, 'deliverable_name' => 'Technical interpretation', 'deliverable_type'=> 'Project','created_by' => $user],
            ['id' => 23, 'deliverable_name' => 'Investigation report', 'deliverable_type'=> 'Project','created_by' => $user],
        ];
        foreach($deliverables as $deliverable){
            Deliverable::create($deliverable);
        }
    }
}
