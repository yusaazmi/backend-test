<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Approver;
use App\Models\ApprovalStage;
use App\Models\Status;
use App\Models\Expense;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Faker\Factory as FakerFactory;

class ApiTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function testApproverAndApprovalStageCreation()
    {
         // Data status yang akan disimpan
        $statuses = [
            ['name' => 'menunggu persetujuan'],
            ['name' => 'disetujui'],
        ];

        // Looping melalui data status dan menyimpannya menggunakan rute 'approval.store-status'
        foreach ($statuses as $status) {
            $response = $this->postJson(route('approval.store-status'), $status);

            // Periksa bahwa respons memiliki status 201 (Created)
            $response->assertStatus(200);
        }

        // Pastikan bahwa dua status telah disimpan di dalam basis data
        $this->assertCount(2, Status::all());
        $approvers = [
            ['name' => 'Ana'],
            ['name' => 'Ani'],
            ['name' => 'Ina'],
        ];

        foreach ($approvers as $approverData) {
            $response = $this->postJson(route('approvers.store'), $approverData);
            $response->assertStatus(200);
        }

        // Memastikan data approver telah tersimpan
        $this->assertCount(3, Approver::all());

        // Memeriksa pembuatan stage approval
        $approver = Approver::pluck('id')->toArray();
        foreach($approver as $ap){
            $response = $this->postJson(route('approval-stages.store'), [
                'approver_id' => $ap,
            ]);
            $response->assertStatus(200);
        }
         // Mendapatkan urutan approver sesuai dengan approver-stage
        $approverStageOrder = ApprovalStage::orderBy('id','asc')->pluck('id','approver_id')->toArray();

        // Kasus 1: Pengeluaran pertama, disetujui oleh semua approver. Pastikan status pengeluarannya disetujui.
        $expense1 = Expense::create(['amount' => 1000,'status_id' => 1]);
        foreach ($approverStageOrder as $approverId) {
            $response = $this->patchJson(route('expense.approve', ['id' => $expense1->id]), ['approver_id' => $approverId]);
            $response->assertStatus(200);
        }
        $this->assertEquals('disetujui', $expense1->fresh()->status->name);

        // Kasus 2: Pengeluaran kedua, disetujui oleh dua approver. Pastikan status pengeluarannya menunggu persetujuan.
        $expense2 = Expense::create(['amount' => 1500,'status_id' => 1]);
        $approvedApprovers = array_slice($approverStageOrder, 0, 2);
        foreach ($approvedApprovers as $approverId) {
            $response = $this->patchJson(route('expense.approve', ['id' => $expense2->id]), ['approver_id' => $approverId]);
            $response->assertStatus(200);
        }
        $this->assertEquals('menunggu persetujuan', $expense2->fresh()->status->name);

        // Kasus 3: Pengeluaran ketiga, disetujui oleh satu approver. Pastikan status pengeluarannya menunggu persetujuan.
        $expense3 = Expense::create(['amount' => 2000,'status_id' => 1]);
        $approvedApprovers = array_slice($approverStageOrder, 0, 1);
        foreach ($approvedApprovers as $approverId) {
            $response = $this->patchJson(route('expense.approve', ['id' => $expense3->id]), ['approver_id' => $approverId]);
            $response->assertStatus(200);
        }
        $this->assertEquals('menunggu persetujuan', $expense3->fresh()->status->name);

        // Kasus 4: Pengeluaran keempat, belum disetujui oleh approver. Pastikan status pengeluarannya menunggu persetujuan.
        $expense4 = Expense::create(['amount' => 2500,'status_id' => 1]);
        $this->assertEquals('menunggu persetujuan', $expense4->fresh()->status->name);
    }
}
