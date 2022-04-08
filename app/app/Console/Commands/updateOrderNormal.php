<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Order;
use Carbon\Carbon;


class updateOrderNormal extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:updateOrderNormal';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {

        $ordersProcess = Order::whereRaw('updated_at + interval 3 day < ?', [Carbon::now()])->process()->get();

        $ordersAccepted = Order::whereRaw('updated_at + interval 3 day < ?', [Carbon::now()])->accepted()->get();

        $ordersFinalized = Order::whereRaw('updated_at + interval 14 day < ?', [Carbon::now()])->shipped()->get();


        foreach($ordersProcess as $order) {
            $order->status ="cancelled";
            $order->save();
        }

        foreach($ordersAccepted as $order) {
            $order->status ="cancelled";
            $order->save();
        }

        foreach($ordersFinalized as $order) {
            $order->status ="finalized";
            $order->save();
        }



    }
}
