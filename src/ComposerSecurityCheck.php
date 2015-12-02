<?php

namespace Padosoft\Composer;

use Illuminate\Console\Command;
use Mail;
use File;
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
                            {--M|mail= : If you want send result to email}'
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
    protected $headersTableConsole = ['name', 'version', 'title'];

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

        $this->line('path: <info>'.$this->argument('path').'</info>.\nCheck composer.lock files...');
        $lockFiles = $this->findFilesComposerLock($this->argument('path'));
        $this->line('Find <info>'.count($lockFiles).'</info> composer.lock files.');

        $this->tableVulnerabilities = [];
        $tuttoOk = true;
        $numLock=0;

        foreach ($lockFiles as $fileLock) {
            $this->line("Analizing <info>".($numLock+1)."</info> di <info>".count($lockFiles)."</info>: $fileLock ...");
            $this->tableVulnerabilities[] = [
                                    'name' => $fileLock,
                                    'version' => '',
                                    'advisories' => ''
            ];

            $sensiolab = new SensiolabHelper($this->guzzle,$this);
            $response = $sensiolab->getSensiolabVulnerabilties($fileLock);
            //$response = $this->getSensiolabVulnerabilties($fileLock);

            if ($response==null | !is_array($response)) {
                $this->error("Errore Response not vaild or null.");
                continue;
            }
            if (count($response)>0) {
                $this->error("Trovate ".count($response)." vulnerabilita' in $fileLock");
            }

            foreach ($response as $key => $vulnerability) {
                $tuttoOk = false;

                $this->parseVulnerability($key, $vulnerability);
                //$this->tableVulnerabilities[]=$sensiolab->parseVulnerability($key, $vulnerability);
                //$this->testoMessaggioMail .= '</td></tr>';
            }
            $numLock++;
        }

        //print to console
        $this->table($this->headersTableConsole, $this->tableVulnerabilities);

        //send email
        $this->sendEmail($tuttoOk);
    }


    /**
     * @param $name
     * @param $vulnerability
     */
    private function parseVulnerability($name, $vulnerability)
    {
        $data = [
            'name' => $name,
            'version' => $vulnerability['version'],
            'advisories' => array_values($vulnerability['advisories'])
        ];

        foreach ($data['advisories'] as $key2 => $advisory) {
            $data2 = [
                'title' => $advisory['title'],
                'link' => $advisory['link'],
                'cve' => $advisory['cve']
            ];

            $dataTable = [
                'name' => $data['name'],
                'version' => $data['version'],
                'advisories' => $data2["title"]
            ];

            $this->addVerboseLog($data['name'] . " " . $data['version'] . " " . $data2["title"], true);
            $this->tableVulnerabilities[] = $dataTable;
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



    /**
     *
     * Send Request to sensiolab and return array of sensiolab vulnerabilities.
     * Empty array if here is no vulnerabilities.
     *
     * @param $fileLock path to composer.lock file.
     *
     * @return array
     */
    private function getSensiolabVulnerabilties($fileLock)
    {
        $this->addVerboseLog('Send request to sensiolab: <info>'.$fileLock.'</info>');

        $debug = false;//set to true to log into console output
        //$debug = fopen("guzzle.log",'w+'); //to log into file
        $headers = [
                    //OPTIONS
                    'allow_redirects' => [
                        'max'             => 3,        // allow at most 10 redirects.
                        'strict'          => true,      // use "strict" RFC compliant redirects.
                        'referer'         => true,      // add a Referer header
                        'protocols'       => ['http', 'https'], // only allow http and https URLs
                        'track_redirects' => false
                    ],
                    'connect_timeout' => 20,//Use 0 to wait connection indefinitely
                    'timeout' => 30, //Use 0 to wait response indefinitely
                    'debug' => $debug,
                    //HEADERS
                    'headers'  => [
                        'Accept' => 'application/json'
                    ],
                    //UPLOAD FORM FILE
                    'multipart' => [
                                        [
                                            'name' => 'lock',
                                            'contents' => fopen($fileLock, 'r')
                                        ]
                                    ]
                    ];
        $response = null;

        try {
            $iResponse = $this->guzzle->request('POST', 'https://security.sensiolabs.org/check_lock', $headers);
            $responseBody = $iResponse->getBody()->getContents();
            //$this->info(substr($responseBody,0,200));
            $response = json_decode($responseBody, true);
        } catch (ClientException $e) {
            $this->error("ClientException!\nMessage: ".$e->getMessage());
            $colorTag = $this->getColorTagForStatusCode($e->getResponse()->getStatusCode());
            $this->line("HTTP StatusCode: <{$colorTag}>".$e->getResponse()->getStatusCode()."<{$colorTag}>");
            $this->printResponse($e->getResponse());
            $this->printRequest($e->getRequest());
        } catch (RequestException $e) {
            $this->error("RequestException!\nMessage: ".$e->getMessage());
            $this->printRequest($e->getRequest());
            if ($e->hasResponse()) {
                $colorTag = $this->getColorTagForStatusCode($e->getResponse()->getStatusCode());
                $this->line("HTTP StatusCode: <{$colorTag}>".$e->getResponse()->getStatusCode()."<{$colorTag}>");
                $this->printResponse($e->getResponse());
            }
        }

        return $response;
    }

    /**
     * @param $tuttoOk
     */
    private function sendEmail($tuttoOk)
    {
        $soggetto=Config::get('composer-security-check.mailSubjectSuccess');

        if (!$tuttoOk) {
            $soggetto=Config::get('composer-security-check.mailSubjetcAlarm');
        }

        $mail = $this->option('mail');
        if ($mail!='') {
            $validator = Validator::make(['email' => $mail], [
                'email' => 'required|email',
            ]);
            if ($validator->fails()) {
                $this->error('No valid email passed: '.$mail.'. Mail will not be sent.');
                return;
            }
            $this->line('Send email to <info>'.$mail.'</info>');

            $vul=$this->tableVulnerabilities;


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


            $this->line('email sent.');
        }
    }

    /**
     * @param            $msg
     * @param bool|false $error
     */
    private function addVerboseLog($msg, $error = false)
    {
        $verbose = $this->option('verbose');
        if ($verbose) {
            if ($error) {
                $this->error($msg);
            } else {
                $this->line($msg);
            }
        }
    }

    /**
     * @param Response $response
     */
    private function printResponse(Response $response)
    {
        $this->info('RESPONSE:');
        $headers = '';
        foreach ($response->getHeaders() as $name => $values) {
            $headers .= $name . ': ' . implode(', ', $values) . "\r\n";
        }
        $this->comment($headers);
        $this->comment($response->getBody()->getContents());
    }

    /**
     * @param Request $request
     */
    private function printRequest(Request $request)
    {
        $this->info('REQUEST:');
        $headers='';
        foreach ($request->getHeaders() as $name => $values) {
            $headers .= $name . ': ' . implode(', ', $values) . "\r\n";
        }
        $this->comment($headers);
        $this->comment($request->getBody());
    }

    /**
     * Get the color tag for the given status code.
     *
     * @param string $code
     *
     * @return string
     *
     * @see https://github.com/spatie/http-status-check/blob/master/src/CrawlLogger.php#L96
     */
    protected function getColorTagForStatusCode($code)
    {
        if (starts_with($code, '2')) {
            return 'info';
        }
        if (starts_with($code, '3')) {
            return 'comment';
        }
        return 'error';
    }
}
