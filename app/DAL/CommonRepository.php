<?php

namespace App\DAL;

use App\Exceptions\CustomMessageException;
use Illuminate\Support\Facades\DB;
use Auth;
use Illuminate\Support\Facades\Session;

class CommonRepository
{

    public $success                = 'success';
    public $unableToSave           = 'Unable to save record. Please try again.';
    public $unableToUpdate         = 'Unable to update record. Please try again.';
    public $unableToDelete         = 'Unable to delete record.Please try again.';
    public $unableToGetData        = 'Unable to get records. Please try again.';
    public $unauthorizedAccess     = 'Unauthorized access.';
    public $canNotFindUser         = 'We cannot find user with that email address.';
    public $unableToSetCredentials = 'Unable to set password. Please try again.';
    public $invalidOldCredentials  = 'Invalid old password. Please try using correct old password.';
    public $incorrectCredentials   = 'Password is incorrect. Please try again.';
    public $accountDeactivated     = 'Account associated with this email is de-active. Please check your email if you are a newly registered user or contact admin for more details.';
    public $unableToLogin          = 'Unable to login. Please check your credentials.';

    /**
     * GET ERROR MESSAGE
     * @param $message
     * @return array
     */
    public function getErrorMessage($message)
    {
        return [
            $this->success    => false,
            'error'      => [
                'statusCode' => 102,
                'message'    => $message
            ]
        ];
    }

    /**
     * CHECK RECORD EXISTS OR NOT
     * @param $toBeUpdatedId
     * @param $tableName
     * @return bool
     */
    public function recordExists($toBeUpdatedId, $tableName)
    {
        return DB::table($tableName)->where('id', $toBeUpdatedId)->whereNull('deleted_at')->first();
    }

    /**
     * THROWS CUSTOM MESSAGE EXCEPTION.
     * @param $message
     * @throws CustomMessageException
     */
    public function throwCustomMessageException($message){
        throw new CustomMessageException($message);
    }

}
