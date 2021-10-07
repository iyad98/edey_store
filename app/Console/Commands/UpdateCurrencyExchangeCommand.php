<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

// models
use App\User;

use App\Services\CurrencyService\CurrencyExchange;

class UpdateCurrencyExchangeCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'UpdateCurrencyExchangeCommand:update-currency-exchange-command';

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

        $currency_service = new CurrencyExchange();
        $currency_service->update_currency_exchange();

    }
}
