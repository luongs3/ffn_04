<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\Export\ExportRepositoryInterface;

class ExportController extends Controller
{
    private $exportRepository;

    public function __construct(ExportRepositoryInterface $exportRepository)
    {
        $this->exportRepository = $exportRepository;
    }

    public function index()
    {
        $subject = request()->get('subject');
        $this->exportRepository->export($subject);
    }
}
