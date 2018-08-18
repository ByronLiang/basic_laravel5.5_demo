<?php

namespace App\Listeners;

use Illuminate\Database\Events\QueryExecuted;

class QueryListener
{
    private $printSqlLogEnv;

    /**
     * Create the event listener.
     */
    public function __construct()
    {
        $this->printSqlLogEnv = $printSqlLog = env('PRINT_SQL_LOG');
    }

    /**
     * Handle the event.
     *
     * @param QueryExecuted $event
     */
    public function handle(QueryExecuted $event)
    {
        $path = request()->path();
        $sql = $event->sql;
        foreach ($event->bindings as $val) {
            $sql = preg_replace('/\?/', $this->queryValueToString($val), $sql, 1);
        }
        $info = '['.date('H:i:s').']['.$path.'] '.$sql.' ['.$event->time.'ms]';
        $this->writeLog($info);
    }

    private function queryValueToString($val)
    {
        if (is_string($val)) {
            return "'{$val}'";
        } elseif (is_bool($val)) {
            return (string) (int) $val;
        } else {
            return (string) $val;
        }
    }

    private function writeLog($log)
    {
        if (true === $this->printSqlLogEnv || 'stderr' === $this->printSqlLogEnv) {
            error_log($log);
        }
        if (true === $this->printSqlLogEnv || 'log' === $this->printSqlLogEnv) {
            $file = new \SplFileObject(storage_path('logs/sql_'.date('Y-m-d').'.log'), 'a');
            $file->fwrite($log."\n");
        }
    }
}
