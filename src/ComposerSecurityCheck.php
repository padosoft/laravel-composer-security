<?php

namespace Padosoft\Composer;

use Illuminate\Console\Command;
use Mail;
use File;
use Mockery\CountValidator\Exception;
use Validator;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Exception\ClientException;
use Config;


class ComposerSecurityCheck extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'composer-security:check
                            {path? : path where find composer.lock, you can use * as jolly character i.e. "/var/www/*/*/", use quotation marks}
                            {--M|mail= : If you want send result to email}
                            {--w|whitelist= : If you want exclude from alarm some paths, divide by ","}'
                            ;

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = <<<EOF
The <info>composer-security:check</info> command looks for every composer.lock file in the given path
and foreach composer.lock check for security issues in the project dependencies:
<info>php composer-security:check</info>
If you omit path argument, command look into current folder.
You can also pass the path as an argument:
<info>php composer-security:check /path/to/my/repos</info>
You can use <info>*</info> in path argument as jolly character i.e. <info>/var/www/*/*/</info>
By default, the command displays the result in console, but you can also
send an html email by using the <info>--mail</info> option:
<info>php composer-security:check /path/to/my/repos --mail=mymail@mydomain.me</info>
EOF;


    /**
     * @var Client an istance of GuzzleHttp\Client
     */
    protected $guzzle;

    /**
     * @var array
     */
    protected $headersTableConsole = ['name', 'version', 'title', 'whitelist'];

    /**
     * @var array
     */
    protected $tableVulnerabilities = [];

    /**
     * Create a new command instance.
     *
     * @param Client $objguzzle
     */
    public function __construct(Client $objguzzle)
    {
        $this->guzzle = $objguzzle;
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->hardWork($this->argument(),$this->option());
    }

    /**
     * @param $argument
     * @param $option
     */
    private function hardWork($argument,$option)
    {

        $this->line('path: <info>'.$argument['path'].'</info>.\nCheck composer.lock files...');
        $lockFiles = $this->findFilesComposerLock($argument['path']);
        $this->line('Find <info>'.count($lockFiles).'</info> composer.lock files.');

        $this->tableVulnerabilities = [];
        $tuttoOk = true;
        $numLock=0;

        //whitelist

        $whitelist = $this->adjustWhiteList($option['whitelist']);

        foreach ($lockFiles as $fileLock) {
            $this->line("Analizing <info>".($numLock+1)."</info> di <info>".count($lockFiles)."</info>: $fileLock ...");
            $this->tableVulnerabilities[] = [
                'name' => $fileLock,
                'version' => '',
                'advisories' => '',
                'isOk' => ''
            ];

            $sensiolab = new SensiolabHelper($this->guzzle,$this);
            $response = $sensiolab->getSensiolabVulnerabilties($fileLock);

            if (($response==null) | !is_array($response)) {
                $this->error("Errore Response not vaild or null.");
                continue;
            }
            if (count($response)>0) {
                $this->error("Trovate ".count($response)." vulnerabilita' in $fileLock");
            }

            foreach ($response as $key => $vulnerability) {
                $tuttoOk = in_array(rtrim(str_replace('\\','/',$fileLock),'composer.lock'),$whitelist);

                foreach($sensiolab->parseVulnerability($key, $vulnerability) as $vul) {
                    $this->tableVulnerabilities[]=array_merge($vul,array('isOk'=>$tuttoOk));
                }
            }
            $numLock++;
        }

        $this->notifyResult($option['mail'],$tuttoOk);

    }

    private function adjustWhiteList($white)
    {
        $whitelist = array();
        if($white!='') {
            $w = explode(",",str_replace('\\','/',$white));
            foreach($w as $item)  {
                $whitelist[] = str_finish($item,'/');
            }
        }
        return $whitelist;
    }

    private function notifyResult($mail,$tuttoOk)
    {
        $esito=Config::get('composer-security-check.mailSubjectSuccess');

        if (!$tuttoOk) {
            $esito=Config::get('composer-security-check.mailSubjetcAlarm');
            $this->error($esito);
        }
        else {
            $this->line($esito);
        }

        //print to console
        $this->table($this->headersTableConsole, $this->tableVulnerabilities);

        //send email
        $this->sendEmail($mail,$tuttoOk);
    }

    private function sendEmail($mail,$tuttoOk)
    {
        if($mail!='') {
            $email = new MailHelper($this);
            $email->sendEmail($tuttoOk, $mail, $this->tableVulnerabilities);
        }
    }

    /**
     *
     * @return array of composer.lock file
     */
    private function findFilesComposerLock($path)
    {
        $file = new FileHelper();
        return $file->findFiles($path,'composer.lock');
    }




}

