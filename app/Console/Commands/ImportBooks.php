<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\BooksImport;

class ImportBooks extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:books {file}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import books from an Excel file';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $file = $this->argument('file');

        if (!file_exists($file)) {
            $this->error("File not found: {$file}");
            return;
        }

        try {
            Excel::import(new BooksImport, $file);
            $this->info('Books imported successfully!');
        } catch (\Exception $e) {
            $this->error('An error occurred during import: ' . $e->getMessage());
        }
    }
}
