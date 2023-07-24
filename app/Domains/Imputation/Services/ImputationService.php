<?php

namespace App\Domains\Imputation\Services;

use App\Services\BaseService;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Domains\Imputation\Models\Imputation;

/**
 * Class AnnouncementService.
 */
class ImputationService extends BaseService
{
    /**
     * ImputationService constructor.
     *
     * @param  Imputation  $Imputation
     */
    public function __construct(Imputation $imputation)
    {
        $this->model = $imputation;
    }

    public function all()
    {
        return $this->model::orderBy('created_at', 'DESC')->paginate(10);
    }

    public function create(Array $imputation)
    {
        return $this->model::create($imputation);
    }

    public function find(int $id)
    {
        return $this->model::find($id);
    }

    public function delete(Imputation $imputation)
    {
        return $imputation->delete();
    }

    public function active()
    {
        return Imputation::active()->orderBy('created_at', 'DESC')->paginate(10);
    }

    public function getPrint(Imputation $imputation)
    {
       return  Pdf::loadView('backend.imputations.print',compact('imputation'));
    }

}
