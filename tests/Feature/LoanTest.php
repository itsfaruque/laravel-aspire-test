<?php

namespace Tests\Feature;

use App\Loan;
use App\Repayment;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LoanTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testLoanCreation()
    {
        factory(User::class,5)->create();
        factory(Loan::class,14)->create();
        $open = factory(Loan::class,1)->create(['status'=>'open']);
        factory(Repayment::class,33)->create();
        factory(Repayment::class,2)->create(['loan_id'=>15]);

        $loan = Loan::openLoan()->get();

        $this->assertEquals($open[0]->id, $loan[0]->id);
    }

    public function testFetch()
    {
        $response = $this->get('/loan/fetch/1/processing');
        $response = $this->get('/loan/fetch/1/closed');
        $response = $this->get('/loan/fetch/1/closed');
        $response = $this->get('/repayment/fetch/1');
        $response = $this->get('/repayment/fetch/5');

        $this->assertSame(200, $response->status());
    }
}
