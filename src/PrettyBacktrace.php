<?php 

class PrettyBacktrace{

  public static function backtraceIt($linkers = array()){

    return array_map(function ($trace) use($linkers){
      $trace['linkageToRepo'] = self::linkToRepo($trace, $linkers);
      return $trace; 
    }, debug_backtrace());
  }

  private static function linkToRepo($trace, $linkers){
      $linked = '';

      if(isset($trace['file'])){
        $fileLocation = $trace['file'];
        $linked = array_reduce($linkers, function ($result, $linker) use($fileLocation){
          return ($linker->belongsToRepository($fileLocation))?
                  $linker->generateLink($fileLocation):
                  $result;
        });
      }
      return $linked;
  }
}
