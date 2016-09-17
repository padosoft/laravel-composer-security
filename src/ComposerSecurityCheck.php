<?php

namespace Padosoft\LaravelComposerSecurity;

use Illuminate\Console\Command;
use GuzzleHttp\Client;
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
                            {--N|nomailok=false : True if you want send result to email only for alarm, false is default}
                            {--w|whitelist= : If you want exclude from alarm some paths, divide by ","}';

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
        $this->hardWork($this->argument(), $this->option());
    }

    /**
     * @param $argument
     * @param $option
     */
    private function hardWork($argument, $option)
    {
        $path = $argument['path'];
        $this->line('path: <info>' . $path . '</info>.\nCheck composer.lock files...');
        $lockFiles = $this->findFilesComposerLock($path);
        $this->line('Find <info>' . count($lockFiles) . '</info> composer.lock files.');

        $this->tableVulnerabilities = [];
        $tuttoOk = true;
        $numLock = 0;

        $whitelist = FileHelper::adjustPath($option['whitelist']);

        foreach ($lockFiles as $fileLock) {

            $this->line("Analizing <info>" . ($numLock + 1) . "</info> di <info>" . count($lockFiles) . "</info>");

            $tuttoOk = $this->checkFile($fileLock, $whitelist);

            $numLock++;
        }

        $this->notifyResult($option['mail'], $option['nomailok'], $tuttoOk);

    }

    /**
     * @param $mail
     * @param $tuttoOk
     */
    private function notifyResult($mail, $nomailok, $tuttoOk)
    {
        //print to console
        $this->table($this->headersTableConsole, $this->tableVulnerabilities);

        //send email
        if (!$tuttoOk || $nomailok == '' || strtolower($nomailok) != 'true') {
            $this->sendEmail($mail, $tuttoOk);
        }

        $this->notify($tuttoOk);
    }


    private function notify($result)
    {
        if ($result) {
            return $this->notifyOK();
        }

        $this->notifyKO();
    }

    private function notifyOK()
    {
        $esito = Config::get('composer-security-check.mailSubjectSuccess');
        $this->line($esito);
    }

    private function notifyKO()
    {
        $esito = Config::get('composer-security-check.mailSubjetcAlarm');
        $this->error($esito);
    }

    /**
     * @param $mail
     * @param $tuttoOk
     */
    private function sendEmail($mail, $tuttoOk)
    {
        if ($mail != '') {
            $email = new MailHelper($this);
            $email->sendEmail($tuttoOk, $mail, $this->tableVulnerabilities);
        }
    }

    /**
     *
     * @param $path
     * @return array of composer.lock file
     */
    private function findFilesComposerLock($path)
    {
        $file = new FileHelper();
        $lockFiles = array();
        foreach ($file->adjustPath($path) as $item) {
            $lockFiles = array_merge($lockFiles, $file->findFiles($item, 'composer.lock'));
        }


        if (!is_array($lockFiles)) {
            $lockFiles = array();
        }

        return $lockFiles;
    }

    /**
     * @param $fileLock
     * @param $whitelist
     * @return bool
     */
    private function checkFile($fileLock, $whitelist)
    {
        $this->line("Analizing: $fileLock ...");

        $this->tableVulnerabilities[] = [
            'name' => $fileLock,
            'version' => '',
            'advisories' => '',
            'isOk' => ''
        ];

        $sensiolab = new SensiolabHelper($this->guzzle, $this);
        $response = $sensiolab->getSensiolabVulnerabilties($fileLock);

        if (($response === null) | !is_array($response)) {
            $this->error("Errore Response not vaild or null.");
            return true;
        }
        if (count($response) == 0) {
            return true;
        }
        $this->error("Trovate " . count($response) . " vulnerabilita' in $fileLock");

        $tuttoOk = in_array(rtrim(str_replace('\\', '/', $fileLock), 'composer.lock'), $whitelist);

        foreach ($response as $key => $vulnerability) {

            $this->tableVulnerabilities = array_merge($this->tableVulnerabilities,
                $sensiolab->checkResponse($key, $vulnerability, $tuttoOk));
        }

        return $tuttoOk;
    }

}

