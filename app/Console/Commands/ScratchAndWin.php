<?php

namespace App\Console\Commands;

use App\Models\ScratchAndWin as ModelsScratchAndWin;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class ScratchAndWin extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ScratchAndWin:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Aggiorna il listino dei gratta e vinci disponibili';

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
     * @return int
     */
    public function handle()
    {
        $this->call('config:cache');
       foreach( \Config::get('scratchAndWinApp') as $singleScratchAndWin )
       {
           if(!is_array($singleScratchAndWin) ) continue ;
           $scratchAndWinFound = ModelsScratchAndWin::where('token',$singleScratchAndWin['token'])->get()->first();
            if( !$scratchAndWinFound )
            {
                ModelsScratchAndWin::create($singleScratchAndWin);
                continue ;
            }
            $scratchAndWinFound->name = $singleScratchAndWin['name'];
            $scratchAndWinFound->prize = $singleScratchAndWin['prize'];
            $scratchAndWinFound->save();
            
        }
        return ;
    }
}
