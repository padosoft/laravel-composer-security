<?php
/**
 * Created by PhpStorm.
 * User: Alessandro
 * Date: 03/12/2015
 * Time: 17:25
 */

namespace Padosoft\LaravelComposerSecurity;

use Config;
use Validator;
use Illuminate\Console\Command;
use Mail;

class MailHelper
{

    protected $command;

    /**
     *
     */
    public function setUp()
    {
        parent::setUp();
    }

    /**
     * MailHelper constructor.
     * @param Command $objcommand
     */
    public function __construct(Command $objcommand)
    {
        $this->command = $objcommand;
    }

    /**
     * @param $tuttoOk
     * @param $mail
     * @param $vul
     */
    public function sendEmail($tuttoOk, $mail, $vul)
    {
        $soggetto=Config::get('composer-security-check.mailSubjectSuccess');

        if (!$tuttoOk) {
            $soggetto=Config::get('composer-security-check.mailSubjetcAlarm');
        }

        $validator = Validator::make(['email' => $mail], [
            'email' => 'required|email',
        ]);
        if ($validator->fails()) {
            $this->command->error('No valid email passed: '.$mail.'. Mail will not be sent.');
            return;
        }
        $this->command->line('Send email to <info>'.$mail.'</info>');

        Mail::send(
            Config::get('composer-security-check.mailViewName'),
            ['vul' => $vul],
            function ($message) use ($mail, $soggetto) {
                $message->from(
                    Config::get('composer-security-check.mailFrom'),
                    Config::get('composer-security-check.mailFromName')
                );
                $message->to($mail, $mail);
                $message->subject($soggetto);
            }
        );


        $this->command->line('email sent.');

    }
}
