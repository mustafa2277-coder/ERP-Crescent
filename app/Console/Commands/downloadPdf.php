<?php

namespace App\Console\Commands;
use PDF;
use DB;
use Illuminate\Console\Command;

class downloadPdf extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'download:pdf';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Custom command to Download PDF';

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
        $journalItems = DB::table('journalentries')

        ->join('journalentrydetail', 'journalentries.id', '=', 'journalentrydetail.journalEntryId')
        ->leftJoin('project', 'journalentries.projectId', '=', 'project.id')
        ->join('journal', 'journalentries.journalId', '=', 'journal.id')
        ->join('accounthead', 'journalentrydetail.accHeadId', '=', 'accounthead.id')

        ->select('journalentries.*', 'journalentries.date_post as entryDate', 'journalentries.id as id','journalentries.entryNum as entryNum','project.title as project','journal.name as journal','journalentrydetail.amount as amount','accounthead.name as account','journalentrydetail.isDebit as isDebit'

            )
        ->get();
        $date='testing'.date('s').'New.pdf';
        $pdf = PDF::loadView('pdfJournalItem',compact('journalItems'))->save($date);
        return $pdf;
    }
}
