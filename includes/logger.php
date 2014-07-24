<?php 

/**
* Logger Class
* This class was not tested yet.
*/
class Logger
{
  
  private $log_file;
  private $file_handle;

  function __construct($log_file)
  {
    $this->log_file = $log_file;
    $this->open_file();
  }

  public function log($action = '', $message = '')
  {
    if ($this->handle) {
      $time = strftime("%d/%m/%y %h:%m:%s", time());
      fwrite($this->handle, $time ." | {$action}: ${message}\n");
    } else {
      echo "Could not write to log file. Check if file is open.";
    }
  }

  public function clear_log()
  {
    $this->close();
    unlink($this->log_file);
  }

  public function close($value='')
  {
    fclose($this->file_handle);
  }

  private function open_file()
  {
    $this->file_handle = fopen(SITE_ROOT.DS.'logs'.DS.$this->log_file, 'a');
  }
}