<?php

namespace App\View\Helper;

use Cake\Core\Configure;
use Cake\Datasource\ConnectionManager;
use Cake\ORM\TableRegistry;
use Cake\View\Helper;

/**
 * SystemInfoHelper class
 */
class SystemInfoHelper extends Helper
{
    /**
     *  getProjectVersion method
     *
     * @return string project version
     */
    public function getProjectVersion()
    {
        // Use PROJECT_VERSION environment variable or fallback
        $projectVersion = getenv('PROJECT_VERSION') ?: getenv('GIT_BRANCH');
        $lastCommit = shell_exec('git rev-parse --short HEAD');
        $lastCommit = $lastCommit ?: 'N/A';
        $projectVersion = $projectVersion ?: $lastCommit;

        return $projectVersion;
    }

    /**
     * getProjectVersions method
     *
     * @return array with project versions
     */
    public function getProjectVersions()
    {
        // Read build/version* files or use N/A as fallback
        $versions = [
            'current' => ROOT . DS . 'build' . DS . 'version',
            'deployed' => ROOT . DS . 'build' . DS . 'version.ok',
            'previous' => ROOT . DS . 'build' . DS . 'version.bak',
        ];
        foreach ($versions as $version => $file) {
            if (is_readable($file)) {
                $versions[$version] = file_get_contents($file);
            } else {
                $versions[$version] = 'N/A';
            }
        }

        return $versions;
    }

    /**
     * getProjectUrl method
     *
     * @return string project's URL
     */
    public function getProjectUrl()
    {
        // Use PROJECT_URL environment variable or fallback URL
        $projectUrl = getenv('PROJECT_URL');
        $projectUrl = $projectUrl ?: \Cake\Routing\Router::fullBaseUrl();
        $projectUrl = $projectUrl ?: 'https://github.com/QoboLtd/project-template-cakephp';

        return $projectUrl;
    }

    /**
     * getProjectName method
     *
     * @return string project name
     */
    public function getProjectName()
    {
        // Use PROJECT_NAME environment variable or project folder name
        $projectName = getenv('PROJECT_NAME') ?: basename(ROOT);

        return $projectName;
    }

    /**
     * getTableStats method
     *
     * @return array with table stats
     */
    public function getTableStats()
    {
        //
        // Statistics
        //
        $allTables = $this->getAllTables();
        $skipTables = 0;
        $tableStats = [];
        foreach ($allTables as $table) {
            // Skip phinx database schema version tables
            if (preg_match('/phinxlog/', $table)) {
                $skipTables++;
                continue;
            }
            // Bypassing any CakePHP logic for permissions, pagination, and so on,
            // and executing raw query to get reliable data.
            $sth = ConnectionManager::get('default')->execute("SELECT COUNT(*) AS total FROM `$table`");
            $result = $sth->fetch('assoc');
            $tableStats[$table]['total'] = $result['total'];

            $tableInstance = TableRegistry::get($table);
            $tableStats[$table]['deleted'] = 0;
            if ($tableInstance->hasField('trashed')) {
                $sth = ConnectionManager::get('default')->execute("SELECT COUNT(*) AS deleted FROM `$table` WHERE `trashed` IS NOT NULL AND `trashed` <> '0000-00-00 00:00:00'");
                $result = $sth->fetch('assoc');
                $tableStats[$table]['deleted'] = $result['deleted'];
            }
        }

        return [$skipTables, $tableStats];
    }

    /**
     * getAllTables method
     *
     * @return array of all tables in the database
     */
    public function getAllTables()
    {
        $allTables = ConnectionManager::get('default')->schemaCollection()->listTables();

        return $allTables;
    }

    /**
     * getProgressValue method
     *
     * @param int $progress value
     * @param int $total value
     * @return int progress result
     */
    public function getProgressValue($progress, $total)
    {
        $result = '0%';

        if (!$progress || !$total) {
            return $result;
        }

        $result = number_format(100 * $progress / $total, 0) . '%';

        return $result;
    }
}
