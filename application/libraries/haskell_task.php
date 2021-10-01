<?php defined('BASEPATH') OR exit('No direct script access allowed');

/* ==============================================================
 *
 * Haskell
 *
 * ==============================================================
 */




require_once('application/libraries/LanguageTask.php');

class Haskell_Task extends Task {
    public function __construct($filename, $input, $params) {
        parent::__construct($filename, $input, $params);
        $this->default_params['compileargs'] = array(
            '-Wall'
        );
    }

    public static function getVersionCommand() {
        return array('ghc --version', '/version "?([0-9._]*)/');
    }

    public function compile() {
        $src = basename($this->sourceFileName);
        $this->executableFileName = $execFileName = "$src.exe";
        $compileargs = $this->getParam('compileargs');
        $linkargs = $this->getParam('linkargs');
        $cmd = "ghc " . implode(' ', $compileargs) . " -o $execFileName $src " . implode(' ', $linkargs);
        list($output, $this->cmpinfo) = $this->run_in_sandbox($cmd);
    }

    // A default name for Haskell programs
    public function defaultFileName($sourcecode) {
        return 'prog.hs';
    }

    // The executable is the output from the compilation
    public function getExecutablePath() {
        return "./" . $this->executableFileName;
    }

    public function getTargetFile() {
        return '';
    }
};
