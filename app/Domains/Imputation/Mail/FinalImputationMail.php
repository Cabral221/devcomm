<?php

namespace App\Domains\Imputation\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Http\UploadedFile;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Domains\Imputation\Models\Imputation;

class FinalImputationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $path;
    public $demandeur;
    public $hashName;


    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Imputation $imputation, $hashName = null)
    {
        $this->demandeur = $imputation->last_name;

        if($hashName !== null){
            $this->path = storage_path("app\public\imputations\\") . $this->hashName;
        }else{
            $fileName = basename(asset($imputation->file));
            $this->path = storage_path("app\public\imputations\\") . $fileName;
        }
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('IMPUTATIUON BUDGETAIRE DISPONIBLE ! MDCSNEST')
            ->markdown('emails.finalImputation')
            ->attach($this->path, [
                'as' => $this->hashName,
                'mime' => 'application/pdf'
            ]);
    }
}
