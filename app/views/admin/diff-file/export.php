<?php


            $f = fopen('php://memory', 'w'); 
            
            foreach($data as $each) {
                fwrite($f, $each);
            }
            // var_dump($filename);
            // exit;
            // die;
            fseek($f, 0); 
            
            // Set headers to download file rather than displayed 
            header('Content-Type: text/plain'); 
            header("Content-Disposition: attachment; filename=$filename"); 
            
            // Output all remaining data on a file pointer 
            fpassthru($f);
      
            fclose($f);